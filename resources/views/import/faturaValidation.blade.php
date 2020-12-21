@extends('layout.master')
@section('parentPageTitle', 'Fatura İçeri Aktarma')
@section('title', 'Fatura İçeri Aktarma Onayı')
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
                    @includeWhen(
                        \App\Models\Abone::COLUMN_TUR_ELEKTRIK === $importedFaturaFile->{\App\Models\ImportedFaturaFile::COLUMN_TYPE},
                        'import.fatura-elektrik.table',
                        [
                            'faturaList' => $faturaList,
                        ]
                    )
                    <div class="row">
                        <div class="col-sm-12 m-t-20 text-right">
                            <form action="{{route("import.fatura.import.post", $importedFaturaFile)}}" enctype="multipart/form-data" method="post">
                                @csrf
                                @foreach ($params as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <button type="submit" class="btn btn-primary btn-lg">Gönder</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-styles')

    <link rel="stylesheet" href="{{ asset('assets/vendor/dropify/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}">
@append

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
@append
