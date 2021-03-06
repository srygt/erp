@extends('layout.master')
@section('parentPageTitle', '')
@section('title', 'Anasayfa')

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}" />
<style type="text/css">
#staticsList a {
    color: #17191c;
}
</style>
@append

@section('content')

    <div id="staticsList" class="row clearfix">
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
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <a href="{{ route('fatura.gelen.liste') }}?since=30">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-arrow-down"></i></div>
                            <div class="ml-4">
                                <span>Gelen e-Fatura</span>
                                <h4 class="mb-0 font-weight-medium">{{ $harcananGelenFaturaMiktari }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <a href="{{ route('fatura.liste') }}?since=30&app_type=1">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-arrow-up"></i></div>
                            <div class="ml-4">
                                <span>Giden e-Fatura</span>
                                <h4 class="mb-0 font-weight-medium">{{ $harcananGidenFaturaMiktari }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <a href="{{ route('fatura.liste') }}?since=30&app_type=3">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-orange text-white rounded-circle"><i class="fa fa-file"></i></div>
                            <div class="ml-4">
                                <span>Giden e-Ar??iv</span>
                                <h4 class="mb-0 font-weight-medium">{{ $harcananEArsivFaturaMiktari }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <a href="javascript:;">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-pink text-white rounded-circle"><i class="fa fa-life-ring"></i></div>
                            <div class="ml-4">
                                <span>Kalan Kont??r</span>
                                <h4 class="mb-0 font-weight-medium">{{ $kalanKontor }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-5">
            <div class="card">
                <div class="body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Bu Ay Kesilen Faturalar</h6>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <small>
                                Fatura t??r??ne g??re grupland??r??lm????t??r
                            </small>
                            <div class="d-flex justify-content-start mt-3">
                                <div class="mr-5">
                                    <label class="mb-0">Elektrik</label>
                                    <h4>
                                        <abbr title="{{ getMoneyFormat($turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_ELEKTRIK] ?? 0)}}TL">
                                            {{ getMoneyFormat(($turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_ELEKTRIK] ?? 0)/(1000*1000)) }}M TL
                                        </abbr>
                                    </h4>
                                </div>
                                <div class="mr-5">
                                    <label class="mb-0">Su</label>
                                    <h4>
                                        <abbr title="{{ getMoneyFormat($turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_SU] ?? 0)}}TL">
                                            {{ getMoneyFormat(($turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_SU] ?? 0)/(1000*1000)) }}M TL
                                        </abbr>
                                    </h4>
                                </div>
                                <div>
                                    <label class="mb-0">Do??algaz</label>
                                    <h4>
                                        <abbr title="{{ getMoneyFormat($turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_DOGALGAZ] ?? 0)}}TL">
                                            {{ getMoneyFormat(($turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_DOGALGAZ] ?? 0)/(1000*1000)) }}M TL
                                        </abbr>
                                    </h4>
                                </div>
                            </div>
                            <div id="chart-donut" style="height: 250px"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="table-responsive">
                <table class="table table-hover table-custom spacing5">
                    <thead>
                    <tr>
                        <th style="width: 20px;">Fatura No</th>
                        <th>Tarih</th>
                        <th style="width: 50px;">Miktar</th>
                        <th colspan="2">Fatura T??r??</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($yeniFaturalar as $yeniFatura)
                    <tr>
                        <td>
                            <span>{{ $yeniFatura->DocumentId }}</span>
                        </td>
                        <td>{{ $yeniFatura->CreatedDate }}</td>
                        <td>{{ $yeniFatura->PayableAmount . $yeniFatura->DocumentCurrencyCode }}</td>
                        <td><span class="badge badge-info ml-0 mr-0">{{ $yeniFatura->DocumentTypeCode }}</span></td>
                        <td>
                            <a href="{{ route('fatura.detay', ['appType' => $yeniFatura->AppType, 'uuid' => $yeniFatura->UUID]) }}" class="btn btn-sm btn-default" title="Faturay?? G??r??nt??le" data-toggle="tooltip" data-placement="top"><i class="fa fa-download text-blue"></i></a>
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
@stop

@section('page-script')
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>
<script>

    c3.generate({
        bindto: '#chart-donut', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', {{ $turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_ELEKTRIK] ?? 0 }}],
                ['data2', {{ $turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_SU] ?? 0 }}],
                ['data3', {{ $turlereGoreToplam[\App\Models\Abone::COLUMN_TUR_DOGALGAZ] ?? 0 }}],
            ],
            type: 'donut', // default type of chart
            colors: {
                'data1': '#E60000',
                'data2': '#17C2D7',
                'data3': '#9367B4',
            },
            names: {
                // name of each serie
                'data1': 'Elektrik',
                'data2': 'Su',
                'data3': 'Do??algaz',
            }
        },
        axis: {
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 20,
            top: 0
        },
    });
</script>
@stop
