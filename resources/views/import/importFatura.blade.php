@extends('layout.master')
@section('parentPageTitle', 'İçeri Aktarma')
@section('title', 'Fatura İçeri Aktarma')
@section('content')
    <div class="row clearfix">
        @if ($errors->any() || session()->has('message'))
            <div class="col-sm-12" id="messages">
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
        <div class="col-md-12">
            <div class="card text-white bg-info">
                <div class="card-header">CSV Fatura İçeri Aktarma</div>
                <div class="card-body">
                    <form action="?" method="post">
                        @csrf
                        @if(isset($mukellef->id))
                            <input type="hidden" name="id" value="{{ $mukellef->id }}">
                        @endif
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01">
                                        <label class="custom-file-label" for="inputGroupFile01">Dosya Seçin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-lg-right m-t-20">
                                <button type="button" class="btn btn-primary btn-lg">Gönder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-styles')

    <link rel="stylesheet" href="{{ asset('assets/vendor/dropify/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}">
    <style>
        .custom-file-input {
            cursor: pointer;
        }
        .custom-file-label::after {
            content: 'Gözat'
        }
    </style>
@stop

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
@stop
