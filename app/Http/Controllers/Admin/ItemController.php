<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ItemRequest;
use App\Http\Requests\Admin\SubCatRequest;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\Item;
use App\Models\Admin\ItemUnitDetail;
use App\Models\Admin\MainCategory;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = getAllItems();
        return view('admin.items.index', compact('items'));
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
        $branches = getActivatedCompanyBranches();
        $stores = getActivatedStores();
        $units = getActivatedUnits();
        $coins = getActivatedCoins();
        return view('admin.items.create', compact('languages', 'branches', 'mainCats', 'subCats', 'stores', 'units', 'coins'));
    }

    private function checkUniqueData($arr, $key1, $key2 = null, $key3 = null)
    {
        $src = [];
        $dest = [];
        foreach ($arr as $index => $item)
        {
            $src[] = $item[$key1];
            if (!empty($key2))
            {
                $src[] = $item[$key2];
            }
            if (!empty($key3))
            {
                $src[] = $item[$key3];
            }
            if (in_array($src, $dest))
            {
                return false;
            }
            $dest[$index] = $src;
            $src = [];
        }
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('item_unit_price'))
            {
                $isValid = $this->checkUniqueData($request->item_unit_price, 'unit');
                if (!$isValid)
                {
                    return redirect()->route('items.create')->with('error', trans('content.errorInput'));
                }
            }
            else
            {
                return redirect()->route('items.create')->with(['error' => trans('content.unitdetailerr')]);
            }
            if ($request->has('store_quantity'))
            {
                $isValid = $this->checkUniqueData($request->store_quantity, 'branch', 'unit', 'store');
                if (!$isValid)
                {
                    return redirect()->route('items.create')->with('error', trans('content.errorInput'));
                }
            }
            else
            {
                return redirect()->route('items.create')->with(['error' => trans('content.quantityNotSend')]);
            }
            $status = $request->active == "on" ? 1 : 0;
            $imageName = saveImage($request->photo, "items");
            $item = Item::create([
                'name' => $request->item['name'],
                'description' => $request->item['description'],
                'photo' => $imageName,
                'maincat_id' => $request->maincat_id,
                'subcat_id' => $request->subcat_id,
                'coin_id' => $request->coin,
                'max_discount_rate' => $request->max_discount_rate,
                'max_quantity' => $request->max_quantity,
                'min_quantity' => $request->min_quantity,
                'active' => $status,
            ]);
            $unitsCount = Unit::count();
            if ($unitsCount != count($request->item_unit_price))
            {
                return redirect()->route('items.create')->with(['error' => trans('content.unitdetailerr')]);
            }
            $item_unit_prices = [];
            foreach ($request->item_unit_price as $_item)
            {
                $item_unit_prices[] = [
                    'item_id' => $item->id,
                    'unit_id' => $_item['unit'],
                    'unit_item_count' => $_item['count'],
                    'selling_price' => $_item['selling_price'],
                    'purchasing_price' => $_item['purchasing_price'],
                    'wholesale_price' => $_item['wholesale_price'],
                    'wholesale2_price' => $_item['wholesale2_price'],
                ];
            }
            ItemUnitDetail::insert($item_unit_prices);
            $store_quantities = [];
            $stores = [];
            foreach ($request->store_quantity as $store_quantity)
            {
                $unit_detail = ItemUnitDetail::where('item_id', $item->id)->where('unit_id', $store_quantity['unit'])->first();
                if (!empty($unit_detail))
                {
                    if (!in_array($store_quantity['store'], $stores))
                    {
                        $stores[] = $store_quantity['store'];
                        $store_quantities[$store_quantity['store']] = [
                            'branch_id' => $store_quantity['branch'],
                            'item_id' => $item->id,
                            'store_id' => $store_quantity['store'],
                            'quantity' => $store_quantity['quantity'] * $unit_detail->unit_item_count,
                        ];
                    }
                    else
                    {
                        $store_quantities[$store_quantity['store']]['quantity'] += ($store_quantity['quantity'] * $unit_detail->unit_item_count);
                    }
                }
            }
            StoreQuantity::insert($store_quantities);
            DB::commit();
            return redirect()->route('items.index')->with(['success' => trans('content.itemaddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('items.index')->with(['error' => trans('content.itemaddfailed')]);
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
        $item = Item::find($id);
        if(!empty($item))
        {
            $purchases_invoices = $item->PurchasesInvoices;
            $sales_invoices = $item->SalesInvoices;
            $store_quantities = $item->StoreQuantities;
            return view('admin.items.show', compact('item', 'purchases_invoices', 'sales_invoices', 'store_quantities'));
        }
        return redirect()->route('items.index')->with(['error' => trans('content.itemNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::Selection()->find($id);
        if (!empty($item))
        {
            $translations = $item->getTranslations();
            $languages = getActivatedLanguages();
            $mainCats = getActivatedMainCats();
            $subCats = getActivatedSubCats();
            $branches = getActivatedCompanyBranches();
            $stores = getActivatedStores();
            $units = getActivatedUnits();
            $coins = getActivatedCoins();
            $item_stores = StoreQuantity::where('item_id', $item->id)->get();
            $item_unit_prices = ItemUnitDetail::where('item_id', $item->id)->get();
            $small_unit = ItemUnitDetail::where('item_id', $item->id)->where('unit_item_count', 1)->first();
            if (!empty($small_unit))
            {
                $small_unit = $small_unit->Unit;
            }
            return view('admin.items.edit', compact('item', 'translations', 'languages', 'branches', 'mainCats', 'subCats', 'stores', 'units', 'item_stores', 'coins', 'item_unit_prices', 'small_unit'));
        }
        return redirect()->route('items.index')->with(['error' => trans('content.itemNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $item = Item::Selection()->find($id);
            if (!empty($item))
            {
                if ($request->has('item_unit_price'))
                {
                    $isValid = $this->checkUniqueData($request->item_unit_price, 'unit');
                    if (!$isValid)
                    {
                        return redirect()->route('items.edit', $id)->with('error', trans('content.errorInput'));
                    }
                }
                else
                {
                    return redirect()->route('items.edit', $item->id)->with(['error' => trans('content.unitdetailerr')]);
                }
                if ($request->has('store_quantity'))
                {
                    $isValid = $this->checkUniqueData($request->store_quantity, 'branch', 'unit', 'store');
                    if (!$isValid)
                    {
                        return redirect()->route('items.edit', $id)->with('error', trans('content.errorInput'));
                    }
                }
                else
                {
                    return redirect()->route('items.edit', $item->id)->with(['error' => trans('content.quantityNotSend')]);
                }

                $status = ($request->active == "on") ? 1 : 0;
                $imageName = ($request->has('photo')) ? saveImage($request->photo, "items") : $item->photo;
                $item->update([
                    'name' => $request->item['name'],
                    'description' => $request->item['description'],
                    'photo' => $imageName,
                    'maincat_id' => $request->maincat_id,
                    'subcat_id' => $request->subcat_id,
                    'coin_id' => $request->coin,
                    'max_discount_rate' => $request->max_discount_rate,
                    'max_quantity' => $request->max_quantity,
                    'min_quantity' => $request->min_quantity,
                    'active' => $status,
                ]);

                $unitsCount = Unit::count();
                if ($unitsCount != count($request->item_unit_price))
                {
                    return redirect()->route('items.edit', $item->id)->with(['error' => trans('content.unitdetailerr')]);
                }
                ItemUnitDetail::where('item_id', $item->id)->delete();
                $item_unit_prices = [];
                foreach ($request->item_unit_price as $_item)
                {
                    $item_unit_prices[] = [
                        'item_id' => $item->id,
                        'unit_id' => $_item['unit'],
                        'unit_item_count' => $_item['count'],
                        'selling_price' => $_item['selling_price'],
                        'purchasing_price' => $_item['purchasing_price'],
                        'wholesale_price' => $_item['wholesale_price'],
                        'wholesale2_price' => $_item['wholesale2_price'],
                    ];
                }
                ItemUnitDetail::insert($item_unit_prices);
                StoreQuantity::where('item_id', $item->id)->delete();
                $store_quantities = [];
                $stores = [];
                foreach ($request->store_quantity as $store_quantity)
                {
                    $unit_detail = ItemUnitDetail::where('item_id', $item->id)->where('unit_id', $store_quantity['unit'])->first();
                    if (!empty($unit_detail))
                    {
                        if (!in_array($store_quantity['store'], $stores))
                        {
                            $stores[] = $store_quantity['store'];
                            $store_quantities[$store_quantity['store']] = [
                                'branch_id' => $store_quantity['branch'],
                                'item_id' => $item->id,
                                'store_id' => $store_quantity['store'],
                                'quantity' => $store_quantity['quantity'] * $unit_detail->unit_item_count,
                            ];
                        }
                        else
                        {
                            $store_quantities[$store_quantity['store']]['quantity'] += ($store_quantity['quantity'] * $unit_detail->unit_item_count);
                        }
                    }
                }
                StoreQuantity::insert($store_quantities);
                Db::commit();
                return redirect()->route('items.index')->with(['success' => trans('content.itemeditsuccess')]);
            }
            return redirect()->route('items.index')->with(['error' => trans('content.itemNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('items.index')->with(['error' => trans('content.itemeditfailed')]);
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
            $item = Item::find($request->id);
            if (!empty($item))
            {
                $item->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.itemdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.itemNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.deleteItemFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $item = Item::find($request->id);
            if ($item->active == 0)
            {
                $item->active = 1;
                $item->save();
                $msg = trans('content.activeItemstate');
                $active = 1;
            }
            else
            {
                $item->active = 0;
                $item->save();
                $msg = trans('content.unactiveItemstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $item->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateItemFailed")
            ], 405);
        }
    }

    public function getMainCatDetail(Request $request)
    {
        $maincat_id = $request->maincat;
        $mainCat = MainCategory::Selection()->find($maincat_id);
        if (!empty($mainCat))
        {
            return response()->json([
                'success' => true,
                'maincat' => $mainCat,
            ]);
        }
    }

    public function getSubCategories(Request $request)
    {
        $maincat = MainCategory::find($request->id);
        if (!empty($maincat))
        {
            $subcats = $maincat->SubCategories;
            return response()->json([
                'success' => true,
                'subcats' => $subcats,
                'lang' => getDefaultLang()
            ], 200);
        }
        return 0;
    }
    public function getBranchStores(Request $request)
    {
        $branch = CompanyBranch::find($request->id);
        if (!empty($branch))
        {
            $stores = $branch->Stores;
            return response()->json([
                'success' => true,
                'stores' => $stores,
                'lang' => getDefaultLang()
            ], 200);
        }
        return 0;
    }
}
