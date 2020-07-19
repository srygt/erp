@extends('layout.master')
@section('parentPageTitle', 'Sayaç İşlemleri')
@section('title', 'Sayaç Ekle')
@section('content')
    <form action="{{route("sayac.ekle.post")}}" method="post">
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
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <select class="form-control" name="MUKID">
                                    <option value="">MÜKELLEF SEÇİN</option>
                                    @foreach($mukellefler as $mukellef)
                                        <option value="{{$mukellef->VKNTCKN}}">{{$mukellef->UNVAN}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <select class="form-control" name="ABONETURU">
                                    <option value="">ABONE TÜRÜ SEÇİN</option>
                                    @foreach($aboneTurleri as $aboneTuru)
                                        <option value="{{$aboneTuru->ATID}}">{{$aboneTuru->ABONEADI}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <input type="number" class="form-control" name="SAYACNO" placeholder="Sayaç Numarası" value="{{old("ilkEndeks")}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <select class="form-control" name="DURUMU">
                                        <option value="">SAYAÇ DURUMU SEÇİN</option>
                                        <option value="true">Aktif</option>
                                        <option value="false">Pasif</option>
                                    </select>
                                </div>
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
