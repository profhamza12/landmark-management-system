@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.coins')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.coins')}}</a> -
                        <span>{{trans('content.addCoin')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-coin" action="{{route('coins.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($languages)
                            <div class="row tap">
                                <div class="col-ms-12 tap-links">
                                    @foreach($languages as $index => $lang)
                                        <a href="" class="btn @if($index == 0) active-link @endif" data-id="{{$lang->abbr}}">{{trans('content.'.$lang->abbr)}}</a>
                                    @endforeach
                                </div>
                                <div class="col-sm-12 tap-content">
                                    @foreach($languages as $index => $lang)
                                        <div class="tap-box {{$lang->abbr}} @if($index == 0) active-content @endif">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.coinname_'.$lang->abbr)}}</label>
                                                        <input type="text" name="coin[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterCoinName')}}">
                                                        @error('coin.name.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endisset
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.coinsymbol')}}</label>
                                    <input type="text" name="symbol" class="form-control" placeholder="{{trans('content.enterCoinSymbol')}}">
                                    @error('symbol')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group status">
                                    <input type="hidden" name="active" value="off">
                                    <input type="checkbox" name="active" checked data-toggle="toggle" data-on="{{trans('content.enabled')}}" data-off="{{trans('content.disabled')}}" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </div>
                        </div>

                        <div class="row hr">
                            <div class="form-group">
                                <hr />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn-back btn btn-info text-light">
                                        <i class="fas fa-backspace"></i>
                                        {{trans('content.back')}}
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-check"></i>
                                        {{trans('content.save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
