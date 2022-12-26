<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\InventoryEntryRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\PerishableRequest;
use App\Http\Requests\Admin\PriceOfferRequest;
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
use App\Models\Admin\Perishable;
use App\Models\Admin\PerishableDetail;
use App\Models\Admin\PriceOffer;
use App\Models\Admin\PriceOfferDetail;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\StoreTransQuantity;
use App\Models\Admin\StoreTransQuantityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PerishableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perishables = getAllPerishables();
        return view('admin.perishables.index', compact('perishables'));
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
        $items = getActivatedItems();
        $units = getActivatedUnits();
        return view('admin.perishables.create-perishable', compact('stores', 'branches', 'items', 'units'));
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

    public function getStoreItems(Request $request)
    {
        $store_quantities = StoreQuantity::where('store_id', $request->id)->get();
        $data = [];
        foreach ($store_quantities as $_item)
        {
            $data[] = [
                'item_id' => $_item->item_id,
                'item_name' => $_item->Item->name
            ];
        }
        if (!empty($store_quantities))
        {
            return response()->json([
                'success' => true,
                'data' => $data,
                'lang' => getDefaultLang()
            ], 200);
        }
        return 0;
    }

    private function checkUniqueData($arr, $key1, $key2)
    {
        $src = [];
        $dest = [];
        foreach ($arr as $index => $item)
        {
            $src[] = $item[$key1];
            $src[] = $item[$key2];
            if (in_array($src, $dest))
            {
                return false;
            }
            $dest[$index] = $src;
            $src = [];
        }
        return true;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerishableRequest $request)
    {
        try {
            DB::beginTransaction();
            $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
            if (!$isValid)
            {
                return redirect()->route('perishables.create')->with('error', trans('content.errorInput'));
            }
            $perishable = Perishable::create([
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'created_at' => now()
            ]);
            $perishable_quantities = [];
            $items = [];
            foreach ($request->store_quantity as $_item)
            {
                $small_unit = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_item_count', 1)->first();
                $small_unit = $small_unit->Unit;
                $unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                if (!in_array($_item['item'], $items))
                {
                    $items[] = $_item['item'];
                    $perishable_quantities[$_item['item']] = [
                        'perishable_id' => $perishable->id,
                        'item_id' => $_item['item'],
                        'unit_id' => $small_unit->id,
                        'quantity' => $_item['quantity'] * $unit_detail->unit_item_count,
                    ];
                }
                else
                {
                    $perishable_quantities[$_item['item']]['quantity'] += $_item['quantity'] * $unit_detail->unit_item_count;
                }
            }
            PerishableDetail::insert($perishable_quantities);
            foreach($perishable_quantities as $_item) {
                $storeQuantity = StoreQuantity::where('store_id', $request->store)->where('item_id', $_item['item_id'])->first();
                if (!empty($storeQuantity)) {
                    if ($storeQuantity->quantity < $_item['quantity'])
                    {
                        return redirect()->route('receivable_entries.create')->with(['error' => 'errQuantity']);
                    }
                }
                else
                {
                    return redirect()->route('receivable_entries.create')->with(['error' => 'errQuantity']);
                }
            }
            DB::commit();
            return redirect()->route('perishables.index')->with(['success' => trans('content.perishablesuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('perishables.index')->with(['error' => trans('content.perishablefailed')]);
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
        $perishable = Perishable::find($id);
        if (!empty($perishable))
        {
            $perishable_details = $perishable->PerishableDetails;
            return view('admin.perishables.show', compact('perishable_details', 'perishable'));
        }
        return redirect()->route('perishables.index')->with(['error' => trans('content.perishableNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perishable = Perishable::find($id);
        if (!empty($perishable))
        {
            $branches = getActivatedCompanyBranches();
            $stores = getActivatedStores();
            $items = getActivatedItems();
            $units = getActivatedUnits();
            $perishable_details = $perishable->PerishableDetails;
            $perishable_items = [];
            foreach ($perishable_details as $_item)
            {
                $perishable_items[] = $_item->item_id;
            }
            return view('admin.perishables.edit', compact('perishable', 'branches', 'stores', 'items', 'units', 'perishable_details', 'perishable_items'));
        }
        return redirect()->route('perishables.index')->with(['error' => trans('content.perishableNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerishableRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
            if (!$isValid)
            {
                return redirect()->route('perishables.edit', $id)->with('error', trans('content.errorInput'));
            }
            $perishable = Perishable::find($id);
            if (!empty($perishable))
            {
                $perishable->update([
                    'branch_id' => $request->branch,
                    'store_id' => $request->store,
                    'created_at' => now()
                ]);
                $perishable->PerishableDetails()->delete();
                $perishable_quantities = [];
                $items = [];
                foreach ($request->store_quantity as $_item)
                {
                    $small_unit = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_item_count', 1)->first();
                    $small_unit = $small_unit->Unit;
                    $unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                    if (!in_array($_item['item'], $items))
                    {
                        $items[] = $_item['item'];
                        $perishable_quantities[$_item['item']] = [
                            'perishable_id' => $perishable->id,
                            'item_id' => $_item['item'],
                            'unit_id' => $small_unit->id,
                            'quantity' => $_item['quantity'] * $unit_detail->unit_item_count,
                        ];
                    }
                    else
                    {
                        $perishable_quantities[$_item['item']]['quantity'] += $_item['quantity'] * $unit_detail->unit_item_count;
                    }
                }
                PerishableDetail::insert($perishable_quantities);
                foreach($perishable_quantities as $_item)
                {
                    $storeQuantity = StoreQuantity::where('store_id', $request->store)->where('item_id', $_item['item_id'])->first();
                    if (!empty($storeQuantity))
                    {
                        if ($storeQuantity->quantity < $_item['quantity'])
                        {
                            return redirect()->route('perishables.edit', $id)->with('error', trans('content.errorPerishableQuntityCount'));
                        }
                    }
                    else
                    {
                        return redirect()->route('perishables.edit', $id)->with('error', trans('content.errorPerishableQuntityCount'));
                    }
                }
                DB::commit();
                return redirect()->route('perishables.index')->with(['success' => trans('content.perishableeditsuccess')]);
            }
            return redirect()->route('perishables.index')->with(['error' => trans('content.perishableNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('perishables.index')->with(['error' => trans('content.perishableeditfailed')]);
        }
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
            $perishable = Perishable::find($request->id);
            if (!empty($perishable))
            {
                $perishable->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.entrydeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.perishableNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.entrydeleteFailed')
            ], 405);
        }
    }

    public function relayTrans(Request $request)
    {
        try {
            DB::beginTransaction();
            $perishable = Perishable::find($request->id);
            if (!empty($perishable))
            {
                $perishable->relayed = 1;
                $perishable->save();
                $details = $perishable->PerishableDetails;
                foreach($details as $_item) {
                $storeQuantity = StoreQuantity::where('store_id', $perishable->store_id)->where('item_id', $_item->item_id)->first();
                if (!empty($storeQuantity)) {
                    if ($storeQuantity->quantity >= $_item->quantity)
                    {
                        $storeQuantity->quantity = $storeQuantity->quantity - $_item->quantity;
                        $storeQuantity->save();
                    }
                    else
                    {
                        return redirect()->route('receivable_entries.create')->with(['error' => 'errQuantity']);
                    }
                }
                else
                {
                    return redirect()->route('receivable_entries.create')->with(['error' => 'errQuantity']);
                }
            }
                Db::commit();
                return response()->json([
                    'success' => true,
                    'id' => $perishable->id,
                    "msg" => trans("content.relaySuccess")
                ], 200);
            }
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                "msg" => trans("content.relayFailed")
            ], 400);
        }
    }
}
