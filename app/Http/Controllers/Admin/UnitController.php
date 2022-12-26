<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;
use App\Models\Admin\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = getAllUnits();
        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        return view('admin.units.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            Unit::create([
                'name' => $request->unit['name'],
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('units.index')->with(['success' => trans('content.unitaddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('units.index')->with(['error' => trans('content.unitaddfailed')]);
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
        $unit = Unit::Selection()->find($id);
        if (!empty($unit))
        {
            $translations = $unit->getTranslations();
            $languages = getActivatedLanguages();
            return view('admin.units.edit', compact('unit', 'translations', 'languages'));
        }
        return redirect()->route('units.index')->with(['error' => trans('content.unitNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $unit = Unit::Selection()->find($id);
            if (!empty($unit))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $unit->update([
                    'name' => $request->unit['name'],
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('units.index')->with(['success' => trans('content.uniteditsuccess')]);
            }
            return redirect()->route('units.index')->with(['error' => trans('content.unitNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('units.index')->with(['error' => trans('content.uniteditfailed')]);
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
            $unit = Unit::find($request->id);
            if (!empty($unit))
            {
                $unit->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.unitdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.unitNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.deleteUnitFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $unit = Unit::find($request->id);
            if ($unit->active == 0)
            {
                $unit->active = 1;
                $unit->save();
                $msg = trans('content.activeUnitstate');
                $active = 1;
            }
            else
            {
                $unit->active = 0;
                $unit->save();
                $msg = trans('content.unactiveUnitstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $unit->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateUnitFailed")
            ], 405);
        }
    }
}
