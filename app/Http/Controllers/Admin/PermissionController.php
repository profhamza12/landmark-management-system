<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\Admin\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = getAllPermissions();
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        return view('admin.permissions.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            $permission = Permission::create([
                'display_name' => $request->permission['display_name'],
                'description' => $request->permission['description'],
                'name' => $request->name,
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('permissions.index')->with(['success' => trans('content.permissionsuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('permissions.index')->with(['error' => trans('content.permissionerrormsg')]);
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
        $permission = Permission::find($id);
        if (!empty($permission))
        {
            $languages = getActivatedLanguages();
            $translations = $permission->getTranslations();
            return view('admin.permissions.edit', compact('permission', 'languages', 'translations'));
        }
        return redirect()->route('permissions.index')->with(['error' => trans('content.permissionNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $permission = Permission::find($id);
            if (!empty($permission))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $permission->update([
                    'name' => $request->name,
                    'display_name' => $request->permission['display_name'],
                    'description' => $request->permission['description'],
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('permissions.index')->with(['success' => trans('content.permissionUpdateSuccess')]);
            }
            return redirect()->route('permissions.index')->with(['error' => trans('content.permissionNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('permissions.index')->with(['error' => trans('content.permissionUpdateError')]);
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
            $permission = Permission::find($request->id);
            if (!empty($permission))
            {
                $permission->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.permissiondeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.permissionNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $ex->getMessage()
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $permission = Permission::find($request->id);
            if ($permission->active == 0)
            {
                $permission->active = 1;
                $permission->save();
                $msg = trans('content.activePermissionstate');
                $active = 1;
            }
            else
            {
                $permission->active = 0;
                $permission->save();
                $msg = trans('content.unactivePermissionstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $permission->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activatePermissionFailed")
            ], 405);
        }
    }
}
