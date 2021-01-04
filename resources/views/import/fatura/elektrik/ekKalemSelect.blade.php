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
        <div class="form-group">
            <label>Birim Tüketim Fiyatı<span class="text-danger">*</span></label>
            <input
                id="{{ \App\Models\Fatura::COLUMN_BIRIM_FIYAT_TUKETIM }}"
                name="params[{{ \App\Models\Fatura::COLUMN_BIRIM_FIYAT_TUKETIM }}]"
                type="text"
                class="ucret form-control"
            >
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
        <div class="form-group">
            <label>Birim Sistem Fiyatı<span class="text-danger">*</span></label>
            <input
                id="{{ \App\Services\Import\Fatura\Elektrik\EkKalem::BIRIM_FIYAT_SISTEM_KULLANIM }}"
                name="params[{{ \App\Services\Import\Fatura\Elektrik\EkKalem::BIRIM_FIYAT_SISTEM_KULLANIM }}]"
                type="text"
                class="ucret form-control"
            >
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
        <div class="form-group">
            <label>Dağıtım Birim Fiyatı<span class="text-danger">*</span></label>
            <input
                id="{{ \App\Services\Import\Fatura\Elektrik\EkKalem::BIRIM_FIYAT_DAGITIM_BEDELI }}"
                name="params[{{ \App\Services\Import\Fatura\Elektrik\EkKalem::BIRIM_FIYAT_DAGITIM_BEDELI }}]"
                type="text"
                class="ucret form-control"
            >
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Endüktif Birim Fiyat<span class="text-danger">*</span></label>
            <input
                id="{{ \App\Models\Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT }}"
                name="params[{{ \App\Models\Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT }}]"
                type="text"
                class="ucret form-control"
            >
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
            <label>Kapasitif Birim Fiyat<span class="text-danger">*</span></label>
            <input
                id="{{ \App\Models\Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT }}"
                name="params[{{ \App\Models\Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT }}]"
                type="text"
                class="ucret form-control"
            >
        </div>
    </div>
</div>

@section('page-script')
    @parent
    <script src="{{ asset('assets/vendor/jquery-turk-lirasi-maskesi/jquery.turkLirasi.min.js') }}"></script>
    <script type="text/javascript">

        $(function () {

            $('form:first').on('submit', function(){
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
        })
    </script>
@append
