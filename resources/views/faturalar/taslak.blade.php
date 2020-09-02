@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri')
@section('title', 'Fatura Taslağı Önizleme')
@section('content')
    <form action="{{route('fatura.ekle.post')}}" method="post">
        @csrf
        <input type="hidden" name="uuid" value="{{ $taslakUuid }}">
        @foreach($ekKalemTurleri as $tur => $ekKalemler)
            @foreach($ekKalemler as $key => $ekKalem)
                <input type="hidden" name="ek_kalemler[{{ $tur }}][{{ $key }}][id]" value="{{ $ekKalem['id'] }}">
                <input type="hidden" name="ek_kalemler[{{ $tur }}][{{ $key }}][{{ \App\Models\AyarEkKalem::COLUMN_UCRET_TUR }}]" value="{{ $ekKalem[\App\Models\AyarEkKalem::COLUMN_UCRET_TUR] }}">
                @if ($ekKalem[\App\Models\AyarEkKalem::COLUMN_UCRET_TUR] === \App\Models\AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR)
                    <input type="hidden" name="ek_kalemler[{{ $tur }}][{{ $key }}][{{ \App\Models\AyarEkKalem::COLUMN_DEGER }}]" value="{{ $ekKalem[\App\Models\AyarEkKalem::COLUMN_DEGER] }}">
                @endif
            @endforeach
        @endforeach
        <div class="col-sm-12">
            <div class="card">
                <div class="body">
                    <div class="row clearfix">
                        @if ($errors->any() || session()->has('message') || isset($error))
                            <div class="col-sm-12" id="messages">
                                @if (isset($error))
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endif
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message')}}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-lg-left">
                                <button
                                    type="button"
                                    class="btn btn-lg btn-default"
                                    onclick="window.history.back()"
                                >
                                    Geri Dön
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-lg-right">
                                @if (!isset($error))
                                    <button type="submit" class="btn btn-lg btn-primary">Faturalaştır</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!isset($error))
            <div class="col-sm-12">
                <div class="card">
                    <div class="body" id="billPreview">
                        <span id="billContainer">
                            {!! $response->HtmlContent ?? '' !!}
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </form>
@stop

@section('page-styles')
    <style type="text/css">
        #billPreview {
            min-width: 840px;
        }
        #billContainer {
            display: table;
            margin: 0 auto;
        }
    </style>
@stop
@section('page-script')
    <script>
        $(function () {
            $('#main-menu > li:not(.active) > ul').css('display', 'none');
            $('.page-loader-wrapper').fadeOut();
        });
    </script>
@stop
