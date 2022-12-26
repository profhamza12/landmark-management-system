<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\Item;
use App\Models\Admin\ItemUnitDetail;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\StoreTransQuantity;
use App\Models\Admin\StoreTransQuantityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_trans_operations = getAllTransOperations();
        return view('admin.trans_quantity.index', compact('store_trans_operations'));
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
        $units = getActivatedUnits();
        $items = getActivatedItems();
        return view('admin.trans_quantity.create', compact('branches', 'stores', 'units', 'items'));
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


    private function checkUniqueData($request)
    {
        if ($request->has('src_store') && $request->has('dest_store'))
        {
            if ($request->src_store == $request->dest_store)
            {
                return false;
            }
        }
        return true;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransQuantityRequest $request)
    {
        try {
            DB::beginTransaction();
            $isValid = $this->checkUniqueData($request);
            if (!$isValid)
            {
                return redirect()->route('trans_quantity.create')->with('error', trans('content.errorInput'));
            }
            foreach($request->store_quantity as $_item)
            {
                $storeQuantity = StoreQuantity::where('store_id', $request->src_store)->where('item_id', $_item['item'])->first();
                $item_unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                if ($storeQuantity->quantity < $_item['quantity'] * $item_unit_detail->unit_item_count)
                {
                    return redirect()->route('trans_quantity.create')->with('error', trans('content.errorQuntityCount'));
                }
            }
            $operation = StoreTransQuantity::create([
                'branch_id' => $request->branch,
                'src_store' => $request->src_store,
                'dest_store' => $request->dest_store,
                'created_at' => now()
            ]);
            $items = [];
            $store_trans_quantity = [];
            foreach ($request->store_quantity as $_item)
            {
                $item = Item::where('id', $_item['item'])->first();
                $smallUnit = $item->getSmallUnit();
                $item_unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                if (!in_array($_item['item'], $items))
                {
                    $items[] = $_item['item'];
                    $store_trans_quantity[$_item['item']] = [
                        'trans_operation_id' => $operation->id,
                        'item_id' => $_item['item'],
                        'unit_id' => $smallUnit->Unit->id,
                        'quantity' => $_item['quantity'] * $item_unit_detail->unit_item_count,
                    ];
                }
                else
                {
                    $store_trans_quantity[$_item['item']]['quantity'] += $_item['quantity'] * $item_unit_detail->unit_item_count;
                }
            }
            StoreTransQuantityDetail::insert($store_trans_quantity);
            DB::commit();
            return redirect()->route('trans_quantity.index')->with(['success' => trans('content.transquantitysuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('trans_quantity.index')->with(['error' => trans('content.transquantityfailed')]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store_trans_operation = StoreTransQuantity::find($id);
        if (!empty($store_trans_operation))
        {
            $branches = getActivatedCompanyBranches();
            $stores = getActivatedStores();
            $units = getActivatedUnits();
            $operation_details = $store_trans_operation->StoreTransQuantities;
            $items = getActivatedItems();
            return view('admin.trans_quantity.edit', compact('store_trans_operation', 'branches', 'stores', 'units', 'items', 'operation_details'));
        }
        return redirect()->route('trans_quantity.index')->with(['error' => trans('content.storeTransNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransQuantityRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $isValid = $this->checkUniqueData($request);
            if (!$isValid)
            {
                return redirect()->route('trans_quantity.create')->with('error', trans('content.errorInput'));
            }
            foreach($request->store_quantity as $_item)
            {
                $storeQuantity = StoreQuantity::where('store_id', $request->src_store)->where('item_id', $_item['item'])->first();
                $item_unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                if ($storeQuantity->quantity < $_item['quantity'] * $item_unit_detail->unit_item_count)
                {
                    return redirect()->route('trans_quantity.create')->with('error', trans('content.errorQuntityCount'));
                }
            }
            $store_trans_operation = StoreTransQuantity::find($id);
            if (!empty($store_trans_operation))
            {
                $store_trans_operation->update([
                    'branch_id' => $request->branch,
                    'src_store' => $request->src_store,
                    'dest_store' => $request->dest_store,
                    'created_at' => now()
                ]);
                $store_trans_operation->StoreTransQuantities()->delete();
                $items = [];
                $store_trans_quantity = [];
                foreach ($request->store_quantity as $_item)
                {
                    $item = Item::where('id', $_item['item'])->first();
                    $smallUnit = $item->getSmallUnit();
                    $item_unit_detail = ItemUnitDetail::where('item_id', $_item['item'])->where('unit_id', $_item['unit'])->first();
                    if (!in_array($_item['item'], $items))
                    {
                        $items[] = $_item['item'];
                        $store_trans_quantity[$_item['item']] = [
                            'trans_operation_id' => $store_trans_operation->id,
                            'item_id' => $_item['item'],
                            'unit_id' => $smallUnit->Unit->id,
                            'quantity' => $_item['quantity'] * $item_unit_detail->unit_item_count,
                        ];
                    }
                    else
                    {
                        $store_trans_quantity[$_item['item']]['quantity'] += $_item['quantity'] * $item_unit_detail->unit_item_count;
                    }
                }
                StoreTransQuantityDetail::insert($store_trans_quantity);
                DB::commit();
                return redirect()->route('trans_quantity.index')->with(['success' => trans('content.transeditsuccess')]);
            }
            return redirect()->route('trans_quantity.index')->with(['error' => trans('content.storeTransNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('trans_quantity.index')->with(['error' => trans('content.transediterror')]);
        }
    }

    public function getOperationDetail($id)
    {
        $store_trans_operation = StoreTransQuantity::find($id);
        if (!empty($store_trans_operation))
        {
            $operation_details = $store_trans_operation->StoreTransQuantities;
            return view('admin.trans_quantity.transdetail', compact('store_trans_operation', 'operation_details'));
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
            $trans_quantity = StoreTransQuantity::find($request->id);
            if (!empty($trans_quantity))
            {
                $trans_quantity->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.transdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.storeTransNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.transdeleteFailed')
            ], 405);
        }
    }

    public function relayTrans(Request $request)
    {
        try {
            DB::beginTransaction();
            $trans_quantity = StoreTransQuantity::find($request->id);
            if (!empty($trans_quantity))
            {
                $trans_quantity->relayed = 1;
                $trans_quantity->save();
                $store_trans_details = $trans_quantity->StoreTransQuantities;
                foreach($store_trans_details as $_item)
                {
                    $storeQuantity = StoreQuantity::where('store_id', $trans_quantity->src_store)->where('item_id', $_item->item_id)->first();
                    $item_unit_detail = ItemUnitDetail::where('item_id', $_item->item_id)->where('unit_id', $_item->unit_id)->first();
                    if ($storeQuantity->quantity >= ($_item->quantity * $item_unit_detail->unit_item_count))
                    {
                        $storeQuantity->quantity =  $storeQuantity->quantity - ($_item->quantity * $item_unit_detail->unit_item_count);
                        $storeQuantity->save();
                    }
                    else
                    {
                        return response()->json([
                            'success' => false,
                            'msg' => trans("content.errQuantity")
                        ], 400);
                    }
                    $storeQuantity = StoreQuantity::where('store_id', $trans_quantity->dest_store)->where('item_id', $_item->item_id)->first();
                    if (!empty($storeQuantity))
                    {
                        $storeQuantity->quantity =  $storeQuantity->quantity + ($_item->quantity * $item_unit_detail->unit_item_count);
                        $storeQuantity->save();
                    }
                    else
                    {
                        StoreQuantity::create([
                            'branch_id' => $trans_quantity->branch_id,
                            'item_id' => $_item->item_id,
                            'store_id' => $trans_quantity->dest_store,
                            'quantity' => $_item->quantity * $item_unit_detail->unit_item_count,
                        ]);
                    }
                }
                Db::commit();
                return response()->json([
                    'success' => true,
                    'id' => $trans_quantity->id,
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
