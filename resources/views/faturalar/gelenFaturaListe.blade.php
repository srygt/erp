@extends('layout.master')
@section('parentPageTitle', 'Fatura İşlemleri ')
@section('title', 'Fatura Listesi')


@section('content')

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="col-sm-12">
                    <form action="{{ route('fatura.gelen.liste') }}">
                        <div class="form-group">
                            <label>Filtre</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" name="since" id="since">
                                        <option value="">Seçin</option>
                                        @foreach(\App\Http\Requests\GelenFaturaRequest::GELEN_FATURA_DAY_LIST as $day)
                                            <option
                                                value="{{ $day }}"
                                                @if (request('since', \App\Http\Requests\GelenFaturaRequest::SINCE_DEFAULT) == $day)
                                                    selected
                                                @endif
                                            >
                                                Son {{ $day }} Gün
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">Filtrele</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                <thead>
                <tr>
                    <th>Fatura No</th>
                    <th>Mükellef</th>
                    <th>Doküman Türü</th>
                    <th>Doküman Profili</th>
                    <th>Durum</th>
                    <th>Okundu mu</th>
                    <th>Miktar</th>
                    <th>Oluşturulma Tarihi</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
             @foreach($faturalar as $fatura)
                <tr
                @if (!$fatura->IsRead)
                    class="notRead"
                @endif
                >
                    <td><div class="font-15">{{ $fatura->DocumentId }}</div></td>
                    <td><a title="{{ $fatura->TargetTitle }}" class="hideOverflow">{{ $fatura->TargetTitle }}</a></td>
                    <td>{{ $fatura->DocumentTypeCode }}</td>
                    <td>{{ $fatura->ProfileId }}</td>
                    <td>{{ $fatura->StatusExp }}</td>
                    <td class="readingStatus">
                        @if ($fatura->IsRead === true )
                            Evet
                        @elseif ($fatura->IsRead === false)
                            Hayır
                        @else
                            HATA!
                        @endif
                    </td>
                    <td>{{ $fatura->PayableAmount . $fatura->DocumentCurrencyCode }}</td>
                    <td>{{ $fatura->CreatedDate }}</td>
                    <td>
                        <a href="{{ route('fatura.detay', ['appType' => $fatura->AppType, 'uuid' => $fatura->UUID]) }}" class="btn btn-sm btn-default" ><i class="fa fa-download text-blue"></i></a>
                        @if ($fatura->IsRead === true )
                            <a href="javascript:" onclick="javascript:changeReadStatus(this, '{{ $fatura->UUID }}')" data-is-mark-readed="0" class="btn btn-sm btn-default" ><i class="fa fa-envelope text-green"></i></a>
                        @elseif ($fatura->IsRead === false)
                            <a href="javascript:" onclick="javascript:changeReadStatus(this, '{{ $fatura->UUID }}')" data-is-mark-readed="1" class="btn btn-sm btn-default" ><i class="fa fa-envelope-open text-green"></i></a>
                        @else
                            HATA!
                        @endif
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
        .dataTables_filter input {
            background-color: white;
        }
        .notRead td {
            background-color: rgb(192 215 255) !important;
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
            },
            "pageLength": 25,
            "order": [[ 7, "desc" ]],
        } );

        function changeReadStatus(element, uuid) {
            const $element = $(element)
            const isMarkReaded = $element.data('is-mark-readed');
            const confirmationType = isMarkReaded ? 'Okundu' : 'Okunmadı'

            swal({
                title: "İşlem Onayı",
                text: confirmationType + " olarak işaretlemek istediğiniz emin misiniz?",
                type: "info",
                showCancelButton: true,
                cancelButtonText: 'İptal',
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Evet",
                closeOnConfirm: true
            }, () => {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ route('fatura.api.okuma-durumu') }}",
                    data: {
                        uuid: uuid,
                        isMarkReaded: isMarkReaded,
                    }
                })
                    .done(() => {
                        const tr = $element.closest('tr')

                        if (isMarkReaded) {
                            tr.removeClass('notRead')
                            tr.children('.readingStatus').html('Evet')
                            $element.children('i').removeClass('fa-envelope').addClass('fa-envelope-open')
                            $element.data('is-mark-readed', 0)
                        }
                        else {
                            tr.addClass('notRead')
                            tr.children('.readingStatus').html('Hayır')
                            $element.children('i').removeClass('fa-envelope-open').addClass('fa-envelope')
                            $element.data('is-mark-readed', 1)
                        }

                        swal(
                            confirmationType + " olarak işaretlendi!",
                            confirmationType + " olarak işaretleme işlemi başarı ile tamamlandı.", "success"
                        );
                    })
                    .fail(( jqXHR, textStatus ) => {
                        alert( "Request failed: " + textStatus );
                    });
            });
        }
    </script>
@stop
