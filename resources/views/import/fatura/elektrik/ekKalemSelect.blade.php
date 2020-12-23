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
            <select
                id="{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_DEVREDEN_BORC }}"
                name="params[{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_DEVREDEN_BORC }}]"
                class="form-control"
            >
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
            <select
                id="{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_SISTEM_KULLANIM }}"
                name="params[{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_SISTEM_KULLANIM }}]"
                class="form-control"
            >
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
            <select
                id="{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_DAGITIM_BEDELI }}"
                name="params[{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_DAGITIM_BEDELI }}]"
                class="form-control"
            >
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
