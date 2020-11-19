@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri ')
@section('title', 'Fatura Listesi')


@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="col-sm-12">
                    <form action="{{ route('fatura.liste') }}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="since">
                                        Tarih
                                    </label>
                                    <select class="form-control" name="since" id="since">
                                        @foreach(\App\Http\Requests\GidenFaturaRequest::GIDEN_FATURA_DAY_LIST as $value => $text)
                                            <option
                                                value="{{ $value }}"
                                                @if (request('since', \App\Http\Requests\GidenFaturaRequest::SINCE_DEFAULT) == $value)
                                                selected
                                                @endif
                                            >
                                                {{ $text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="app_type">
                                        Belge Türü
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
                    <th>#</th>
                    <th>Abone</th>
                    <th>Mükellef</th>
                    <th>Tür</th>
                    <th>Tarih</th>
                    <th>Fatura</th>
                    <th>Ücret</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
             @foreach($faturalar as $fatura)
                <tr>
                    <td>{{$fatura->uuid}}</td>
                    <td><div class="font-15">{{ $fatura->abone->baslik }}</div></td>
                    <td>{{ $fatura->abone->mukellef->unvan }}</td>
                    <td>{{ \Illuminate\Support\Str::ucfirst($fatura->abone->tur) }}</td>
                    <td>{{ $fatura->created_at->toDateString() }}</td>
                    <td>{{ \Onrslu\HtEfatura\Factories\AppTypeFactory::getTitle($fatura->app_type) }}</td>
                    <td class="text-right">{{ $fatura->toplam_odenecek_ucret }}TL</td>
                    <td>
                        <a href="{{
                            route('fatura.detay', [
                                'appType' => $fatura->app_type !== \Onrslu\HtEfatura\Types\Enums\AppType\EFatura::TYPE ? $fatura->app_type : \Onrslu\HtEfatura\Types\Enums\AppType\EFaturaGiden::TYPE,
                                'uuid' => $fatura->uuid
                                ])
                                }}" class="btn btn-sm btn-default" ><i class="fa fa-download text-blue"></i></a>
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
            "ordering": false,
            "language": {
                "url":'{{asset('js/json/datatableturkish.json')}}',
            }
        } );
    </script>
@stop
