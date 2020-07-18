@extends('layout.master')
@section('parentPageTitle', 'Abone İşlemleri ')
@section('title', 'Abone Listesi')


@section('content')

<div class="row clearfix">
    <div class="col-lg-12">

                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ÜNVAN</th>
                                <th>VKNTCKN</th>
                                <th>İL</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                         @foreach($mukelleflistesi as $mukellef)
                            <tr>
                                <td>{{$mukellef->MUKID}}</td>
                                <td><div class="font-15">{{$mukellef->UNVAN}}</div></td>
                                <td>{{$mukellef->VKNTCKN}}</td>
                                <td>{{$mukellef->IL}}</td>
                                <td>
                                    <a href="{{route('aboneduzenle',$mukellef->MUKID)}}"><i class="fa fa-edit"></i></a>
                                    <button type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>
                                </td>
                            </tr>
                         @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@stop

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}">
    <style>
        .dataTables_length{display: none;}
        .dataTables_filter input {
            background-color: white;
        }
    </style>
@stop

@section('page-script')
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script>

        $('.dataTable').DataTable( {
            "language": {
                "url":'{{asset('js/json/datatableturkish.json')}}',
            }
        } );
    </script>
@stop
