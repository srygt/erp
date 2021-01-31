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
            @yield('redirectBody')
        @endif
    </div>
</div>
@stop
