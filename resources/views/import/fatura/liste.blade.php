@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri ')
@section('title', 'Fatura Listesi')


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
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="col-sm-12">
                    <form action="{{ route('fatura.liste') }}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="app_type">
                                        Fatura Türü
                                    </label>
                                    <select class="form-control" name="app_type" id="app_type">
                                        @foreach(\App\Http\Requests\GidenFaturaRequest::APP_TYPE_LIST as $value => $text)
                                            <option
                                                value="{{ $value }}"
                                                @if (request('app_type', \App\Http\Requests\GidenFaturaRequest::APP_TYPE_DEFAULT) == $value)
                                                selected
                                                @endif
                                            >
                                                {{ $text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4" style="display: flex; align-items: flex-end;">
                                    <button type="submit" class="btn btn-primary">Filtrele</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                <thead>
                <tr>
                    <th>Abone</th>
                    <th>Mükellef</th>
                    <th>Tür</th>
                    <th>Eklenme Tarihi</th>
                    <th>İlk Endeks</th>
                    <th>Son Endeks</th>
                    <th>Birim Fiyat</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
             @foreach($faturalar as $fatura)
                <tr>
                    <td><div class="font-15">{{ $fatura->abone->baslik }}</div></td>
                    <td>{{ $fatura->abone->mukellef->unvan }}</td>
                    <td>{{ \Illuminate\Support\Str::ucfirst($fatura->abone->tur) }}</td>
                    <td>{{ $fatura->created_at->toDateString() }}</td>
                    <td>{{ $fatura->ilk_endeks }}</td>
                    <td>{{ $fatura->son_endeks }}</td>
                    <td class="text-right">{{ $fatura->birim_fiyat }}TL</td>
                    <td>
                        <a href="{{ route('import.fatura.detay', [$fatura]) }}" class="btn btn-sm btn-default" ><i class="fa fa-shopping-cart text-blue"></i></a>
                        <!-- <button type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button> -->
                    </td>
                </tr>
             @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}">
    <style>
        .dataTables_filter input {
            background-color: white;
        }
    </style>
@stop

@section('page-script')
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script>

        $('.dataTable').DataTable( {
            "language": {
                "url":'{{asset('js/json/datatableturkish.json')}}',
            },
            "pageLength": 25,
            "order": [[ 4, "desc" ]],
        } );
    </script>
@stop
