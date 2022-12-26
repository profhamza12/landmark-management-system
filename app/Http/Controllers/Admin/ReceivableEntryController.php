<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\ReceivableEntryRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\ItemUnitDetail;
use App\Models\Admin\PayableEntry;
use App\Models\Admin\PayableEntryItem;
use App\Models\Admin\PayableEntryDetail;
use App\Models\Admin\ReceivableEntry;
use App\Models\Admin\ReceivableEntryDetail;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\StoreTransQuantity;
use App\Models\Admin\StoreTransQuantityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReceivableEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receivable_entries = getAllReceivableEntries();
        return view('admin.receivable_entries.index', compact('receivable_entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = getActivatedVendors();
        $branches = getActivatedCompanyBranches();
        $stores = getActivatedStores();
        $items = getAllItems();
        $units = getActivatedUnits();
        return view('admin.receivable_entries.create', compact( 'vendors', 'stores', 'items', 'units', 'branches'));
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
    public function store(ReceivableEntryRequest $request)
    {
        try {
            $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
            if (!$isValid)
            {
                return redirect()->route('receivable_entries.create')->with('error', trans('content.errorInput'));
            }
            DB::beginTransaction();
            $receivable_entry = ReceivableEntry::create([
                'vendor_id' => $request->vendor,
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'created_at' => now()
            ]);
            $receivable_quantities = [];
            $items = [];
            foreach ($request->store_quantity as $_item)
            {
                $small_unit = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_item_count', 1)->first();
                $small_unit = $small_unit->Unit;
                $unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                if (!in_array($_item['item'], $items))
                {
                    $items[] = $_item['item'];
                    $receivable_quantities[$_item['item']] = [
                        'receivable_entry_id' => $receivable_entry->id,
                        'item_id' => $_item['item'],
                        'unit_id' => $small_unit->id,
                        'quantity' => $_item['quantity'] * $unit_detail->unit_item_count,
                    ];
                }
                else
                {
                    $receivable_quantities[$_item['item']]['quantity'] += $_item['quantity'] * $unit_detail->unit_item_count;
                }
            }
            ReceivableEntryDetail::insert($receivable_quantities);
            DB::commit();
            return redirect()->route('receivable_entries.index')->with(['success' => trans('content.receivableentrysuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('receivable_entries.index')->with(['error' => trans('content.receivableentryfailed')]);
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
        $receivable_entry = ReceivableEntry::find($id);
        if (!empty($receivable_entry))
        {
            $receivable_entry_details = $receivable_entry->ReceivableEntryDetails;
            return view('admin.receivable_entries.show', compact('receivable_entry', 'receivable_entry_details'));
        }
        return redirect()->route('receivable_entries.index')->with(['error' => trans('content.receivableentryNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receivable_entry = ReceivableEntry::find($id);
        if (!empty($receivable_entry))
        {
            $stores = getActivatedStores();
            $branches = getActivatedCompanyBranches();
            $vendors = getActivatedVendors();
            $units = getActivatedUnits();
            $items = getActivatedItems();
            $receivable_entry_details = $receivable_entry->ReceivableEntryDetails;
            return view('admin.receivable_entries.edit', compact('receivable_entry', 'stores', 'units', 'items', 'receivable_entry_details', 'vendors', 'branches'));
        }
        return redirect()->route('receivable_entries.index')->with(['error' => trans('content.receivableentryNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReceivableEntryRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
            if (!$isValid)
            {
                return redirect()->route('receivable_entries.edit', $id)->with('error', trans('content.errorInput'));
            }
            $receivable_entry = ReceivableEntry::find($id);
            if (!empty($receivable_entry))
            {
                $receivable_entry->update([
                    'vendor_id' => $request->vendor,
                    'branch_id' => $request->branch,
                    'store_id' => $request->store,
                    'created_at' => now(),
                ]);
                $receivable_entry->ReceivableEntryDetails()->delete();
                $receivable_quantities = [];
                $items = [];
                foreach ($request->store_quantity as $_item)
                {
                    $small_unit = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_item_count', 1)->first();
                    $small_unit = $small_unit->Unit;
                    $unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                    if (!in_array($_item['item'], $items))
                    {
                        $items[] = $_item['item'];
                        $receivable_quantities[$_item['item']] = [
                            'receivable_entry_id' => $receivable_entry->id,
                            'item_id' => $_item['item'],
                            'unit_id' => $small_unit->id,
                            'quantity' => $_item['quantity'] * $unit_detail->unit_item_count,
                        ];
                    }
                    else
                    {
                        $receivable_quantities[$_item['item']]['quantity'] += $_item['quantity'] * $unit_detail->unit_item_count;
                    }
                }
                ReceivableEntryDetail::insert($receivable_quantities);
                Db::commit();
                return redirect()->route('receivable_entries.index')->with(['success' => trans('content.receivableentryeditsuccess')]);
            }
            return redirect()->route('receivable_entries.index')->with(['error' => trans('content.receivableentryNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('receivable_entries.index')->with(['error' => trans('content.receivableentryeditfailed')]);
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
            $entry = ReceivableEntry::find($request->id);
            if (!empty($entry))
            {
                $entry->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.entrydeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.receivableentryNotFound')
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
            $entry = ReceivableEntry::find($request->id);
            if (!empty($entry))
            {
                $entry->relayed = 1;
                $entry->save();
                $details = $entry->ReceivableEntryDetails;
                foreach($details as $_item) {
                    $storeQuantity = StoreQuantity::where('store_id', $entry->store_id)->where('item_id', $_item->item_id)->first();
                    if (!empty($storeQuantity)) {
                        $storeQuantity->quantity = $storeQuantity->quantity + $_item->quantity;
                        $storeQuantity->save();
                    }
                    else
                    {
                        StoreQuantity::create([
                            'branch_id' => $entry->branch_id,
                            'item_id' => $_item->item_id,
                            'store_id' => $entry->store_id,
                            'quantity' => $_item->quantity,
                        ]);
                    }
                }
                Db::commit();
                return response()->json([
                    'success' => true,
                    'id' => $entry->id,
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
