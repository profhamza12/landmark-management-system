<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\InventoryEntryRequest;
use App\Http\Requests\Admin\PayableEntryRequest;
use App\Http\Requests\Admin\PriceOfferRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\TransQuantityRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\CompanyBranch;
use App\Models\Admin\InventoryEntry;
use App\Models\Admin\InventoryEntryDetail;
use App\Models\Admin\ItemUnitDetail;
use App\Models\Admin\PayableEntry;
use App\Models\Admin\PayableEntryItem;
use App\Models\Admin\PayableEntryDetail;
use App\Models\Admin\PriceOffer;
use App\Models\Admin\PriceOfferDetail;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use App\Models\Admin\StoreQuantity;
use App\Models\Admin\StoreTransQuantity;
use App\Models\Admin\StoreTransQuantityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PriceOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices_offers = getAllPricesOffers();
        return view('admin.prices_offers.index', compact('prices_offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = getActivatedCompanyBranches();
        $stores = getActivatedStores();
        $items = getActivatedItems();
        return view('admin.prices_offers.create', compact('stores', 'branches', 'items'));
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

    public function getStoreItems(Request $request)
    {
        $store_quantities = StoreQuantity::where('store_id', $request->id)->get();
        $data = [];
        foreach ($store_quantities as $_item)
        {
            $data[] = [
                'item_id' => $_item->item_id,
                'item_name' => $_item->Item->name
            ];
        }
        if (!empty($store_quantities))
        {
            return response()->json([
                'success' => true,
                'data' => $data,
                'lang' => getDefaultLang()
            ], 200);
        }
        return 0;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriceOfferRequest $request)
    {
        try {
            DB::beginTransaction();
            $price_offer = PriceOffer::create([
                'branch_id' => $request->branch,
                'store_id' => $request->store,
                'created_at' => now()
            ]);
            $details = [];
            foreach($request->item as $item)
            {
                $details[] = [
                    'price_offer_id' => $price_offer->id,
                    'item_id' => $item
                ];
            }
            PriceOfferDetail::insert($details);
            DB::commit();
            return redirect()->route('prices_offers.index')->with(['success' => trans('content.priceoffersuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('prices_offers.index')->with(['error' => trans('content.priceofferfailed')]);
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
        $price_offer = PriceOffer::find($id);
        if (!empty($price_offer))
        {
            $price_offer_details = $price_offer->PriceOfferDetails;
            return view('admin.prices_offers.show', compact('price_offer_details', 'price_offer'));
        }
        return redirect()->route('prices_offers.index')->with(['error' => trans('content.priceofferNotFound')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price_offer = PriceOffer::find($id);
        if (!empty($price_offer))
        {
            $branches = getActivatedCompanyBranches();
            $stores = getActivatedStores();
            $items = getActivatedItems();
            $price_offer_details = $price_offer->PriceOfferDetails;
            $offer_items = [];
            foreach ($price_offer_details as $_item)
            {
                $offer_items[] = $_item->item_id;
            }
            return view('admin.prices_offers.edit', compact('price_offer', 'branches', 'stores', 'items', 'price_offer_details', 'offer_items'));
        }
        return redirect()->route('prices_offers.index')->with(['error' => trans('content.priceofferNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PriceOfferRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $price_offer = PriceOffer::find($id);
            if (!empty($price_offer))
            {
                $price_offer->update([
                    'branch_id' => $request->branch,
                    'store_id' => $request->store,
                    'created_at' => now()
                ]);
                $price_offer->PriceOfferDetails()->delete();
                $details = [];
                foreach($request->item as $item)
                {
                    $details[] = [
                        'price_offer_id' => $price_offer->id,
                        'item_id' => $item
                    ];
                }
                PriceOfferDetail::insert($details);
                DB::commit();
                return redirect()->route('prices_offers.index')->with(['success' => trans('content.priceoffereditsuccess')]);
            }
            return redirect()->route('prices_offers.index')->with(['error' => trans('content.priceofferNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('prices_offers.index')->with(['error' => trans('content.priceoffereditfailed')]);
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
            $price_offer = PriceOffer::find($request->id);
            if (!empty($price_offer))
            {
                $price_offer->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.priceofferdeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.priceofferNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.priceofferdeleteFailed')
            ], 405);
        }
    }

}
