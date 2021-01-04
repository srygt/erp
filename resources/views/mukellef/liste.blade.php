@extends('layout.master')
@section('parentPageTitle', 'Mükellef İşlemleri ')
@section('title', 'Mükellef Listesi')

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
                    <th>Unvan</th>
                    <th>Telefon</th>
                    <th>ePosta</th>
                    <th>İl</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($mukellefler as $mukellef)
                    <tr>
                        <td>{{$mukellef->id}}</td>
                        <td><div class="font-15">{{ $mukellef->getIdentificationId() }}</div></td>
                        <td><a title="{{ $mukellef->unvan }}" class="hideOverflow">{{ $mukellef->unvan }}</a></td>
                        <td>{{ $mukellef->telefon }}</td>
                        <td>{{ $mukellef->email }}</td>
                        <td>{{ $mukellef->il }}</td>
                        <td>
                            <a href="{{ route('mukellef.guncelle.get', $mukellef->id) }}" class="btn btn-sm btn-default" ><i class="fa fa-edit text-blue"></i></a>
                            <form action="{{route('mukellef.pasiflestir')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $mukellef->id }}">
                                <button type="button" class="btn btn-sm btn-default pasiflestir"><i class="fa fa-trash-o text-danger"></i></button>
                            </form>
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
        .table-responsive form {
            display: inline;
        }
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

        $(document).ready(function(){
            $(document).on("click", ".pasiflestir", function(e) {
                var form = $(this).parents('form');

                swal({
                    title: "Pasifleştirme istediğinize emin misiniz?",
                    // text: "Silinen verileri geri getiremezsiniz!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'İptal',
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Evet, pasifleştir!",
                    closeOnConfirm: false
                }, (confirmed) => {
                    if( confirmed ){
                        form.submit();
                    }
                });

            });
        })
    </script>
@stop
