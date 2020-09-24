@extends('layout.master')
@section('parentPageTitle', 'Abone İşlemleri')
@if(isset($abone->id))
    @section('title', 'Abone Güncelle')
@else
    @section('title', 'Abone Ekle')
@endif

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropify/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-select2/css/select2.min.css') }}"/>
@append

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
        <div class="col-md-12">
            <div class="card text-white bg-info">
                <div class="card-header">Abone Bilgileri</div>
                <div class="card-body">
                    <form action="{{route("abone.ekle.post")}}" method="post">
                        @csrf
                        <div class="row">
                            @if(isset($abone->id))
                                <input type="hidden" name="id" value="{{ $abone->id }}">
                            @endif
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Abonelik Türü<span class="text-danger">*</span></label>
                                    <select id="tur" name="tur" class="form-control">
                                        <option value="">Seçin...</option>
                                        @foreach(\App\Models\Abone::TUR_LIST as $slug => $title)
                                            <option
                                                value="{{ $slug }}"
                                                @if(old('tur', $abone->tur) === $slug)
                                                    selected
                                                @endif
                                            >{{ $title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Mükellef<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select class="form-control" name="mukellef_id" id="mukellef_id">
                                                <option value="">Seçin...</option>
                                                @foreach($mukellefler as $mukellef)
                                                    <option
                                                        value="{{ $mukellef->id }}"
                                                        @if(old('mukellef_id', $abone->mukellef_id) === $mukellef->id)
                                                            selected
                                                        @endif
                                                    >{{ $mukellef->unvan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary" id="contactFetch" onclick="fillContactInfo($('#mukellef_id').val())">
                                                <i class="fa fa-refresh"></i> <span>İletişim Bilgilerini Çek</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Abonelik Adı<span class="text-danger">*</span></label>
                                    <input class="form-control" name="baslik" placeholder="Merkez Şube" value="{{ old('baslik', $abone->baslik) }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Abone No</label>
                                    <input class="form-control" name="abone_no" value="{{ old('abone_no', $abone->abone_no) }}" type="number">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Sayaç No</label>
                                    <input class="form-control" name="sayac_no" value="{{ old('sayac_no', $abone->sayac_no) }}" type="number">
                                </div>
                            </div>
                            <div id="enduktifContainer" class="elektrik-specific col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Endüktif Bedel Uygulanacak<span class="text-danger">*</span></label>
                                    <select class="form-control" name="enduktif_bedel" id="enduktif_bedel">
                                        <option value="">Seçin</option>
                                        <option
                                            value="1"
                                            @if (old("enduktif_bedel", $abone->enduktif_bedel) == '1')
                                            selected
                                            @endif
                                        >
                                            Evet
                                        </option>
                                        <option
                                            value="0"
                                            @if (old("enduktif_bedel", $abone->enduktif_bedel) == '0')
                                            selected
                                            @endif
                                        >
                                            Hayır
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div id="kapasitifContainer" class="elektrik-specific col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Kapasitif Bedel Uygulanacak<span class="text-danger">*</span></label>
                                    <select class="form-control" name="kapasitif_bedel" id="kapasitif_bedel">
                                        <option value="">Seçin</option>
                                        <option
                                            value="1"
                                            @if (old("kapasitif_bedel", $abone->kapasitif_bedel) == '1')
                                            selected
                                            @endif
                                        >
                                            Evet
                                        </option>
                                        <option
                                            value="0"
                                            @if (old("kapasitif_bedel", $abone->kapasitif_bedel) == '0')
                                            selected
                                            @endif
                                        >
                                            Hayır
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div id="trtPayiContainer" class="elektrik-specific col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Trt Payı Uygulanacak<span class="text-danger">*</span></label>
                                    <select class="form-control" name="trt_payi" id="trt_payi">
                                        <option value="">Seçin</option>
                                        <option
                                            value="1"
                                            @if (old("trt_payi", $abone->trt_payi) == '1')
                                            selected
                                            @endif
                                        >
                                            Evet
                                        </option>
                                        <option
                                            value="0"
                                            @if (old("trt_payi", $abone->trt_payi) == '0')
                                            selected
                                            @endif
                                        >
                                            Hayır
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Abonelik Durumu<span class="text-danger">*</span></label>
                                    <select id="aktif_mi" name="aktif_mi" class="form-control">
                                        <option value="">Seçin...</option>
                                        <option
                                            value="1"
                                            @if(old('tur', $abone->aktif_mi) > 0)
                                            selected
                                            @endif
                                        >Aktif</option>
                                        <option
                                            value="0"
                                            @if(old('tur', $abone->aktif_mi) == 0)
                                            selected
                                            @endif
                                        >Pasif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="border bg-info col-md-12 mb-3" ></div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>E-Posta</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-envelope"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('email', $abone->email) }}" name="email" id="email" type="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Telefon Numarası</label>
                                    <input class="form-control" value="{{ old('telefon', $abone->telefon) }}" name="telefon" id="telefon" placeholder="905001112233" type="tel">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Website Adresi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-globe"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="website" id="website" placeholder="http://" value="{{ old('website', $abone->website) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Ülke<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ulke" name="ulke" readonly value="{{ $abone->ulke ? $abone->ulke : 'Türkiye' }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>İl<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="il" name="il" value="{{ old('il', $abone->il) }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>İlçe<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ilce" name="ilce" value="{{ old('ilce', $abone->ilce) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Urn</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="urn" id="urn" placeholder="urn:mail:aaa@bbb.com" value="{{ old('urn', $abone->urn) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label>Adres</label>
                                    <textarea class="form-control" name="adres" id="adres" rows="3">{{ old('adres', $abone->adres) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-right m-t-20">
                                <button type="submit" class="btn btn-primary btn-lg">Gönder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page-script')
            <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
            <script src="{{ asset('js/abonejs.js') }}"></script>
            <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
            <script src="{{ asset('assets/vendor/jquery-select2/js/select2.min.js') }}"></script>
            <script>

                $.getJSON("{{ asset('js/json/il-bolge.json') }}",function (sonuc) {
                    $.each(sonuc, function(index, value){
                        var row="";
                        row +='<option value="'+value.il+'">'+value.il+'</option>';
                        $("#il").append(row);
                    })
                    $("#il").trigger('optionsLoaded');
                })
                $("#il").on("change", function(){
                    var il=$(this).val();
                    $("#ilce").attr("disabled", false).html("<option value='0'>Seçin..</option>");
                    $.getJSON("{{ asset('js/json/il-ilce.json') }}", function(sonuc){
                        $.each(sonuc, function(index, value){
                            var row="";
                            if(value.il==il)
                            {
                                row +='<option value="'+value.ilce+'">'+value.ilce+'</option>';
                                $("#ilce").append(row);
                            }
                        });
                        $("#ilce").trigger('optionsLoaded');
                    });
                });

                // update
                var selectedIl = "{{ old('il', $abone->il) }}";
                var selectedIlce = "{{ old('ilce', $abone->ilce) }}";

                var selectedOptions = [
                    {
                        'selector': '#il',
                        'value': selectedIl,
                        'counter': 0,
                    },
                    {
                        'selector': '#ilce',
                        'value': selectedIlce,
                        'counter': 0,
                    },
                ];

                selectedOptions.forEach((selectedOption) => {
                    $(selectedOption.selector).on('optionsLoaded', function(){
                        if (selectedOption.counter === 0 && selectedOption.value) {
                            $(selectedOption.selector).val(selectedOption.value).trigger('change');
                        }

                        selectedOption.counter++;
                    });
                });

                $('#mukellef_id')
                    .on('change', function(){
                        $('#contactFetch').prop('disabled', !$(this).val());
                    })
                    .trigger('change')
                    .select2();

                $('#tur').on('change', function(){

                    if ( $(this).children('option:selected').val() === "{{ \App\Models\Abone::COLUMN_TUR_ELEKTRIK }}" )
                    {
                        $('.elektrik-specific').show(250);
                    }
                    else {
                        $('.elektrik-specific').hide(250);
                    }
                })
                .trigger('change');

                function fillContactInfo(mukellefId) {
                    var url = '{{ route('mukellef.detay', ['id' => ':id']) }}';

                    $.get(url.replace(':id', mukellefId), function( mukellef )
                    {
                        $('#email').val(mukellef.email);
                        $('#telefon').val(mukellef.telefon);
                        $('#website').val(mukellef.website);
                        $('#ulke').val(mukellef.ulke);
                        $('#il').val(mukellef.il);
                        $('#ilce').val(mukellef.ilce);
                        $('#urn').val(mukellef.urn);
                        $('#adres').val(mukellef.adres);
                    });
                }

            </script>


@stop
