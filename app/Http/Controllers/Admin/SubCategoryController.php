<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCatRequest;
use App\Models\Admin\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCats = getDirectChildSubCats();
        return view('admin.sub-categories.index', compact('subCats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        $mainCats = getActivatedMainCats();
        $subCats = getActivatedSubCats();
        return view('admin.sub-categories.create', compact('languages', 'mainCats', 'subCats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCatRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            $imageName = saveImage($request->photo, "sub-categories");
            SubCategory::create([
                'name' => $request->subcat['name'],
                'description' => $request->subcat['description'],
                'photo' => $imageName,
                'cat_id' => $request->mainCat,
                'parent_id' => $request->subCat,
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('sub-categories.index')->with(['success' => trans('content.subcataddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('sub-categories.index')->with(['error' => trans('content.subcataddfailed')]);
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
        $subCat = SubCategory::find($id);
        if (!empty($subCat))
        {
            $subCats = $subCat->DirectSubCategories;
            if (count($subCats) > 0)
            {
                return view('admin.sub-categories.show', compact('subCat', 'subCats'));
            }
            return redirect()->route('sub-categories.index')->with(['error' => trans('content.notHaveDescendants')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subCat = SubCategory::Selection()->find($id);
        if (!empty($subCat))
        {
            $translations = $subCat->getTranslations();
            $languages = getActivatedLanguages();
            $mainCats = getActivatedMainCats();
            $subCats = getActivatedSubCats();
            $parent_subCat = $subCat->parentSubCategory;
            return view('admin.sub-categories.edit', compact('subCat', 'translations', 'languages', 'mainCats', 'subCats', 'parent_subCat'));
        }
        return redirect()->route('sub-categories.index')->with(['error' => trans('content.subcatNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCatRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $subCat = SubCategory::Selection()->find($id);
            if (!empty($subCat))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $imageName = ($request->has('photo')) ? saveImage($request->photo, "sub-categories") : $subCat->photo;
                $subCat->update([
                    'name' => $request->subcat['name'],
                    'description' => $request->subcat['description'],
                    'photo' => $imageName,
                    'cat_id' => $request->mainCat,
                    'parent_id' => $request->subCat,
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('sub-categories.index')->with(['success' => trans('content.subcateditsuccess')]);
            }
            return redirect()->route('sub-categories.index')->with(['error' => trans('content.subcatNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('sub-categories.index')->with(['error' => trans('content.subcateditfailed')]);
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
            $subCat = SubCategory::find($request->id);
            if (!empty($subCat))
            {
                $subCat->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.subcatdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.subcatNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.deleteSubCatFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $subCat = SubCategory::find($request->id);
            if ($subCat->active == 0)
            {
                $subCat->active = 1;
                $subCat->save();
                $msg = trans('content.activeSubCatstate');
                $active = 1;
            }
            else
            {
                $subCat->active = 0;
                $subCat->save();
                $msg = trans('content.unactiveSubCatstate');
                $active = 0;
            }
            if (count($subCat->descendants) > 0)
            {
                foreach ($subCat->descendants as $cat)
                {
                    $cat->active = $active;
                    $cat->save();
                }
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $subCat->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateSubCatFailed")
            ], 405);
        }
    }
}
