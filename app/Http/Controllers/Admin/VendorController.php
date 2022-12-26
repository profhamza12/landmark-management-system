<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\Admin\User;
use App\Models\Admin\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = getAllVendors();
        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        $invoice_types = getAllInvoiceTypes();
        return view('admin.vendors.create', compact('languages', 'invoice_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('photo'))
            {
                $imageName = saveImage($request->photo, "vendors");
            }
            $status = $request->active == "on" ? 1 : 0;
            $default = Vendor::create([
                'name' => $request->vendor['name'],
                'address' => $request->vendor['address'],
                'governorate' => $request->vendor['governorate'],
                'position' => $request->vendor['position'],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'creditor_amount' => $request->creditor_amount,
                'debtor_amount' => $request->debtor_amount,
                'invoice_type' => $request->invoice_type,
                'gender' => $request->gender,
                'active' => $status,
                'photo' => $imageName,
            ]);
            DB::commit();
            return redirect()->route('vendors.index')->with(['success' => trans('content.vendorsuccessmsg')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('users.index')->with(['error' => trans('content.vendorerrormsg')]);
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
        $vendor = Vendor::find($id);
        if (!empty($vendor))
        {
            $purchases_invoices = $vendor->PurchasesInvoices;
            return view('admin.vendors.show', compact('vendor', 'purchases_invoices'));
        }
        return redirect()->route("vendors.index")->with(['error' => trans('content.vendorNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::Selection()->find($id);
        if (!empty($vendor))
        {
            $translations = $vendor->getTranslations();
            $languages = getActivatedLanguages();
            $invoice_types = getAllInvoiceTypes();
            return view('admin.vendors.edit', compact('vendor', 'translations', 'languages', 'invoice_types'));
        }
        return redirect()->route('vendors.index')->with(['error' => trans('content.vendorNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $vendor = Vendor::Selection()->find($id);
            if (!empty($vendor))
            {
                $imageName = ($request->has("photo")) ? saveImage($request->photo, "vendors") : $vendor->photo;
                $password = ($request->password != null) ? Hash::make($request->password) : $vendor->password;
                $status = ($request->active == "on") ? 1 : 0;
                $vendor->update([
                    'name' => $request->vendor['name'],
                    'address' => $request->vendor['address'],
                    'governorate' => $request->vendor['governorate'],
                    'position' => $request->vendor['position'],
                    'email' => $request->email,
                    'password' => $password,
                    'phone' => $request->phone,
                    'creditor_amount' => $request->creditor_amount,
                    'debtor_amount' => $request->debtor_amount,
                    'invoice_type' => $request->invoice_type,
                    'gender' => $request->gender,
                    'active' => $status,
                    'photo' => $imageName,
                ]);
                Db::commit();
                return redirect()->route('vendors.index')->with(['success' => trans('content.vendorUpdateSuccess')]);
            }
            return redirect()->route('vendors.index')->with(['error' => trans('content.vendorNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return $ex;
            return redirect()->route('vendors.index')->with(['error' => trans('content.vendorUpdateError')]);
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
            $vendor = Vendor::find($request->id);
            if (!empty($vendor))
            {
                $vendor->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.vendordeletesuccess'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.vendorNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.vendordeletefailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $vendor = Vendor::find($request->id);
            if ($vendor->active == 1)
            {
                $vendor->active = 0;
                $vendor->save();
                $msg = trans('content.unactiveVendorstate');
                $active = 0;
            }
            else
            {
                $vendor->active = 1;
                $vendor->save();
                $msg = trans('content.activeVendorstate');
                $active = 1;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $vendor->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateVendorFailed")
            ], 405);
        }
    }
}
