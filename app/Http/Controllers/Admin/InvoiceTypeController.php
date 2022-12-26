<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientGroupRequest;
use App\Http\Requests\Admin\InvoiceTypeRequest;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Admin\ClientGroup;
use App\Models\Admin\InvoiceType;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = getAllInvoiceTypes();
        return view('admin.invoice_types.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        return view('admin.invoice_types.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            $default = InvoiceType::create([
                'name' => $request->name,
                'display_name' => $request->group['display_name'],
                'description' => $request->group['description'],
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('invoice_types.index')->with(['success' => trans('content.groupsuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('invoice_types.index')->with(['error' => trans('content.grouperrormsg')]);
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
        $group = InvoiceType::find($id);
        if (!empty($group))
        {
            $translations = $group->getTranslations();
            $languages = getActivatedLanguages();
            return view('admin.invoice_types.edit', compact('group', 'translations', 'languages'));
        }
        return redirect()->route('invoice_types.index')->with(['error' => trans('content.groupNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceTypeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $group = InvoiceType::find($id);
            if (!empty($group))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $group->update([
                    'name' => $request->name,
                    'display_name' => $request->group['display_name'],
                    'description' => $request->group['description'],
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('invoice_types.index')->with(['success' => trans('content.groupUpdateSuccess')]);
            }
            return redirect()->route('invoice_types.index')->with(['error' => trans('content.groupNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('invoice_types.index')->with(['error' => trans('content.groupUpdateError')]);
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
            $group = InvoiceType::find($request->id);
            if (!empty($group))
            {
                $group->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.groupdeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.groupNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.groupdeletefailed')
            ], 405);
        }
    }
}
