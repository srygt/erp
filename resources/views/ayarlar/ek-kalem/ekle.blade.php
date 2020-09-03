@extends('layout.master')
@section('parentPageTitle', 'Ayar İşlemleri')
@if(isset($ekKalem->id))
    @section('title', 'Ek Kalem Güncelle')
@else
    @section('title', 'Ek Kalem Ekle')
@endif
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
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-info">
                <div class="card-header">Ek Kalem Bilgileri</div>
                <div class="card-body">
                    <form
                        action="{{ isset($ekKalem->id)
                                    ? route('ayar.ek-kalem.update', ['id' => $ekKalem->id])
                                    : route('ayar.ek-kalem.store.post') }}"
                        method="post"
                    >
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Tür<span class="text-danger">*</span></label>
                                    <select id="tur" name="tur" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach(\App\Models\Abone::TUR_LIST as $slug => $title)
                                            <option
                                                value="{{ $slug }}"
                                                @if(old('tur', $ekKalem->tur ?? '') === $slug)
                                                selected
                                                @endif
                                            >
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Ücret Türü<span class="text-danger">*</span></label>
                                    <select id="ucretTur" name="ucret_tur" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach(\App\Models\AyarEkKalem::LIST_UCRET_TUR as $slug => $title)
                                            <option
                                                value="{{ $slug }}"
                                                @if(old('ucret_tur', $ekKalem->ucret_tur ?? '') === $slug)
                                                selected
                                                @endif
                                            >
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Başlık<span class="text-danger">*</span></label>
                                    <input class="form-control" name="baslik" value="{{ old('baslik', $ekKalem->baslik ?? '') }}" type="text">
                                </div>
                            </div>
                            <div id="oranContainer" class="col-sm-12" style="display: none;">
                                <div class="form-group">
                                    <label>Birim Fiyat</label>
                                    <input
                                        type="number"
                                        step="0.000000001"
                                        min="0.000000001"
                                        max="999.99999999"
                                        class="form-control"
                                        name="deger"
                                        value="{{ old('deger', $ekKalem->deger ?? '') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-lg-right m-t-20">
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
@stop

@section('page-script')
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
$('#ucretTur').on('change', function(){
    if ( $(this).children('option:selected').val() === "{{ \App\Models\AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT }}" )
    {
        $('#oranContainer').show(250);
    }
    else {
        $('#oranContainer').hide(250);
    }
})
.trigger('change');
</script>
@stop
