<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
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

class PayableEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payable_entries = getAllPayableEntries();
        return view('admin.payable_entries.index', compact('payable_entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = getActivatedClients();
        $branches = getActivatedCompanyBranches();
        $stores = getActivatedStores();
        $items = getAllItems();
        $units = getActivatedUnits();
        return view('admin.payable_entries.create', compact( 'clients', 'stores', 'items', 'units', 'branches'));
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
    public function store(PayableEntryRequest $request)
    {
        try {
            $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
            if (!$isValid)
            {
                return redirect()->route('payable_entries.create')->with('error', trans('content.errorInput'));
            }
            DB::beginTransaction();
            $payable_entry = PayableEntry::create([
                'client_id' => $request->client,
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'created_at' => now()
            ]);
            $payable_quantities = [];
            $items = [];
            foreach ($request->store_quantity as $_item)
            {
                $small_unit = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_item_count', 1)->first();
                $small_unit = $small_unit->Unit;
                $unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                if (!in_array($_item['item'], $items))
                {
                    $items[] = $_item['item'];
                    $payable_quantities[$_item['item']] = [
                        'payable_entry_id' => $payable_entry->id,
                        'item_id' => $_item['item'],
                        'unit_id' => $small_unit->id,
                        'quantity' => $_item['quantity'] * $unit_detail->unit_item_count,
                    ];
                }
                else
                {
                    $payable_quantities[$_item['item']]['quantity'] += $_item['quantity'] * $unit_detail->unit_item_count;
                }
            }
            PayableEntryDetail::insert($payable_quantities);
            foreach($payable_quantities as $_item) {
                $storeQuantity = StoreQuantity::where('store_id', $request->store)->where('item_id', $_item['item_id'])->first();
                if (!empty($storeQuantity)) {
                    if ($storeQuantity->quantity < $_item['quantity']) {
                        return redirect()->route('payable_entries.create')->with('error', trans('content.errorPayableQuntityCount'));
                    }
                }
                else
                {
                    return redirect()->route('payable_entries.create')->with('error', trans('content.errorPayableQuntityCount'));
                }
            }
            DB::commit();
            return redirect()->route('payable_entries.index')->with(['success' => trans('content.payableentrysuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('payable_entries.index')->with(['error' => trans('content.payableentryfailed')]);
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
        $payable_entry = PayableEntry::find($id);
        if (!empty($payable_entry))
        {
            $payable_entry_details = $payable_entry->PayableEntryDetails;
            return view('admin.payable_entries.show', compact('payable_entry', 'payable_entry_details'));
        }
        return redirect()->route('payable_entries.index')->with(['error' => trans('content.payableentryNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payable_entry = PayableEntry::find($id);
        if (!empty($payable_entry))
        {
            $stores = getActivatedStores();
            $branches = getActivatedCompanyBranches();
            $clients = getActivatedClients();
            $units = getActivatedUnits();
            $items = getActivatedItems();
            $payable_entry_details = $payable_entry->PayableEntryDetails;
            return view('admin.payable_entries.edit', compact('payable_entry', 'stores', 'units', 'items', 'payable_entry_details', 'clients', 'branches'));
        }
        return redirect()->route('payable_entries.index')->with(['error' => trans('content.payableentryNotFound')]);
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
        try {
            DB::beginTransaction();
            $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
            if (!$isValid)
            {
                return redirect()->route('payable_entries.edit', $id)->with('error', trans('content.errorInput'));
            }
            $payable_entry = PayableEntry::find($id);
            if (!empty($payable_entry))
            {
                $payable_entry->update([
                    'client_id' => $request->client,
                    'branch_id' => $request->branch,
                    'store_id' => $request->store,
                    'created_at' => now(),
                ]);
                $payable_entry->PayableEntryDetails()->delete();
                $payable_quantities = [];
                $items = [];
                foreach ($request->store_quantity as $_item)
                {
                    $small_unit = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_item_count', 1)->first();
                    $small_unit = $small_unit->Unit;
                    $unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                    if (!in_array($_item['item'], $items))
                    {
                        $items[] = $_item['item'];
                        $payable_quantities[$_item['item']] = [
                            'payable_entry_id' => $payable_entry->id,
                            'item_id' => $_item['item'],
                            'unit_id' => $small_unit->id,
                            'quantity' => $_item['quantity'] * $unit_detail->unit_item_count,
                        ];
                    }
                    else
                    {
                        $payable_quantities[$_item['item']]['quantity'] += $_item['quantity'] * $unit_detail->unit_item_count;
                    }
                }
                PayableEntryDetail::insert($payable_quantities);
                foreach($payable_quantities as $_item)
                {
                    $storeQuantity = StoreQuantity::where('store_id', $request->store)->where('item_id', $_item['item_id'])->first();
                    if (!empty($storeQuantity))
                    {
                        if ($storeQuantity->quantity < $_item['quantity'])
                        {
                            return redirect()->route('payable_entries.edit', $id)->with('error', trans('content.errorPayableQuntityCount'));
                        }
                    }
                    else
                    {
                        return redirect()->route('payable_entries.edit', $id)->with('error', trans('content.errorPayableQuntityCount'));
                    }
                }
                Db::commit();
                return redirect()->route('payable_entries.index')->with(['success' => trans('content.payableentryeditsuccess')]);
            }
            return redirect()->route('payable_entries.index')->with(['error' => trans('content.payableentryNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('payable_entries.index')->with(['error' => trans('content.payableentryediterror')]);
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
            $payable_entry = PayableEntry::find($request->id);
            if (!empty($payable_entry))
            {
                $payable_entry->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.entrydeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.payableentryNotFound')
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
            $payable_entry = PayableEntry::find($request->id);
            if (!empty($payable_entry))
            {
                $payable_entry->relayed = 1;
                $payable_entry->save();
                $details = $payable_entry->PayableEntryDetails;
                foreach($details as $_item) {
                $storeQuantity = StoreQuantity::where('store_id', $payable_entry->store_id)->where('item_id', $_item->item_id)->first();
                if (!empty($storeQuantity)) {
                    if ($storeQuantity->quantity >= $_item->quantity) {
                        $storeQuantity->quantity = $storeQuantity->quantity - $_item->quantity;
                        $storeQuantity->save();
                    }
                    else
                    {
                        return redirect()->route('payable_entries.create')->with('error', trans('content.errorPayableQuntityCount'));
                    }
                }
                else
                {
                    return redirect()->route('payable_entries.create')->with('error', trans('content.errorPayableQuntityCount'));
                }
            }
                Db::commit();
                return response()->json([
                    'success' => true,
                    'id' => $payable_entry->id,
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
