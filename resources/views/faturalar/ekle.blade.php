@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri')
@section('title', 'Fatura Ekle')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datetimepicker/jquery.datetimepicker.min.css') }}"/>
@append

@section('content')
    <form id="mainForm" action="{{ route("faturataslak.ekle.post") }}" method="post">
        @csrf
        <input type="hidden" id="tur" name="tur" value="">
        <input type="hidden" id="data_source" name="data_source" value="manual">
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
                                                    data-enduktif="{{ $abone->{\App\Models\Abone::COLUMN_ENDUKTIF_BEDEL} ?? 0 }}"
                                                    data-kapasitif="{{ $abone->{\App\Models\Abone::COLUMN_KAPASITIF_BEDEL} ?? 0 }}"
                                                    @if(old('abone_id') == $abone->id)
                                                    selected
                                                    @endif
                                                >
                                                    {{
                                                        $abone->mukellef->unvan
                                                        . ' - ' . \App\Models\Abone::TUR_LIST[$abone->tur]
                                                        . ' - ' . $abone->{\App\Models\Abone::COLUMN_ABONE_NO}
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
                                <label>Fatura Tarihi<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-calendar"></i>
                                    </span>
                                    </div>
                                    <input
                                        id="fatura_tarih"
                                        name="fatura_tarih"
                                        value="{{ old("fatura_tarih") }}"
                                        placeholder="Seçin"
                                        class="form-control datetime"
                                    >
                                </div>
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
                        <div class="col-sm-12">
                            <div class="row">
                                <div id="ilkEndeksContainer" class="col-lg-6 col-md-12" style="display: none">
                                    <div class="form-group">
                                        <label>İlk Endeks<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="ilk_endeks" name="ilk_endeks" value="{{old("ilk_endeks")}}" min="0.000000" step="0.001">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label><span id="sonEndeksLabel">Toplam Tüketim</span><span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="son_endeks" value="{{old("son_endeks")}}" min="0.000000" step="0.001">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
                                        <input
                                            id="birim_fiyat"
                                            name="birim_fiyat"
                                            value="{{ old("birim_fiyat") }}"
                                            type="text"
                                            class="ucret form-control"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="enduktifContainer" class="col-sm-12" style="display: none;">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label><span>Endüktif Toplam Tüketim</span><span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="enduktif_tuketim" value="{{old("enduktif_tuketim")}}" min="0.000000" step="0.001">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Endüktif Birim Fiyat<span class="text-danger">*</span></label>
                                        <input
                                            id="enduktif_birim_fiyat"
                                            name="enduktif_birim_fiyat"
                                            value="{{ old("enduktif_birim_fiyat") }}"
                                            type="text"
                                            class="ucret form-control"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="kapasitifContainer" class="col-sm-12" style="display: none;">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label><span>Kapasitif Toplam Tüketim</span><span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="kapasitif_tuketim" value="{{old("kapasitif_tuketim")}}" min="0.000000" step="0.001">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Kapasitif Birim Fiyat<span class="text-danger">*</span></label>
                                        <input
                                            id="kapasitif_birim_fiyat"
                                            name="kapasitif_birim_fiyat"
                                            value="{{ old("kapasitif_birim_fiyat") }}"
                                            type="text"
                                            class="ucret form-control"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>Fatura Açıklaması</label>
                                <textarea
                                    id="faturaAciklama"
                                    name="not"
                                    type="text"
                                    rows="4"
                                    class="form-control"
                                ></textarea>
                            </div>
                        </div>
                        <div class="border bg-info col-md-12 mb-3"></div>
                        <div id="ekKalemList" class="col-lg-12 col-md-12">
                            <div class="header">
                                <h2>Ek Kalemler <small>Faturaya uygulanmasını istediğiniz ek kalemleri aşağıdan seçin</small></h2>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Başlık</th>
                                            <th>Birim Fiyat</th>
                                        </tr>
                                    </thead>
                                    @foreach(array_keys(\App\Models\Abone::TUR_LIST) as $tur)
                                        <tbody id="ekKalemList-{{ $tur }}" class="ekKalemList" style="display: none;">
                                        @foreach(($ekKalemler[$tur] ?? []) as $key => $ekKalem)
                                            <tr>
                                                <td scope="row">
                                                    <div class="fancy-checkbox">
                                                        <label>
                                                            <input
                                                                type="checkbox"
                                                                name="ek_kalemler[{{ $tur }}][{{ $key }}][id]"
                                                                value="{{ $ekKalem->id }}"
                                                                @if($ekKalem->varsayilan_durum ?? '' === true)
                                                                    checked
                                                                @endif
                                                            >
                                                            <span>{{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_BASLIK} }}</span>
                                                        </label>
                                                    </div>
                                                    <input
                                                        type="hidden"
                                                        name="ek_kalemler[{{ $tur }}][{{ $key }}][{{ \App\Models\AyarEkKalem::COLUMN_UCRET_TUR }}]"
                                                        value="{{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR} }}"
                                                    >
                                                </td>
                                                <td>
                                                    @if ($ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR} === \App\Models\AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR)
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            name="ek_kalemler[{{ $tur }}][{{ $key }}][deger]"
                                                            value="{{ old('ek_kalemler[' . $tur . '][' . $key . '][deger]') }}"
                                                            min="0.000000000"
                                                            step="0.01"
                                                        >
                                                    @elseif ($ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR} === \App\Models\AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT)
                                                        {{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_DEGER} }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @endforeach
                                </table>
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
    <script src="{{ asset('assets/vendor/jquery-turk-lirasi-maskesi/jquery.turkLirasi.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datetimepicker/jquery.datetimepicker.full.js') }}"></script>
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-select2/js/select2.min.js') }}"></script>

    <script>
        var ayarlar = {!! json_encode($ayarlar) !!};

        function getComingDayDate(day) {
            var possibleDate                = new Date();

            if (day < possibleDate.getDay()) {
                possibleDate.setMonth(possibleDate.getMonth() + 1)
            }

            // getMonth() Ocak'ı  "0" kabul ediyor, setMonth() Ocak'ı "1" kabul ediyor :)
            let month                       = possibleDate.getMonth() + 1

            return ("0" + day).slice(-2)
                + '.' + ("0" + month).slice(-2)
                + '.' + ("0" + possibleDate.getFullYear()).slice(-4);
        }

        function getCurrentDatetime() {
            let dateObj = new Date();

            let year    = dateObj.getFullYear();
            let month   = String(dateObj.getMonth() + 1).padStart(2, '0');
            let day     = String(dateObj.getDate()).padStart(2, '0');

            let hour    = String(dateObj.getHours()).padStart(2, '0');
            let minute  = String(dateObj.getMinutes()).padStart(2, '0');

            return [day, month, year].join('.') + ' ' + [hour,minute].join(':');
        }

        function fillDefaults() {
            let seciliAbone         = $('#abone_id').find(':selected');
            let tur                 = seciliAbone.data('tur');

            $.get(
                "{{ route('fatura.api.son-fatura') }}",
                {
                    'abone_id': seciliAbone.val()
                },
                function( sonFatura ) {

                    let fatura_tarih_baslik = tur + '.fatura_tarih'
                    if (ayarlar[fatura_tarih_baslik]) {
                        $('#fatura_tarih').val( ayarlar[fatura_tarih_baslik] );
                    }
                    else {
                        $('#fatura_tarih').val( getCurrentDatetime() );
                    }

                    let son_odeme_baslik    = tur + '.son_odeme_gun'
                    $('#son_odeme_tarihi').val( getComingDayDate(ayarlar[son_odeme_baslik]) )

                    if (tur === "{{ \App\Models\Abone::COLUMN_TUR_SU }}") {
                        $('#ilk_endeks').val(sonFatura.hasOwnProperty('son_endeks') ? sonFatura.son_endeks : '');
                    }
                    else {
                        $('#ilk_endeks').val('0');
                    }

                    let birim_fiyat_baslik  = tur + '.tuketim_birim_fiyat';
                    $('#birim_fiyat').trigger( 'setAgain', [ayarlar[birim_fiyat_baslik]] );

                    if (tur === "{{ \App\Models\Abone::COLUMN_TUR_ELEKTRIK }}") {
                        $('#enduktif_birim_fiyat').trigger('setAgain', ayarlar['elektrik.enduktif_birim_fiyat']);
                        $('#kapasitif_birim_fiyat').trigger('setAgain', ayarlar['elektrik.kapasitif_birim_fiyat']);
                    }

                    $('#faturaAciklama').val( ayarlar[tur + '.fatura_aciklama'] );
                }
            );
        }

        $(function () {

            $.datetimepicker.setLocale('tr');

            $('.date').datetimepicker({
                timepicker: false,
                format: '{{ config('common.date.format') }}',
            });

            $('.datetime').datetimepicker({
                format: '{{ config('common.time.format') }}',
            });

            $('#mainForm').on('submit', function(){
                $('.ucret')
                    .each(function(){
                        $(this).val($(this).val().replace(/[^0-9,]/g, '').replace(',', '.'));
                    });
            });

            $('.ucret')
                .turkLirasi({
                    maxDecimalCount: 9,
                })
                .trigger('keydown');

            $('#abone_id')
                .on('change', function(){
                    $('#fillDefaultsButton').prop('disabled', !$(this).val());

                    const selected      = $(this).find(':selected');

                    const tur           = selected.data('tur');
                    const isEnduktif    = selected.data('enduktif');
                    const isKapasitif   = selected.data('kapasitif');

                    $('#tur').val(tur);

                    const elLabelSonEndeks      = $('#sonEndeksLabel');
                    const elContainerIlkEndeks  = $('#ilkEndeksContainer');
                    const elContainerEnduktif   = $('#enduktifContainer');
                    const elContainerKapasitif  = $('#kapasitifContainer');


                    if (tur === "{{ \App\Models\Abone::COLUMN_TUR_SU }}")
                    {
                        elContainerIlkEndeks.show(250);
                        elLabelSonEndeks.html('Son Endeks');
                    }
                    else {
                        elContainerIlkEndeks.hide(250);
                        elLabelSonEndeks.html('Toplam Tüketim');
                    }

                    if (tur === "{{ \App\Models\Abone::COLUMN_TUR_ELEKTRIK }}")
                    {
                        isEnduktif ? elContainerEnduktif.show(250) : elContainerEnduktif.hide(250);
                        isKapasitif ? elContainerKapasitif.show(250) : elContainerKapasitif.hide(250);
                    }
                    else {
                        elContainerEnduktif.hide(250);
                        elContainerKapasitif.hide(250);
                    }

                    $('.ekKalemList').hide();
                    $('#ekKalemList-' + tur).show();
                })
                .trigger('change')
                .select2();

        });
    </script>
@stop
