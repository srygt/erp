@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri ')
@section('title', 'Fatura Listesi')


@section('content')
<div class="col-sm-12">
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
        @else
            <div class="col-sm-12">
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle"></i>
                    Lütfen bekleyin, yönlendiriliyorsunuz...
                </div>
            </div>
            <form
                id="faturaTaslakForm"
                action="{{ route("faturataslak.ekle.post") }}"
                method="post"
            >
                @csrf

                @foreach ($params as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            </form>
        @endif
    </div>
</div>
@stop

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#faturaTaslakForm').submit();
        });
    </script>
@stop
