<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Admin\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = getAllEmployees();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        $branches = getActivatedCompanyBranches();
        $groups = getAllEmployeesGroups();
        return view('admin.employees.create', compact('languages', 'branches', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            $imageName = saveImage($request->photo, "employees");
            $employee = Employee::create([
                'name' => $request->employee['name'],
                'address' => $request->employee['address'],
                'position' => $request->employee['position'],
                'governorate' => $request->employee['governorate'],
                'qualification' => $request->employee['qualification'],
                'phone' => $request->phone,
                'salary' => $request->salary,
                'target' => $request->target,
                'commission' => $request->commission,
                'national_id' => $request->national_id,
                'insurance_number' => $request->insurance_number,
                'created_at' => $request->created_at,
                'date_of_birth' => $request->date_of_birth,
                'photo' => $imageName,
                'branch_id' => $request->branch,
                'gender' => $request->gender,
                'active' => $status,
            ]);
            $employee->Groups()->attach($request->groups);
            DB::commit();
            return redirect()->route('employees.index')->with(['success' => trans('content.employeesuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('employees.index')->with(['error' => trans('content.employeeerrormsg')]);
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
        $employee = Employee::Selection()->find($id);
        if (!empty($employee))
        {
            $translations = $employee->getTranslations();
            $languages = getActivatedLanguages();
            $groups = getAllEmployeesGroups();
            $branches = getActivatedCompanyBranches();
            $employee_groups = $employee->Groups->pluck('id')->toArray();
            return view('admin.employees.edit', compact('employee', 'translations', 'languages', 'groups', 'branches', 'employee_groups'));
        }
        return redirect()->route('employees.index')->with(['error' => trans('content.employeeNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::Selection()->find($id);
            if (!empty($employee))
            {
                $status = ($request->active == "on") ? 1 : 0;
                if ($request->has('photo'))
                {
                    $imageName = saveImage($request->photo, "employees");
                }
                else
                {
                    $imageName = $employee->photo;
                }
                $employee->update([
                    'name' => $request->employee['name'],
                    'address' => $request->employee['address'],
                    'position' => $request->employee['position'],
                    'governorate' => $request->employee['governorate'],
                    'qualification' => $request->employee['qualification'],
                    'phone' => $request->phone,
                    'salary' => $request->salary,
                    'target' => $request->target,
                    'commission' => $request->commission,
                    'national_id' => $request->national_id,
                    'insurance_number' => $request->insurance_number,
                    'created_at' => $request->created_at,
                    'date_of_birth' => $request->date_of_birth,
                    'photo' => $imageName,
                    'branch_id' => $request->branch,
                    'gender' => $request->gender,
                    'active' => $status,
                ]);
                $employee->Groups()->sync($request->groups);
                Db::commit();
                return redirect()->route('employees.index')->with(['success' => trans('content.employeeUpdateSuccess')]);
            }
            return redirect()->route('employees.index')->with(['error' => trans('content.employeeNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('employees.index')->with(['error' => trans('content.employeeUpdateError')]);
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
            $employee = Employee::find($request->id);
            if (!empty($employee))
            {
                $employee->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.employeedeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.employeeNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.employeedeletefailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $employee = Employee::find($request->id);
            if ($employee->active == 1)
            {
                $employee->active = 0;
                $employee->save();
                $msg = trans('content.unactiveEmployeestate');
                $active = 0;
            }
            else
            {
                $employee->active = 1;
                $employee->save();
                $msg = trans('content.activeEmployeestate');
                $active = 1;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $employee->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.unactiveEmployeeFailed")
            ], 405);
        }
    }
}
