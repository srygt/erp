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
        <div class="col-sm-12">
            <div class="alert alert-info alert-dismissible" role="alert">
                <i class="fa fa-info-circle"></i>
                <p>
                    Mavi arkaplana sahip sütunlar veritabanına kaydedilecektir.
                    <br>
                    Gri arkaplana sahip sütunlar veritabanına kaydedil<u>meyecektir</u> (Sadece bilgilendirme amacıyla gösterilmektedir).
                </p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card text-white bg-info">
                <div class="card-header">CSV Fatura İçeri Aktarma</div>
                <div class="card-body">
                    @include(
                        \App\Services\Import\Fatura\Factories\FaturaImportFactory::getTemplateTable(
                            $importedFaturaFile->{\App\Models\ImportedFaturaFile::COLUMN_TYPE}
                        ),
                        [
                            'faturaList' => $faturaList,
                        ]
                    )
                    <div class="row">
                        <div class="col-sm-12 m-t-20 text-right">
                            <form action="{{route("import.fatura.import.post", $importedFaturaFile)}}" enctype="multipart/form-data" method="post">
                                @csrf
                                @foreach ($params as $key => $value)
                                    <input type="hidden" name="params[{{ $key }}]" value="{{ $value }}">
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
    <style type="text/css">
        .dataTable th {
            position: sticky;
            top: 0;
        }
    </style>
@append

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
@append
