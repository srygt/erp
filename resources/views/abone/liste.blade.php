@extends('layout.master')
@section('parentPageTitle', 'Abone İşlemleri ')
@section('title', 'Abone Listesi')


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
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>VKN / TCKN</th>
                    <th>Abone No</th>
                    <th>Sayaç No</th>
                    <th>Abone</th>
                    <th>Ünvan</th>
                    <th>Tür</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
             @foreach($aboneler as $abone)
                <tr>
                    <td>{{ $abone->id }}</td>
                    <td>{{ $abone->mukellef->getIdentificationId() }}</td>
                    <td>{{ $abone->abone_no }}</td>
                    <td>{{ $abone->sayac_no }}</td>
                    <td><div class="font-15">{{ $abone->baslik }}</div></td>
                    <td>{{ $abone->mukellef->unvan }}</td>
                    <td>{{ \App\Models\Abone::TUR_LIST[$abone->tur] }}</td>
                    <td>
                        <a href="{{ route('abone.guncelle.get', $abone->id) }}" class="btn btn-sm btn-default" ><i class="fa fa-edit text-blue"></i></a>
                        <!-- <button type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button> -->
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
