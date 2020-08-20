@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri')
@section('title', 'Su Faturası Ekle')
@section('content')
    <form action="{{route("faturataslak.ekle.post")}}" method="post">
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
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label>Abone<span class="text-danger">*</span></label>
                                <select class="form-control" name="abone_id">
                                    <option value="">Seçin</option>
                                    @foreach($aboneler as $abone)
                                        <option
                                            value="{{ $abone->id }}"
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
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="birim_fiyat" value="{{old("birim_fiyat")}}" min="0.000000" step="0.000001">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Son Ödeme Tarihi<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input data-provide="datepicker" data-date-autoclose="true" name="son_odeme_tarihi"
                                           class="form-control date" placeholder="Seçin" value="{{old("son_odeme_tarihi")}}">
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

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
@stop

@section('page-script')
    <script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.tr.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.js') }}"></script>

    <script>
        $(function () {

            $('.date').datepicker({
                format: 'dd.mm.yyyy',
                language: 'tr'
            });

        });
    </script>
@stop
