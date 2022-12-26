<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\InventoryEntryRequest;
use App\Http\Requests\Admin\OutStockRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\InventoryEntry;
use App\Models\Admin\InventoryEntryDetail;
use App\Models\Admin\Item;
use App\Models\Admin\ItemUnitDetail;
use App\Models\Admin\OutStock;
use App\Models\Admin\OutStockDetail;
use App\Models\Admin\PayableEntry;
use App\Models\Admin\PayableEntryItem;
use App\Models\Admin\PayableEntryDetail;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\StoreTransQuantity;
use App\Models\Admin\StoreTransQuantityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OutStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $out_stocks = getAllOutStocks();
        return view('admin.out_stock.index', compact('out_stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = getActivatedCompanyBranches();
        $stores = getActivatedStores();
        return view('admin.out_stock.create', compact('stores', 'branches'));
    }

    public function getBranchStores(Request $request)
    {
        $branch = CompanyBranch::find($request->id);
        if (!empty($branch))
        {
            $stores = $branch->Stores;
            return response()->json([
                'success' => true,
                'stores' => $stores,
                'lang' => getDefaultLang()
            ], 200);
        }
        return 0;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutStockRequest $request)
    {
        try {
            DB::beginTransaction();
            $out_stock = OutStock::create([
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'created_at' => now()
            ]);
            $items = getActivatedItems();
            $details = [];
            foreach($items as $item)
            {
                $details[] = [
                    'out_stock_id' => $out_stock->id,
                    'item_id' => $item->id
                ];
            }
            OutStockDetail::insert($details);
            DB::commit();
            return redirect()->route('out_stock.index')->with(['success' => trans('content.outstockaddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('out_stock.index')->with(['error' => trans('content.outstockaddfailed')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $out_stock = OutStock::find($id);
        if (!empty($out_stock))
        {
            $out_stock_details = $out_stock->OutStockDetails;
            $store_quantities = collect(StoreQuantity::where('store_id', $out_stock->store_id)->get());
            $store_quantities = $store_quantities->filter(function ($val, $key) {
                $item = Item::where("id", $val['item_id'])->first();
                return $val['quantity'] <= $item->min_quantity;
            });
            return view('admin.out_stock.show', compact('out_stock', 'out_stock_details', 'store_quantities'));
        }
        return redirect()->route('out_stock.index')->with(['error' => trans('content.outstockNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $out_stock = OutStock::find($request->id);
            if (!empty($out_stock))
            {
                $out_stock->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.outstockdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.outstockNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.outstockdeleteFailed')
            ], 405);
        }
    }

}
