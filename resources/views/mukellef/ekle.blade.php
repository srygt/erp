@extends('layout.master')
@section('parentPageTitle', 'Mükellef İşlemleri')
@if(isset($abone->id))
    @section('title', 'Mükellef Güncelle')
@else
    @section('title', 'Mükellef Ekle')
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
        <div class="col-md-12">
            <div class="card text-white bg-info">
                <div class="card-header">Mükellef Bilgileri</div>
                <div class="card-body">
                    <form action="{{route("mukellef.ekle.post")}}" method="post">
                        @csrf
                        @if(isset($mukellef->id))
                            <input type="hidden" name="id" value="{{ $mukellef->id }}">
                        @endif
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>VKN/TCKN<span class="text-danger">*</span></label>
                                    <input
                                        class="form-control"
                                        id="vkntckn"
                                        name="vkntckn"
                                        type="text"
                                        value="{{
                                            old(
                                                'vkntckn',
                                                implode(
                                                    '',
                                                    $mukellef->only(\App\Models\Mukellef::COLUMN_VERGI_NO, \App\Models\Mukellef::COLUMN_TC_KIMLIK_NO)
                                                )
                                            )
                                        }}">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Ünvan<span class="text-danger">*</span></label>
                                    <input class="form-control" name="unvan" value="{{ old('unvan', $mukellef->unvan) }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Vergi Dairesi Şehir</label>
                                    <input type="text" class="form-control" name="vergi_dairesi_sehir" value="{{ old('vergi_dairesi_sehir', $mukellef->vergi_dairesi_sehir) }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Vergi Dairesi<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="vergi_dairesi" value="{{ old('vergi_dairesi', $mukellef->vergi_dairesi) }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Urn</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="urn" placeholder="urn:mail:aaa@bbb.com" value="{{ old('urn', $mukellef->urn) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Ad</label>
                                    <input class="form-control" name="ad" value="{{ old('ad', $mukellef->ad) }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Soyad</label>
                                    <input class="form-control" name="soyad" value="{{ old('soyad', $mukellef->soyad) }}" type="text">
                                </div>
                            </div>
                            <div class="border bg-info col-md-12 mb-3" ></div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>E-Posta</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-envelope"></i></span>
                                        </div>
                                        <input class="form-control" value="{{ old('email', $mukellef->email) }}" name="email" type="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Telefon Numarası</label>
                                    <input class="form-control" value="{{ old('telefon', $mukellef->telefon) }}" name="telefon" placeholder="905001112233" type="tel">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Website Adresi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-globe"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="website" placeholder="http://" value="{{ old('website', $mukellef->website) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Ülke<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ulke" readonly value="{{ $mukellef->ulke ? $mukellef->ulke : 'Türkiye' }}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>İl<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="il" value="{{ old('il', $mukellef->il) }}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>İlçe<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ilce" value="{{ old('ilce', $mukellef->ilce) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Adres<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="adres" id="adres" rows="3">{{ old('adres', $mukellef->adres) }}</textarea>
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}">
@stop

@section('page-script')
            <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
            <script src="{{ asset('js/abonejs.js') }}"></script>
            <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
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

                /*Vd*/
                $.getJSON("{{ asset('js/json/il-bolge.json') }}",function (sonuc) {
                    $.each(sonuc, function(index, value){
                        var row="";
                        row +='<option value="'+value.il+'">'+value.il+'</option>';
                        $("#vdil").append(row);
                    })

                    $("#vdil").trigger('optionsLoaded');
                })

                $("#vdil").on("change", function(){
                    var il=$(this).val();
                    $("#vd").attr("disabled", false).html("<option value='0'>Seçin..</option>");
                    $.getJSON("{{ asset('js/json/vergidaireleri.json') }}", function(sonuc){
                        $.each(sonuc,function(index,value){
                            if (value.il==il){
                                $.each(value.vd, function(index, value){

                                    var row = "";

                                    row += '<option value="' + value.ad+ '">' + value.ad + '</option>';
                                    $("#vd").append(row);
                                });
                            }
                        });

                        $("#vd").trigger('optionsLoaded');
                    });
                });

                // update
                var selectedVergiDairesiSehir = "{{ old('vergi_dairesi_sehir', $mukellef->vergi_dairesi_sehir) }}";
                var selectedVergiDairesi = "{{ old('vergi_dairesi', $mukellef->vergi_dairesi) }}";
                var selectedIl = "{{ old('il', $mukellef->il) }}";
                var selectedIlce = "{{ old('ilce', $mukellef->ilce) }}";

                var selectedOptions = [
                    {
                        'selector': '#vdil',
                        'value': selectedVergiDairesiSehir,
                        'counter': 0,
                    },
                    {
                        'selector': '#vd',
                        'value': selectedVergiDairesi,
                        'counter': 0,
                    },
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



            </script>


@stop
