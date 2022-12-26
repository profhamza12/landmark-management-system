<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Admin\Language;
use Illuminate\Http\Request;
use App\DataTables\Admin\LanguagesDataTable;
use Yajra\DataTables\CollectionDataTable;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LanguagesDataTable $dataTable)
    {
        return $dataTable->render('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        try {
            $active = ($request->lang['active'] == "on") ? 1 : 0;
            Language::create([
                'name' => $request->lang['name'],
                'abbr' => $request->lang['abbr'],
                'direction' => $request->lang['direction'],
                'active' => $active
            ]);
            return redirect()->route('languages.index')->with(['success' => trans('admin.add_success')]);
        }
        catch(\Exception $ex)
        {
            return redirect()->route('languages.create')->with(['error' => trans('admin.add_failed')]);
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
        $language = Language::Selection()->find($id);
        if (!empty($language))
        {
            return view('admin.language.edit', compact('language'));
        }
        return redirect()->route('languages.index')->with(['error' => trans('content.langNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, $id)
    {
        try {
            $language = Language::Selection()->find($id);
            $request->active = ($request->active == "on") ? 1 : 0;
            if (!empty($language))
            {
                $language->update([
                    'name' => $request->name,
                    'abbr' => $request->abbr,
                    'direction' => $request->direction,
                    'active' => $request->active
                ]);
                return redirect()->route('languages.index')->with(['success' => trans('content.editLangSuccess')]);
            }
            return redirect()->route('languages.index')->with(['error' => trans('content.langNotFound')]);
        }
        catch(\Exception $ex)
        {
            return redirect()->route('languages.index')->with(['error' => trans('content.editLangFailed')]);
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
            $language = Language::find($request->id);
            if(!empty($language))
            {
                $language->delete();
                return response()->json([
                    "success" => true,
                    "msg" => trans('content.langdeletemsg'),
                    "id" => $request->id
                ], 200);
            }
            return response()->json([
                "success" => false,
                "msg" => trans('content.langNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans('content.deleteLangFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $language = Language::find($request->id);
            $msg = "";
            if(!empty($language))
            {
                if ($language->active == 1)
                {
                    $language->update(["active" => 0]);
                    $msg = trans('content.unactiveLangstate');
                }
                else
                {
                    $language->update(["active" => 1]);
                    $msg = trans('content.activeLangstate');
                }
                return response()->json([
                    "success" => true,
                    "msg" => $msg,
                    "active" => $language->active,
                    "id" => $request->id
                ], 200);
            }
            return response()->json([
                "success" => false,
                "msg" => trans('content.langNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans('content.activateLangFailed')
            ], 405);
        }
    }
}
