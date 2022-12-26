<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoinRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Admin\Coin;
use App\Models\Admin\Role;
use App\Models\Admin\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = getAllCoins();
        return view('admin.coins.index', compact('coins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = getActivatedLanguages();
        return view('admin.coins.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoinRequest $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->active == "on" ? 1 : 0;
            Coin::create([
                'name' => $request->coin['name'],
                'symbol' => $request->symbol,
                'active' => $status,
            ]);
            DB::commit();
            return redirect()->route('coins.index')->with(['success' => trans('content.coinaddsuccess')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('coins.index')->with(['error' => trans('content.coinaddfailed')]);
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
        $coin = Coin::find($id);
        if (!empty($coin))
        {
            $translations = $coin->getTranslations();
            $languages = getActivatedLanguages();
            return view('admin.coins.edit', compact('coin', 'translations', 'languages'));
        }
        return redirect()->route('coins.index')->with(['error' => trans('content.coinNotFound')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoinRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $coin = Coin::find($id);
            if (!empty($coin))
            {
                $status = ($request->active == "on") ? 1 : 0;
                $coin->update([
                    'name' => $request->coin['name'],
                    'symbol' => $request->symbol,
                    'active' => $status,
                ]);
                Db::commit();
                return redirect()->route('coins.index')->with(['success' => trans('content.coineditsuccess')]);
            }
            return redirect()->route('coins.index')->with(['error' => trans('content.coinNotFound')]);
        }
        catch (\Exception $ex)
        {
            DB::rollBack();
            return redirect()->route('coins.index')->with(['error' => trans('content.coineditfailed')]);
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
            $coin = Coin::find($request->id);
            if (!empty($coin))
            {
                $coin->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => trans('content.coindeletemsg'),
                    'id' => $request->id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => trans('content.coinNotFound')
            ], 405);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => trans('content.deleteCoinFailed')
            ], 405);
        }
    }

    public function activate(Request $request)
    {
        try {
            $coin = Coin::find($request->id);
            if ($coin->active == 0)
            {
                $coin->active = 1;
                $coin->save();
                $msg = trans('content.activeCoinstate');
                $active = 1;
            }
            else
            {
                $coin->active = 0;
                $coin->save();
                $msg = trans('content.unactiveCoinstate');
                $active = 0;
            }
            return response()->json([
                "success" => true,
                "msg" => $msg,
                "active" => $active,
                "id" => $coin->id
            ], 200);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => trans("content.activateCoinFailed")
            ], 405);
        }
    }
}
