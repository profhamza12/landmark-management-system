<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = getAllRoles();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        $permissions = getActivatedPermissions();
        return view('admin.roles.create', compact('languages', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->role['display_name'],
                'description' => $request->role['description'],
                'active' => $status,
            ]);
            if($request->has('permission'))
            {
                $role->attachPermissions($request->permission);
            }
            DB::commit();
            return redirect()->route('roles.index')->with(['success' => trans('content.groupsuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return $ex;
            return redirect()->route('roles.index')->with(['error' => trans('content.grouperrormsg')]);
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
        $role = Role::find($id);
        if (!empty($role))
        {
            $translations = $role->getTranslations();
            $permissions = getActivatedPermissions();
            $languages = getActivatedLanguages();
            return view('admin.roles.edit', compact('role', 'translations', 'languages', 'permissions'));
        }
        return redirect()->route('roles.index')->with(['error' => trans('content.groupNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($id);
            if (!empty($role))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $role->update([
                    'name' => $request->name,
                    'display_name' => $request->role['display_name'],
                    'description' => $request->role['description'],
                    'active' => $status,
                ]);
                if($request->has('permission'))
                {
                    $role->syncPermissions($request->permission);
                }
                Db::commit();
                return redirect()->route('roles.index')->with(['success' => trans('content.groupUpdateSuccess')]);
            }
            return redirect()->route('roles.index')->with(['error' => trans('content.groupNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('roles.index')->with(['error' => trans('content.groupUpdateError')]);
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
            $role = Role::find($request->id);
            if (!empty($role))
            {
                $role->delete();
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
                'msg' => $ex->getMessage()
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $role = Role::find($request->id);
            if ($role->active == 1)
            {
                $role->active = 0;
                $role->save();
                $msg = trans('content.unactiveGroupstate');
                $active = 0;
            }
            else
            {
                $role->active = 1;
                $role->save();
                $msg = trans('content.activeGroupstate');
                $active = 1;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $role->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateGroupFailed")
            ], 405);
        }
    }
}
