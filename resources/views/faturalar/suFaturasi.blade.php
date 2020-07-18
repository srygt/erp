@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri')
@section('title', 'Su Faturası Ekle')
@section('content')
    <form action="{{route("sufaturasiekle")}}" method="post">
        @csrf
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="body">

                    <div class="row clearfix">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message')}}
                            </div>
                        @endif
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <select class="form-control" name="aboneID">
                                    <option value="">ABONE SEÇİN</option>
                                    @foreach($suAboneler as $suAbone)
                                        <option value="{{$suAbone->mukellef->VKNTCKN}}">{{$suAbone->mukellef->UNVAN}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">

                                <input type="number" class="form-control" name="ilkEndeks" placeholder="İlk Endeks" value="{{old("ilkEndeks")}}">

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="sonEndeks" placeholder="Son Endeks" value="{{old("sonEndeks")}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar"></i></span>
                                    </div>
                                    <input  data-provide="datepicker" data-date-autoclose="true" name="sonOdemeTarihi"
                                           class="form-control date" placeholder="Son Ödeme Tarihi" value="{{old("sonOdemeTarihi")}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">

                                <input type="number" class="form-control" name="tuketim" placeholder="Tüketim" value="{{old("tuketim")}}">

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <input type="number" class="form-control" name="fiyati" placeholder="Fiyatı" value="{{old("fiyati")}}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <input type="number" class="form-control" name="tutari" placeholder="Tutarı" value="{{old("tutari")}}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <textarea rows="4" type="text" class="form-control" name="faturaAciklamasi"
                                          placeholder="Fatura Açıklaması" ></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-round btn-primary">Kaydet</button> &nbsp;&nbsp;
                    <button type="button" class="btn btn-round btn-default">İptal Et</button>


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
                format: 'dd/mm/yyyy',
                language: 'tr'
            });

            $('.btn-toastr').on('click', function () {
                $context = $(this).data('context');
                $message = $(this).data('message');
                $position = $(this).data('position');

                if ($context === '') {
                    $context = 'info';
                }

                if ($position === '') {
                    $positionClass = 'toast-bottom-right';
                } else {
                    $positionClass = 'toast-' + $position;
                }

                toastr.remove();
                toastr[$context]($message, '', {
                    positionClass: $positionClass
                });
            });

            $('#toastr-callback1').on('click', function () {
                $message = $(this).data('message');

                toastr.options = {
                    "timeOut": "300",
                    "onShown": function () {
                        alert('onShown callback');
                    },
                    "onHidden": function () {
                        alert('onHidden callback');
                    }
                };

                toastr['info']($message);
            });

            $('#toastr-callback2').on('click', function () {
                $message = $(this).data('message');

                toastr.options = {
                    "timeOut": "10000",
                    "onclick": function () {
                        alert('onclick callback');
                    },
                };

                toastr['info']($message);

            });

            $('#toastr-callback3').on('click', function () {
                $message = $(this).data('message');

                toastr.options = {
                    "timeOut": "10000",
                    "closeButton": true,
                    "onCloseClick": function () {
                        alert('onCloseClick callback');
                    }
                };

                toastr['info']($message);
            });
        });
    </script>
@stop
