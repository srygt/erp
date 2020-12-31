@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri ')
@section('title', 'Giden Fatura Raporları')


@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="col-sm-12">
                    <form action="{{ route('fatura.giden.rapor') }}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="since">
                                        Tarih
                                    </label>
                                    <select class="form-control" name="since" id="since">
                                        @foreach(\App\Http\Requests\GidenFaturaRaporlariRequest::GIDEN_FATURA_DAY_LIST as $value => $text)
                                            <option
                                                value="{{ $value }}"
                                                @if (request('since', \App\Http\Requests\GidenFaturaRaporlariRequest::SINCE_DEFAULT) == $value)
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
                                        @foreach(\App\Http\Requests\GidenFaturaRaporlariRequest::APP_TYPE_LIST as $value => $text)
                                            <option
                                                value="{{ $value }}"
                                                @if (request('app_type', \App\Http\Requests\GidenFaturaRaporlariRequest::APP_TYPE_DEFAULT) == $value)
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
                    <th>Fatura No</th>
                    <th>Mükellef</th>
                    <th>Doküman Türü</th>
                    <th>Doküman Profili</th>
                    <th>Durum</th>
                    <th>Zarf Durumu</th>
                    <th>Miktar</th>
                    <th>Oluşturulma Tarihi</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
             @foreach($faturalar as $fatura)
                <tr
                @if (!$fatura->IsRead)
                    class="notRead"
                @endif
                >
                    <td><div class="font-15">{{ $fatura->DocumentId }}</div></td>
                    <td><a title="{{ $fatura->TargetTitle }}" class="hideOverflow">{{ $fatura->TargetTitle }}</a></td>
                    <td>{{ $fatura->DocumentTypeCode }}</td>
                    <td>{{ $fatura->ProfileId }}</td>
                    <td
                    @if ($fatura->Status === 12 || $fatura->Status === 7)
                        class="basarili"
                    @elseif ($fatura->Status === 11 || $fatura->Status === 9)
                        class="basarisiz"
                    @endif
                    >
                        {{ $fatura->StatusExp }}
                    </td>
                    <td
                        @if ($fatura->EnvelopeStatus === 14000 || $fatura->EnvelopeStatus === 1300)
                            class="basarili"
                        @endif
                    >
                        {{ $fatura->EnvelopeExp }}
                    </td>
                    <td>{{ $fatura->PayableAmount . $fatura->DocumentCurrencyCode }}</td>
                    <td>{{ $fatura->CreatedDate }}</td>
                    <td>
                        <a href="{{ route('fatura.detay', ['appType' => $fatura->AppType, 'uuid' => $fatura->UUID]) }}" class="btn btn-sm btn-default" ><i class="fa fa-download text-blue"></i></a>
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
        .basarili {
            color: #00da00;
        }
        .basarisiz {
            color: #FF0000;
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
            "order": [[ 7, "desc" ]],
        } );
    </script>
@stop
