@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri')
@section('title', 'Su Faturası Ekle')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-select2/css/select2.min.css') }}"/>
@append

@section('content')
    <form action="{{ route("faturataslak.ekle.post") }}" method="post">
        @csrf
        <input type="hidden" id="tur" name="tur" value="">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="body">
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
                            <div class="form-group">
                                <label>Abone<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select class="form-control" name="abone_id" id="abone_id">
                                            <option value="">Seçin</option>
                                            @foreach($aboneler as $abone)
                                                <option
                                                    value="{{ $abone->id }}"
                                                    data-tur="{{ $abone->tur }}"
                                                    @if(old('abone_id') == $abone->id)
                                                    selected
                                                    @endif
                                                >
                                                    {{
                                                        $abone->mukellef->unvan
                                                        . ' - ' . \App\Models\Abone::TUR_LIST[$abone->tur]
                                                        . ' - ' . $abone->baslik
                                                    }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <button
                                            id="fillDefaultsButton"
                                            onclick="fillDefaults()"
                                            type="button"
                                            class="btn btn-primary"
                                            disabled
                                        >
                                            <i class="fa fa-refresh"></i>
                                            <span>Varsayılanlarını Çek</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
                                <input
                                    id="birim_fiyat"
                                    name="birim_fiyat"
                                    value="{{old("birim_fiyat")}}"
                                    min="0.000000"
                                    step="0.000001"
                                    type="number"
                                    class="form-control"
                                >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Son Ödeme Tarihi<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon-calendar"></i>
                                        </span>
                                    </div>
                                    <input
                                        id="son_odeme_tarihi"
                                        name="son_odeme_tarihi"
                                        value="{{ old("son_odeme_tarihi") }}"
                                        placeholder="Seçin"
                                        data-provide="datepicker"
                                        data-date-autoclose="true"
                                        class="form-control date"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" id="elektrikSpecificArea" style="display: none;">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Birim Dağıtım Fiyatı<span class="text-danger">*</span></label>
                                        <input
                                            id="dagitim_birim_fiyat"
                                            name="dagitim_birim_fiyat"
                                            value="{{old("dagitim_birim_fiyat")}}"
                                            min="0.000000"
                                            step="0.000001"
                                            type="number"
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Birim Sistem Kullanım Fiyatı<span class="text-danger">*</span></label>
                                        <input
                                            id="sistem_birim_fiyat"
                                            name="sistem_birim_fiyat"
                                            value="{{old("sistem_birim_fiyat")}}"
                                            min="0.000000"
                                            step="0.000001"
                                            type="number"
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>İlk Endeks<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="ilk_endeks" value="{{old("ilk_endeks")}}" min="0.000000" step="0.001">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Son Endeks<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="son_endeks" value="{{old("son_endeks")}}" min="0.000000" step="0.001">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>Fatura Açıklaması<span class="text-danger">*</span></label>
                                <textarea rows="4" type="text" class="form-control" name="not"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-lg-right m-t-20">
                            <button type="submit" class="btn btn-lg btn-primary">Fatura Taslağı Önizleme</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('page-script')
    <script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.tr.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-select2/js/select2.min.js') }}"></script>

    <script>
        var ayarlar = {!! json_encode($ayarlar) !!};

        function getComingDayDate(day) {
            var possibleDate                = new Date();

            if (day > possibleDate.getDay()) {
                // getMonth() Ocak'ı  "0" kabul ediyor, setMonth() Ocak'ı "1" kabul ediyor :)
                possibleDate.setMonth( possibleDate.getMonth() + 2);
            }

            return ("0" + day).slice(-2)
                + '.' + ("0" + possibleDate.getMonth()).slice(-2)
                + '.' + ("0" + possibleDate.getFullYear()).slice(-4);
        }

        function fillDefaults() {
            let tur                 = $('#abone_id').find(':selected').data('tur');

            let birim_fiyat_baslik          = tur + '.tuketim_birim_fiyat';
            $('#birim_fiyat').val( ayarlar[birim_fiyat_baslik] );

            let dagitim_birim_fiyat_baslik  = tur + '.dagitim_birim_fiyat';
            $('#dagitim_birim_fiyat').val( ayarlar[dagitim_birim_fiyat_baslik] );

            let sistem_birim_fiyat_baslik   = tur + '.sistem_birim_fiyat';
            $('#sistem_birim_fiyat').val( ayarlar[sistem_birim_fiyat_baslik] );

            let son_odeme_baslik    = tur + '.son_odeme_gun'
            $('#son_odeme_tarihi').val( getComingDayDate(ayarlar[son_odeme_baslik]) )
        }

        $(function () {

            $('.date').datepicker({
                format: 'dd.mm.yyyy',
                language: 'tr'
            });

            $('#abone_id')
                .on('change', function(){
                    $('#fillDefaultsButton').prop('disabled', !$(this).val());

                    let tur = $(this).find(':selected').data('tur');
                    $('#tur').val(tur);

                    if (tur === '{{ \App\Models\Abone::COLUMN_TUR_ELEKTRIK }}' )
                    {
                        $('#elektrikSpecificArea').show(250);
                    }
                    else {
                        $('#elektrikSpecificArea').hide(250);
                    }
                })
                .trigger('change')
                .select2();

        });
    </script>
@stop
