<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyBranchRequest;
use App\Models\Admin\CompanyBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_branches = getAllCompanyBranches();
        return view('admin.company_branches.index', compact('company_branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        return view('admin.company_branches.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyBranchRequest $request)
    {
        try {
            DB::beginTransaction();
            $imageName = saveImage($request->photo, "company_branches");
            $status = $request->active == "on" ? 1 : 0;
            CompanyBranch::create([
                'name' => $request->branch['name'],
                'address' => $request->branch['address'],
                'country' => $request->branch['country'],
                'governorate' => $request->branch['governorate'],
                'position' => $request->branch['position'],
                'email' => $request->email,
                'website' => $request->website,
                'phone' => $request->phone,
                'activity' => $request->branch['activity'],
                'finance_year' => $request->finance_year,
                'active' => $status,
                'photo' => $imageName,
            ]);
            DB::commit();
            return redirect()->route('branches.index')->with(['success' => trans('content.branchcreatesuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('branches.index')->with(['error' => trans('content.branchcreateerror')]);
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
        $branch = CompanyBranch::Selection()->find($id);
        if (!empty($branch))
        {
            $translations = $branch->getTranslations();
            $languages = getActivatedLanguages();
            return view('admin.company_branches.edit', compact('branch', 'translations', 'languages'));
        }
        return redirect()->route('branches.index')->with(['error' => trans('content.branchNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyBranchRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $branch = CompanyBranch::Selection()->find($id);
            if (!empty($branch))
            {
                $imageName = ($request->has("photo")) ? saveImage($request->photo, "company_branches") : $branch->photo;
                $status = ($request->active == "on") ? 1 : 0;
                $branch->update([
                    'name' => $request->branch['name'],
                    'address' => $request->branch['address'],
                    'country' => $request->branch['country'],
                    'governorate' => $request->branch['governorate'],
                    'position' => $request->branch['position'],
                    'email' => $request->email,
                    'website' => $request->website,
                    'phone' => $request->phone,
                    'active' => $status,
                    'photo' => $imageName,
                    'activity' => $request->branch['activity'],
                    'finance_year' => $request->finance_year,
                ]);
                Db::commit();
                return redirect()->route('branches.index')->with(['success' => trans('content.branchUpdateSuccess')]);
            }
            return redirect()->route('branches.index')->with(['error' => trans('content.branchNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('branches.index')->with(['error' => trans('content.branchUpdateError')]);
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
            $branch = CompanyBranch::find($request->id);
            if (!empty($branch))
            {
                $branch->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.branchdeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.branchNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.branchdeleteerror')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $branch = CompanyBranch::find($request->id);
            if ($branch->active == 0)
            {
                $branch->active = 1;
                $branch->save();
                $msg = trans('content.activebranchstate');
                $active = 1;
            }
            else
            {
                $branch->active = 0;
                $branch->save();
                $msg = trans('content.unactivebranchstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $branch->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateBranchFailed")
            ], 405);
        }
    }
}
