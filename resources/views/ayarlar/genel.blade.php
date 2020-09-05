@extends('layout.master')
@section('title', 'Ayarlar')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datetimepicker/jquery.datetimepicker.min.css') }}"/>
@stop

@section('content')
    <form id="mainForm" action="{{route("ayar.genel.update")}}" method="post">
        @csrf
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
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a
                                    class="nav-link active show"
                                    id="v-pills-elektrik-tab"
                                    data-toggle="pill"
                                    href="#v-pills-elektrik"
                                    role="tab"
                                    aria-controls="v-pills-elektrik"
                                    aria-selected="false"
                                >
                                    Elektrik Faturası
                                </a>
                                <a
                                    class="nav-link"
                                    id="v-pills-su-tab"
                                    data-toggle="pill"
                                    href="#v-pills-su"
                                    role="tab"
                                    aria-controls="v-pills-su"
                                    aria-selected="false"
                                >
                                    Su Faturası
                                </a>
                                <a
                                    class="nav-link"
                                    id="v-pills-dogalgaz-tab"
                                    data-toggle="pill"
                                    href="#v-pills-dogalgaz"
                                    role="tab"
                                    aria-controls="v-pills-dogalgaz"
                                    aria-selected="false"
                                >
                                    Doğalgaz Faturası
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane active show" id="v-pills-elektrik" role="tabpanel" aria-labelledby="v-pills-elektrik-tab">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Banka Hesap Adı<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="elektrik[banka_hesap_adi]"
                                                        value="{{ old("elektrik.banka_hesap_adi", $ayarlar['elektrik.banka_hesap_adi'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>IBAN<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="elektrik[banka_iban]"
                                                        value="{{ old("elektrik.banka_iban", $ayarlar['elektrik.banka_iban'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Fatura Tarihi<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        name="elektrik[fatura_tarih]"
                                                        value="{{ old("elektrik.fatura_tarih", $ayarlar['elektrik.fatura_tarih'] ?? '') }}"
                                                        placeholder="Seçin"
                                                        class="form-control datetime"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Son Ödeme Günü<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="elektrik[son_odeme_gun]"
                                                        value="{{ old("elektrik.son_odeme_gun", $ayarlar['elektrik.son_odeme_gun'] ?? '') }}"
                                                        min="1"
                                                        max="31"
                                                        step="1"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
                                                <input
                                                    type="text"
                                                    class="ucret form-control"
                                                    name="elektrik[tuketim_birim_fiyat]"
                                                    value="{{ old("elektrik.tuketim_birim_fiyat", $ayarlar['elektrik.tuketim_birim_fiyat'] ?? '') }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Endüktif Bedel Birim Fiyatı<span class="text-danger">*</span></label>
                                                <input
                                                    type="text"
                                                    class="ucret form-control"
                                                    name="elektrik[enduktif_birim_fiyat]"
                                                    value="{{ old("elektrik.enduktif_birim_fiyat", $ayarlar['elektrik.enduktif_birim_fiyat'] ?? '') }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Kapasitif Bedel Birim Fiyatı<span class="text-danger">*</span></label>
                                                <input
                                                    type="text"
                                                    class="ucret form-control"
                                                    name="elektrik[kapasitif_birim_fiyat]"
                                                    value="{{ old("elektrik.kapasitif_birim_fiyat", $ayarlar['elektrik.kapasitif_birim_fiyat'] ?? '') }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Fatura Açıklaması<span class="text-danger">*</span></label>
                                                <textarea
                                                    class="form-control"
                                                    name="elektrik[fatura_aciklama]"
                                                >{{ old("elektrik.fatura_aciklama", $ayarlar['elektrik.fatura_aciklama'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="v-pills-su" role="tabpanel" aria-labelledby="v-pills-su-tab">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Banka Hesap Adı<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="su[banka_hesap_adi]"
                                                        value="{{ old("su.banka_hesap_adi", $ayarlar['su.banka_hesap_adi'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>IBAN<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="su[banka_iban]"
                                                        value="{{ old("su.banka_iban", $ayarlar['su.banka_iban'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Fatura Tarihi<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        name="su[fatura_tarih]"
                                                        value="{{ old("su.fatura_tarih", $ayarlar['su.fatura_tarih'] ?? '') }}"
                                                        placeholder="Seçin"
                                                        class="form-control datetime"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Son Ödeme Günü<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="su[son_odeme_gun]"
                                                        value="{{ old("su.son_odeme_gun", $ayarlar['su.son_odeme_gun'] ?? '') }}"
                                                        min="1"
                                                        max="31"
                                                        step="1"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
                                                <input
                                                    type="text"
                                                    class="ucret form-control"
                                                    name="su[tuketim_birim_fiyat]"
                                                    value="{{ old("su.tuketim_birim_fiyat", $ayarlar['su.tuketim_birim_fiyat'] ?? '') }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Fatura Açıklaması<span class="text-danger">*</span></label>
                                                <textarea
                                                    class="form-control"
                                                    name="su[fatura_aciklama]"
                                                >{{ old("su.fatura_aciklama", $ayarlar['su.fatura_aciklama'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="v-pills-dogalgaz" role="tabpanel" aria-labelledby="v-pills-dogalgaz-tab">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Banka Hesap Adı<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="dogalgaz[banka_hesap_adi]"
                                                        value="{{ old("dogalgaz.banka_hesap_adi", $ayarlar['dogalgaz.banka_hesap_adi'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>IBAN<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="dogalgaz[banka_iban]"
                                                        value="{{ old("dogalgaz.banka_iban", $ayarlar['dogalgaz.banka_iban'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Fatura Tarihi<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        name="dogalgaz[fatura_tarih]"
                                                        value="{{ old("dogalgaz.fatura_tarih", $ayarlar['dogalgaz.fatura_tarih'] ?? '') }}"
                                                        placeholder="Seçin"
                                                        class="form-control datetime"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Son Ödeme Günü<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="dogalgaz[son_odeme_gun]"
                                                        value="{{ old("dogalgaz.son_odeme_gun", $ayarlar['dogalgaz.son_odeme_gun'] ?? '') }}"
                                                        min="1"
                                                        max="31"
                                                        step="1"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
                                                <input
                                                    type="text"
                                                    class="ucret form-control"
                                                    name="dogalgaz[tuketim_birim_fiyat]"
                                                    value="{{ old("dogalgaz.tuketim_birim_fiyat", $ayarlar['dogalgaz.tuketim_birim_fiyat'] ?? '') }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Varsayılan Fatura Açıklaması<span class="text-danger">*</span></label>
                                                <textarea
                                                    class="form-control"
                                                    name="dogalgaz[fatura_aciklama]"
                                                >{{ old("dogalgaz.fatura_aciklama", $ayarlar['dogalgaz.fatura_aciklama'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border bg-info col-md-12 mb-2 mt-4"></div>
                    <div class="row">
                        <div class="col-sm-12 text-lg-right m-t-20">
                            <button type="submit" class="btn btn-lg btn-primary">Kaydet</button>
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

    <script>
        $(function () {

            $.datetimepicker.setLocale('tr');

            $('.date').datetimepicker({
                timepicker: false,
                format: 'd.m.Y',
            });

            $('.datetime').datetimepicker({
                format: 'd.m.Y H:i',
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

        });
    </script>
@stop
