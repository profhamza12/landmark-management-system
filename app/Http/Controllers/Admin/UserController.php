<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Admin\Role;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = getAllUsers();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        $roles = getActivatedRoles();
        $permissions = getActivatedPermissions();
        return view('admin.users.create', compact('languages', 'roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $imageName = saveImage($request->photo, "users");
            $status = $request->active == "on" ? 1 : 0;
            $user = User::create([
                'name' => $request->user['name'],
                'address' => $request->user['address'],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'gender' => $request->gender,
                'active' => $status,
                'photo' => $imageName,
            ]);
            $user->attachRoles($request->roles);
            if($request->has('permission'))
            {
                $user->attachPermissions($request->permission);
            }
            DB::commit();
            return redirect()->route('users.index')->with(['success' => trans('content.usersuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('users.index')->with(['error' => trans('content.usererrormsg')]);
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
        $user = User::Selection()->find($id);
        if (!empty($user))
        {
            $translations = $user->getTranslations();
            $roles = getActivatedRoles();
            $languages = getActivatedLanguages();
            $permissions = getActivatedPermissions();
            return view('admin.users.edit', compact('user', 'translations', 'roles', 'languages', 'permissions'));
        }
        return redirect()->route('users.index')->with(['error' => trans('content.userNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::Selection()->find($id);
            if (!empty($user))
            {
                $imageName = ($request->has("photo")) ? saveImage($request->photo, "users") : $user->photo;
                $password = ($request->password != null) ? Hash::make($request->password) : $user->password;
                $status = ($request->active == "on") ? 1 : 0;
                $user->update([
                    'name' => $request->user['name'],
                    'address' => $request->user['address'],
                    'email' => $request->email,
                    'password' => $password,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'active' => $status,
                    'photo' => $imageName,
                ]);
                $user->syncRoles($request->roles);
                if ($request->has('permission'))
                {
                    $user->syncPermissions($request->permission);
                }
                Db::commit();
                return redirect()->route('users.index')->with(['success' => trans('content.userUpdateSuccess')]);
            }
            return redirect()->route('users.index')->with(['error' => trans('content.userNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('users.index')->with(['error' => trans('content.userUpdateError')]);
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
            $user = User::find($request->id);
            if (!empty($user))
            {
                $user->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => trans('content.userdeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => trans('content.userNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $user = User::find($request->id);
            if ($user->active == 0)
            {
                $user->active = 1;
                $user->save();
                $msg = trans('content.activeUserstate');
                $active = 1;
            }
            else
            {
                $user->active = 0;
                $user->save();
                $msg = trans('content.unactiveUserstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "message" => $msg,
                "active" => $active,
                "id" => $user->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "message" => trans("content.activateUserFailed")
            ], 405);
        }
    }
}
