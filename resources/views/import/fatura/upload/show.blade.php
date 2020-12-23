@extends('layout.master')
@section('parentPageTitle', 'Fatura İçeri Aktarma')
@section('title', 'Fatura Detay')
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
                    <form action="{{route("import.fatura.validation", $importedFaturaFile)}}" enctype="multipart/form-data" method="get">
                        @include(
                            \App\Services\Import\Fatura\Factories\FaturaFactory::getTemplateEkKalemSelect(
                                $importedFaturaFile->{\App\Models\ImportedFaturaFile::COLUMN_TYPE}
                            ),
                            [
                                'ekKalemler' => $ekKalemler,
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
