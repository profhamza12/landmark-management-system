<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\InventoryEntryRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\InventoryEntry;
use App\Models\Admin\InventoryEntryDetail;
use App\Models\Admin\ItemUnitDetail;
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

class InventoryEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory_entries = getAllInventoryEntries();
        return view('admin.inventory_entries.index', compact('inventory_entries'));
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
        return view('admin.inventory_entries.create', compact('stores', 'branches'));
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
    public function store(InventoryEntryRequest $request)
    {
        try {
            DB::beginTransaction();
            $inventory_entry = InventoryEntry::create([
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'created_at' => now()
            ]);
            $items = getActivatedItems();
            $details = [];
            foreach($items as $item)
            {
                $details[] = [
                    'inventory_entry_id' => $inventory_entry->id,
                    'item_id' => $item->id
                ];
            }
            InventoryEntryDetail::insert($details);
            DB::commit();
            return redirect()->route('inventory_entries.index')->with(['success' => trans('content.inventoryentrysuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('inventory_entries.index')->with(['error' => trans('content.inventoryentryfailed')]);
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
        $inventory_entry = InventoryEntry::find($id);
        if (!empty($inventory_entry))
        {
            $inventory_entry_details = $inventory_entry->InventoryEntryDetails;
            $store_quantities = StoreQuantity::where('store_id', $inventory_entry->store_id)->get();
            return view('admin.inventory_entries.show', compact('inventory_entry', 'inventory_entry_details', 'store_quantities'));
        }
        return redirect()->route('inventory_entries.index')->with(['error' => trans('content.inventoryentryNotFound')]);
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
    public function update(PayableEntryRequest $request, $id)
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
            $inventory_entry = InventoryEntry::find($request->id);
            if (!empty($inventory_entry))
            {
                $inventory_entry->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.inventoryentrydeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.inventoryentryNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.inventoryentrydeleteFailed')
            ], 405);
        }
    }

}
