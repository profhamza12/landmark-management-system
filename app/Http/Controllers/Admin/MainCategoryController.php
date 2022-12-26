<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainCatRequest;
use App\Models\Admin\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainCats = getAllMainCats();
        return view('admin.main-categories.index', compact('mainCats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        return view('admin.main-categories.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainCatRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            $imageName = saveImage($request->photo, "main-categories");
            $mainCat = MainCategory::create([
                'name' => $request->maincat['name'],
                'description' => $request->maincat['description'],
                'photo' => $imageName,
                'sectoral_sale_rate' => $request->sectoral_sale_rate,
                'whole_sale_rate' => $request->whole_sale_rate,
                'whole_sale2_rate' => $request->whole_sale2_rate,
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('main-categories.index')->with(['success' => trans('content.maincataddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('main-categories.index')->with(['error' => trans('content.maincataddfailed')]);
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
        $mainCat = MainCategory::Selection()->find($id);
        if (!empty($mainCat))
        {
            $translations = $mainCat->getTranslations();
            $languages = getActivatedLanguages();
            return view('admin.main-categories.edit', compact('mainCat', 'translations', 'languages'));
        }
        return redirect()->route('main-categories.index')->with(['error' => trans('content.maincatNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MainCatRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $mainCat = MainCategory::Selection()->find($id);
            if (!empty($mainCat))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $imageName = ($request->has('photo')) ? saveImage($request->photo, "main-categories") : $mainCat->photo;
                $mainCat->update([
                    'name' => $request->maincat['name'],
                    'description' => $request->maincat['description'],
                    'photo' => $imageName,
                    'sectoral_sale_rate' => $request->sectoral_sale_rate,
                    'whole_sale_rate' => $request->whole_sale_rate,
                    'whole_sale2_rate' => $request->whole_sale2_rate,
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('main-categories.index')->with(['success' => trans('content.maincateditsuccess')]);
            }
            return redirect()->route('main-categories.index')->with(['error' => trans('content.maincatNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('main-categories.index')->with(['error' => trans('content.maincateditfailed')]);
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
            $mainCat = MainCategory::find($request->id);
            if (!empty($mainCat))
            {
                $mainCat->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.maincatdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.maincatNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.deleteMainCatFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $mainCat = MainCategory::find($request->id);
            if ($mainCat->active == 0)
            {
                $mainCat->active = 1;
                $mainCat->save();
                $msg = trans('content.activeMainCatstate');
                $active = 1;
            }
            else
            {
                $mainCat->active = 0;
                $mainCat->save();
                $msg = trans('content.unactiveMainCatstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $mainCat->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateMainCatFailed")
            ], 405);
        }
    }
}
