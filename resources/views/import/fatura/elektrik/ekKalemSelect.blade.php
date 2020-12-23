@php
    $ekKalemSabitFiyatlar = $ekKalemler->filter(function($ekKalem){
        return \App\Models\AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR === $ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR};
    });

    $ekKalemBirimFiyatlar = $ekKalemler->filter(function($ekKalem){
        return \App\Models\AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT === $ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR};
    });
@endphp
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Devreden Borç Alanını Seçiniz<span class="text-danger">*</span></label>
            <select id="gecikme_kalemi_id" name="params[gecikme_kalemi_id]" class="form-control">
                <option value="">Seçin</option>
                @foreach($ekKalemSabitFiyatlar as $ekKalem)
                    <option value="{{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_ID} }}">
                        {{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_BASLIK} }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Sistem Kullanım Bedeli Alanını Seçiniz<span class="text-danger">*</span></label>
            <select id="gecikme_kalemi_id" name="params[sistem_kullanim_id]" class="form-control">
                <option value="">Seçin</option>
                @foreach($ekKalemBirimFiyatlar as $ekKalem)
                    <option value="{{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_ID} }}">
                        {{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_BASLIK} }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Dağıtım Bedeli Alanını Seçiniz<span class="text-danger">*</span></label>
            <select id="gecikme_kalemi_id" name="params[dagitim_id]" class="form-control">
                <option value="">Seçin</option>
                @foreach($ekKalemBirimFiyatlar as $ekKalem)
                    <option value="{{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_ID} }}">
                        {{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_BASLIK} }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
