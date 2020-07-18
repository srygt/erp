@extends('layout.master')
@section('parentPageTitle', 'Abone İşlemleri')
@section('title', 'Abone Ekle')
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card text-white bg-info">
                <div class="card-header">Abone Bilgileri</div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message')}}
                        </div>
                    @endif
                    <form {{route("aboneguncelle",$mukellefbilgi->MUKID)}} method="post">
                        @csrf
                        {!! method_field('PUT') !!}
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>VKN/TCKN<span class="text-danger">*</span></label>
                                    <input class="form-control" name="vkn_tckn" type="text" value="{{$mukellefbilgi->VKNTCKN}}">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Unvan<span class="text-danger">*</span></label>
                                    <input class="form-control" name="unvan" value="{{$mukellefbilgi->UNVAN}}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Adı</label>
                                    <input class="form-control" name="ad" value="{{$mukellefbilgi->AD}}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Soyadı</label>
                                    <input class="form-control" name="soyad" value="{{$mukellefbilgi->SOYAD}}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Abone Tipi <span class="text-danger">*</span></label>
                                    <select class="form-control" id="abonetipi" name="abonetipi">
                                        <option value="">Seçin...</option>
                                        <option value="1">Su</option>
                                        <option value="2">Elektirik</option>
                                        <option value="3">Doğalgaz</option>
                                        <option value="4">Su/Elektirik</option>
                                        <option value="5">Su/Doğalgaz</option>
                                        <option value="6">Elektirik/Doğalgaz</option>
                                        <option value="7">Su/Elektrik/Doğalgaz</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Vergi Dairesi Şehir</label>
                                    <select class="form-control" id="vdil" name="vdil">
                                        <option value="">Seçin...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Vergi Dairesi</label>
                                    <select class="form-control" id="vd" name="vd">
                                        <option value="">Seçin...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Ticaret Odası</label>
                                    <input class="form-control" value="" name="ticod" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Mersis No</label>
                                    <input class="form-control" value="" name="mersisno" type="text">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Ticaret Sicil No</label>
                                    <input class="form-control" value="" name="ticsicilno" type="text">
                                </div>
                            </div>
                            <div class="border bg-info col-md-12 mb-3" ></div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>E-Posta <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-envelope"></i></span>
                                        </div>
                                        <input class="form-control" value="" name="eposta" type="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Website Adresi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-globe"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="site" placeholder="http://">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Ülke<span class="text-danger">*</span></label>
                                    <select class="form-control" name="ulke">
                                        <option value="Türkiye">Türkiye</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>İl<span class="text-danger">*</span></label>
                                    <select class="form-control" id="il"   name="il">
                                        <option value="">Seçin...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>İlçe<span class="text-danger">*</span></label>
                                    <select class="form-control" id="ilce" name="ilce">
                                        <option value="">Seçin...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Posta Kodu</label>
                                    <input class="form-control" value="" name="postakodu" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Mahalle/Cadde</label>
                                    <input class="form-control" value="" name="mahalle_cadde" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Bina Adı</label>
                                    <input class="form-control" value="" name="bina_adi" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Bina No</label>
                                    <input class="form-control" value="" name="bina_no" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Daire No</label>
                                    <input class="form-control" value="" name="daire_no" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefon Numarası</label>
                                    <input class="form-control" value="" name="telno" type="number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Faks</label>
                                    <input class="form-control" value="" name="faks" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-lg-center m-t-20">
                                <button type="submit" class="btn btn-primary btn-lg  ">Kaydet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if ($errors->any())
            <div class="col-lg-6 col-md-12">
                <div class="alert alert-danger">
                    <h5>Lütfen yanlışlarınızı düzeltiniz.</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif


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
              var abonetipival="{{$abonetipimuk->ABONETIPI}}";
              var vds="{{$mukellefbilgi->VERGIDAIRESISEHIR}}";
              var vd="{{$mukellefbilgi->VERGIDAIRESI}}";
              var il="{{$mukellefbilgi->IL}}";
              var ilce ="{{$mukellefbilgi->ILCE}}";
                console.log(abonetipival)
            var a = function(){
                $("#abonetipi option").each(function(){
                    if ($(this).val() === abonetipival)
                        $(this).attr("selected","selected");
                });
                $.getJSON("{{ asset('js/json/il-bolge.json') }}",function (sonuc) {
                    $.each(sonuc, function(index, value){
                        var row="";
                        row +='<option value="'+value.il+'">'+value.il+'</option>';
                        $("#il").append(row);

                    })
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
                    });
                });

                /*Vd*/
                $.getJSON("{{ asset('js/json/il-bolge.json') }}",function (sonuc) {
                    $.each(sonuc, function(index, value){
                        var row="";
                        row +='<option value="'+value.il+'">'+value.il+'</option>';
                        $("#vdil").append(row);
                    })
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
                    });
                });
                console.log("a bitti");
            }

            var b = function(){

                    $("#vdil option").each(function(){
                        if ($(this).val()===vds)
                            $(this).attr("selected","selected");
                    });
                    $("#vd option").each(function(){
                        if ($(this).val()===vd)
                            $(this).attr("selected","selected");
                    });
                    $("#il option").each(function(){
                        if ($(this).val()===il)
                            $(this).attr("selected","selected");
                    });
                    $("#ilce option").each(function(){
                        if ($(this).val()===ilce)
                            $(this).attr("selected","selected");
                    });

                console.log("b bitti");
            }
            a();
            $("Document").ready(function () {

                   b();
            })



            </script>


@stop

