@extends('layout.master')
@section('parentPageTitle', 'Ayar İşlemleri ')
@section('title', 'Ek Kalem Listesi')


@section('content')

<div class="row clearfix">
    <div class="col-lg-12">

                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tür</th>
                                <th>Başlık</th>
                                <th>Oran</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                         @foreach($ekKalemler as $ekKalem)
                            <tr>
                                <td>{{$ekKalem->id}}</td>
                                <td><div class="font-15">{{ \App\Models\Abone::TUR_LIST[$ekKalem->tur] }}</div></td>
                                <td>{{ $ekKalem->baslik }}</td>
                                <td>{{ $ekKalem->deger }}</td>
                                <td>
                                    <a href="{{ route('ayar.ek-kalem.show', $ekKalem->id) }}" class="btn btn-sm btn-default" ><i class="fa fa-edit text-blue"></i></a>
                                    <a data-id="{{ $ekKalem->id }}" href="javascript:" class="btn btn-sm btn-default onr-delete"><i class="fa fa-trash-o text-danger"></i></a>
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

        $('.onr-delete').on('click', function(){
            deleteItem(
                $(this).parents('tr'),
                "{{ route('ayar.ek-kalem.destroy', ':id') }}".replace(':id', $(this).data('id'))
            );
        });

    </script>
@stop
