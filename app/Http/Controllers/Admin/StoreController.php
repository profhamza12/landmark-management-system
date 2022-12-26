<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = getAllStores();
        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        $storekeepers = Role::where('name', 'store-keeper')->first()->users;
        $branches = getActivatedCompanyBranches();
        return view('admin.stores.create', compact('languages', 'storekeepers', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            Store::create([
                'name' => $request->store['name'],
                'address' => $request->store['address'],
                'phone' => $request->phone,
                'store_keeper' => $request->store_keeper,
                'company_branch' => $request->company_branch,
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('stores.index')->with(['success' => trans('content.storeaddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('stores.index')->with(['error' => trans('content.storeaddfailed')]);
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
        $store = Store::Selection()->find($id);
        if (!empty($store))
        {
            $translations = $store->getTranslations();
            $languages = getActivatedLanguages();
            $storekeepers = Role::where('name', 'store-keeper')->first()->users;
            $branches = getActivatedCompanyBranches();
            return view('admin.stores.edit', compact('store', 'translations', 'languages', 'storekeepers', 'branches'));
        }
        return redirect()->route('stores.index')->with(['error' => trans('content.storeNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $store = Store::Selection()->find($id);
            if (!empty($store))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $store->update([
                    'name' => $request->store['name'],
                    'address' => $request->store['address'],
                    'phone' => $request->phone,
                    'store_keeper' => $request->store_keeper,
                    'company_branch' => $request->company_branch,
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('stores.index')->with(['success' => trans('content.storeeditsuccess')]);
            }
            return redirect()->route('stores.index')->with(['error' => trans('content.storeNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('stores.index')->with(['error' => trans('content.storeeditfailed')]);
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
            $store = Store::find($request->id);
            if (!empty($store))
            {
                $store->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.storedeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.storeNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.deleteStoreFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $store = Store::find($request->id);
            if ($store->active == 0)
            {
                $store->active = 1;
                $store->save();
                $msg = trans('content.activeStorestate');
                $active = 1;
            }
            else
            {
                $store->active = 0;
                $store->save();
                $msg = trans('content.unactiveStorestate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $store->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateStoreFailed")
            ], 405);
        }
    }
}
