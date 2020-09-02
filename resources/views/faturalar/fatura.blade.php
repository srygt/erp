@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri')
@section('title', 'Fatura Önizleme')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    @if (
                            $errors->any()
                            || session()->has('message')
                            || ($response->IsSucceeded ?? false) === true
                            || isset($error)
                        )
                        <div class="col-sm-12" id="messages">
                            @if (($response->IsSucceeded ?? false) === true)
                                <div class="alert alert-success">
                                    {{ $response->Message }}
                                </div>
                            @endif
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
                    </div>
                    <div class="col-sm-6">
                        <div class="text-lg-right">
                            <a href="{{ route('fatura.ekle.post') }}" class="btn btn-lg btn-primary">
                                Yeni Fatura Oluştur
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
