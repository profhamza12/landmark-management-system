<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\InventoryEntryRequest;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\PriceOfferRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Client;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\InventoryEntry;
use App\Models\Admin\InventoryEntryDetail;
use App\Models\Admin\ItemUnitDetail;
use App\Models\Admin\PayableEntry;
use App\Models\Admin\PayableEntryItem;
use App\Models\Admin\PayableEntryDetail;
use App\Models\Admin\PriceOffer;
use App\Models\Admin\PriceOfferDetail;
use App\Models\Admin\Role;
use App\Models\Admin\SalesInvoice;
use App\Models\Admin\SalesInvoiceItem;
use App\Models\Admin\Store;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\StoreTransQuantity;
use App\Models\Admin\StoreTransQuantityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = getAllSalesInvoices();
        return view('admin.sales_invoices.index', compact('invoices'));
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
        $clients = getActivatedClients();
        $items = getActivatedItems();
        $units = getActivatedUnits();
        $invoice_types = getAllInvoiceTypes();
        return view('admin.sales_invoices.create', compact('invoice_types','units','clients','stores', 'branches', 'items'));
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

    public function getUnitDetail(Request $request)
    {
        $unit_detail = ItemUnitDetail::where("unit_id", $request->unit_id)->where("item_id", $request->item_id)->first();
        if (!empty($unit_detail))
        {
            return response()->json([
                'success' => true,
                'selling_price' => $unit_detail->selling_price * $request->quantity,
            ], 200);
        }
        return $request;
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

    private function checkUniqueData($arr, $key1, $key2 = null, $key3 = null)
    {
        $src = [];
        $dest = [];
        foreach ($arr as $index => $item)
        {
            $src[] = $item[$key1];
            if (!empty($key2))
            {
                $src[] = $item[$key2];
            }
            if (!empty($key3))
            {
                $src[] = $item[$key3];
            }
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
    public function store(InvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('store_quantity'))
            {
                $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
                if (!$isValid)
                {
                    return redirect()->route('sales_invoices.create')->with('error', trans('content.errorInput'));
                }
            }
            $client = Client::find($request->client);
            if ($client->InvoiceType->name == "interval_pay")
            {
                if (($client->debtor_amount + $request->remaining_amount) > $client->credit_limit)
                {
                   return redirect()->route('sales_invoices.create')->with(['error' => trans('content.cantcreateinvoice')]);
                }
            }
            if ($request->discount == null)
            {
                $request->discount = 0;
            }
            if ($request->paid_amount == null)
            {
                $request->paid_amount = 0;
            }
            $invoice = SalesInvoice::create([
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'client_id' => $request->client,
                'invoice_type' => $request->invoice_type,
                'total_amount' => $request->total_amount,
                'discount' => $request->discount,
                'remaining_amount' => $request->remaining_amount,
                'paid_amount' => $request->paid_amount,
                'created_at' => now()
            ]);
            $details = [];
            $items = [];
            foreach ($request->store_quantity as $store_quantity)
            {
                $unit_detail = ItemUnitDetail::where('item_id', $store_quantity['item'])->where('unit_id', $store_quantity['unit'])->first();
                if (!empty($unit_detail))
                {
                    if (!in_array($store_quantity['item'], $items))
                    {
                        $items[] = $store_quantity['item'];
                        $details[$store_quantity['item']] = [
                            'sales_invoice_id' => $invoice->id,
                            'item_id' => $store_quantity['item'],
                            'quantity' => $store_quantity['quantity'] * $unit_detail->unit_item_count,
                        ];
                    }
                    else
                    {
                        $details[$store_quantity['item']]['quantity'] += ($store_quantity['quantity'] * $unit_detail->unit_item_count);
                    }
                }
            }
            foreach ($details as $detail)
            {
                $store = StoreQuantity::where('store_id', $request->store)->where('item_id', $detail['item_id'])->first();
                if ($detail['quantity'] > $store->quantity)
                {
                    return redirect()->route('sales_invoices.create')->with(['error' => trans('content.errQuantity')]);
                }
            }
            SalesInvoiceItem::insert($details);
            DB::commit();
            return redirect()->route('sales_invoices.index')->with(['success' => trans('content.invoicesuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('sales_invoices.index')->with(['error' => trans('content.invoicefailed')]);
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
        $invoice = SalesInvoice::find($id);
        if (!empty($invoice))
        {
            $invoice_items = $invoice->SalesInvoiceItems;
            return view('admin.sales_invoices.show', compact('invoice_items', 'invoice'));
        }
        return redirect()->route('sales_invoices.index')->with(['error' => trans('content.invoiceNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = SalesInvoice::find($id);
        if (!empty($invoice))
        {
            $branches = getActivatedCompanyBranches();
            $stores = getActivatedStores();
            $clients = getActivatedClients();
            $items = getActivatedItems();
            $units = getActivatedUnits();
            $invoice_types = getAllInvoiceTypes();
            $invoice_items = $invoice->SalesInvoiceItems;
            $small_unit = $invoice_items[0]->Item->getSmallUnit()->Unit;
            return view('admin.sales_invoices.edit', compact('invoice_types','units','clients','stores', 'branches', 'items', 'small_unit', 'invoice', 'invoice_items'));
        }
        return redirect()->route('sales_invoices.index')->with(['error' => trans('content.invoiceNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            if ($request->has('store_quantity'))
            {
                $isValid = $this->checkUniqueData($request->store_quantity, 'item', 'unit');
                if (!$isValid)
                {
                    return redirect()->route('sales_invoices.edit', $id)->with('error', trans('content.errorInput'));
                }
            }
            $client = Client::find($request->client);
            if ($client->InvoiceType->name == "interval_pay")
            {
                if (($client->debtor_amount + $request->remaining_amount) > $client->credit_limit)
                {
                    return redirect()->route('sales_invoices.edit', $id)->with(['error' => trans('content.cantcreateinvoice')]);
                }
            }
            if ($request->discount == null)
            {
                $request->discount = 0;
            }
            if ($request->paid_amount == null)
            {
                $request->paid_amount = 0;
            }
            $invoice = SalesInvoice::find($id);
            if (!empty($invoice))
            {
                $invoice->update([
                    'branch_id' => $request->branch,
                    'store_id' => $request->store,
                    'client_id' => $request->client,
                    'invoice_type' => $request->invoice_type,
                    'total_amount' => $request->total_amount,
                    'discount' => $request->discount,
                    'remaining_amount' => $request->remaining_amount,
                    'paid_amount' => $request->paid_amount,
                    'updated_at' => now()
                ]);
                $invoice->SalesInvoiceItems()->delete();
                $details = [];
                $items = [];
                foreach ($request->store_quantity as $store_quantity)
                {
                    $unit_detail = ItemUnitDetail::where('item_id', $store_quantity['item'])->where('unit_id', $store_quantity['unit'])->first();
                    if (!empty($unit_detail))
                    {
                        if (!in_array($store_quantity['item'], $items))
                        {
                            $items[] = $store_quantity['item'];
                            $details[$store_quantity['item']] = [
                                'sales_invoice_id' => $invoice->id,
                                'item_id' => $store_quantity['item'],
                                'quantity' => $store_quantity['quantity'] * $unit_detail->unit_item_count,
                            ];
                        }
                        else
                        {
                            $details[$store_quantity['item']]['quantity'] += ($store_quantity['quantity'] * $unit_detail->unit_item_count);
                        }
                    }
                }
                foreach ($details as $detail)
                {
                    $store = StoreQuantity::where('store_id', $request->store)->where('item_id', $detail['item_id'])->first();
                    if ($detail['quantity'] > $store->quantity)
                    {
                        return redirect()->route('sales_invoices.create')->with(['error' => trans('content.errQuantity')]);
                    }
                }
                SalesInvoiceItem::insert($details);
                DB::commit();
                return redirect()->route('sales_invoices.index')->with(['success' => trans('content.invoiceeditsuccess')]);
            }
            return redirect()->route('sales_invoices.index')->with(['error' => trans('content.invoiceNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('sales_invoices.index')->with(['error' => trans('content.invoiceeditfailed')]);
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
            $invoice = SalesInvoice::find($request->id);
            if (!empty($invoice))
            {
                $invoice->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.invoicedeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.invoiceNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.invoicedeleteFailed')
            ], 405);
        }
    }

    public function relayInvoice(Request $request)
    {
        try {
            DB::beginTransaction();
            $invoice = SalesInvoice::find($request->id);
            if (!empty($invoice))
            {
                $invoice->relayed = 1;
                $invoice->save();
                $client = Client::find($invoice->client_id);
                if ($client->creditor_amount > 0)
                {
                    if ($client->creditor_amount >= $invoice->remaining_amount)
                    {
                        $client->creditor_amount -= $invoice->remaining_amount;
                        $invoice->paid_amount += $invoice->remaining_amount;
                        $invoice->remaining_amount = 0;
                        $invoice->save();
                    }
                    else
                    {
                        $invoice->remaining_amount -= $client->creditor_amount;
                        $invoice->paid_amount += $client->creditor_amount;
                        $client->creditor_amount = 0;
                        $invoice->save();
                    }
                }
                $client->debtor_amount += $invoice->remaining_amount;
                $client->save();
                return response()->json([
                    'success' => true,
                    'id' => $invoice->id,
                    "msg" => trans("content.relaySuccess")
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.invoiceNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.relaySuccess')
            ], 405);
        }
    }

}
