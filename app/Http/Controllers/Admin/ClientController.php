<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Admin\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = getAllClients();
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = getActivatedClientGroups();
        $languages = getActivatedLanguages();
        $invoice_types = getAllInvoiceTypes();
        return view('admin.clients.create', compact('groups', 'languages', 'invoice_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            if ($request->debtor_amount == null)
            {
                $request->debtor_amount = 0;
            }
            if ($request->creditor_amount == null)
            {
                $request->creditor_amount = 0;
            }
            if ($request->credit_limit == null)
            {
                $request->credit_limit = 0;
            }
            $client = Client::create([
                'name' => $request->client['name'],
                'address' => $request->client['address'],
                'group_id' => $request->group_id,
                'invoice_type' => $request->invoice_type,
                'governorate' => $request->client['governorate'],
                'position' => $request->client['position'],
                'email' => $request->email,
                'creditor_amount' => $request->creditor_amount,
                'debtor_amount' => $request->debtor_amount,
                'credit_limit' => $request->credit_limit,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('clients.index')->with(['success' => trans('content.clientsuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('clients.index')->with(['error' => trans('content.clienterrormsg')]);
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
        $client = Client::find($id);
        if (!empty($client))
        {
            $sales_invoices = $client->SalesInvoices;
            return view('admin.clients.show', compact('client', 'sales_invoices'));
        }
        return redirect()->route("clients.index")->with(['error' => trans('content.clientNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::Selection()->find($id);
        $groups = getActivatedClientGroups();
        $languages = getActivatedLanguages();
        $invoice_types = getAllInvoiceTypes();
        $translations = $client->getTranslations();
        if (!empty($client))
        {
            return view('admin.clients.edit', compact('client', 'translations', 'groups', 'invoice_types', 'languages'));
        }
        return redirect()->route('clients.index')->with(['error' => trans('content.clientNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $client = Client::Selection()->find($id);
            if (!empty($client))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $client->update([
                    'name' => $request->client['name'],
                    'address' => $request->client['address'],
                    'group_id' => $request->group_id,
                    'invoice_type' => $request->invoice_type,
                    'governorate' => $request->client['governorate'],
                    'position' => $request->client['position'],
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'creditor_amount' => $request->creditor_amount,
                    'debtor_amount' => $request->debtor_amount,
                    'credit_limit' => $request->credit_limit,
                    'gender' => $request->gender,
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('clients.index')->with(['success' => trans('content.clientUpdateSuccess')]);
            }
            return redirect()->route('users.index')->with(['error' => trans('content.clientNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('clients.index')->with(['error' => trans('content.clientUpdateError')]);
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
            $client = Client::find($request->id);
            if (!empty($client))
            {
                $client->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.clientdeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.clientNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.clientdeletefailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $client = Client::find($request->id);
            if($client->active == 1)
            {
                $client->active = 0;
                $client->save();
                $msg = trans('content.unactiveClientstate');
                $active = 0;
            }
            else
            {
                $client->active = 1;
                $client->save();
                $msg = trans('content.activeClientstate');
                $active = 1;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $client->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateClientFailed")
            ], 405);
        }
    }
}
