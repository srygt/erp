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
                    <form action="{{route("import.fatura.validation.detay", $importedFaturaFile)}}" enctype="multipart/form-data" method="post">
                        @csrf
                        @includeWhen(
                            \App\Models\Abone::COLUMN_TUR_ELEKTRIK === $importedFaturaFile->{\App\Models\ImportedFaturaFile::COLUMN_TYPE},
                            'import.tables.tableElektrik',
                            [
                                'faturaList' => $faturaList,
                            ]
                        )
                        <div class="row">
                            <div class="col-sm-12 m-t-20 text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Gönder</button>
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
@append

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
@append
