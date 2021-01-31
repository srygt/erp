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
            <label>Gecikme Bedeli Alanını Seçiniz<span class="text-danger">*</span></label>
            <select
                id="{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_GECIKME_BEDELI }}"
                name="params[{{ \App\Services\Import\Fatura\Elektrik\EkKalem::ID_GECIKME_BEDELI }}]"
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
