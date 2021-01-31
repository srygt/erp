<table class="table table-striped">
    <thead>
    <tr>
        <th>Başlık</th>
        <th>Birim Fiyat</th>
    </tr>
    </thead>
    @foreach(array_keys(\App\Models\Abone::TUR_LIST) as $tur)
        <tbody id="ekKalemList-{{ $tur }}" class="ekKalemList" style="{{ ($openTable ?? '') !== $tur ? 'display: none;' : '' }}">
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
                    <input
                        type="number"
                        class="form-control"
                        name="ek_kalemler[{{ $tur }}][{{ $key }}][deger]"

                        @if ($ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR} === \App\Models\AyarEkKalem::FIELD_UCRET_DEGISKEN_TUTAR)
                        value="{{ old('ek_kalemler[' . $tur . '][' . $key . '][deger]') }}"
                        @elseif ($ekKalem->{\App\Models\AyarEkKalem::COLUMN_UCRET_TUR} === \App\Models\AyarEkKalem::FIELD_UCRET_BIRIM_FIYAT)
                        value="{{ $ekKalem->{\App\Models\AyarEkKalem::COLUMN_DEGER} }}"
                        @endif

                        min="0.000000000"
                        step="0.000000001"
                    >
                </td>
            </tr>
        @endforeach
        </tbody>
    @endforeach
</table>
