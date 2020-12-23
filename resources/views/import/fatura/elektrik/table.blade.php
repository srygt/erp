<div class="table-responsive">
    <div style="overflow: auto; resize: vertical; height: 600px;">
        <table id="elektrikDatatable" class="table dataTable">
            <thead>
                <tr>
                    <th class="bg-secondary"><span class="text-light">#</span></th>
                    <th class="bg-primary"><span class="text-light">Abone No</span></th>
                    <th class="bg-secondary"><span class="text-light">Abone Adı</span></th>
                    <th class="bg-primary"><span class="text-light">Toplam Tüketim</span></th>
                    <th class="bg-primary"><span class="text-light">Gündüz</span></th>
                    <th class="bg-primary"><span class="text-light">Puand</span></th>
                    <th class="bg-primary"><span class="text-light">Gece</span></th>
                    <th class="bg-primary"><span class="text-light">Reaktif Tüketim</span></th>
                    <th class="bg-primary"><span class="text-light">Kapasitif Tüketim</span></th>
                    <th class="bg-secondary"><span class="text-light">Reaktif Bedel</span></th>
                    <th class="bg-secondary"><span class="text-light">Kapasitif Bedel</span></th>
                    <th class="bg-secondary"><span class="text-light">Sistem Kullanım Bedeli</span></th>
                    <th class="bg-secondary"><span class="text-light">Dağıtım Bedeli</span></th>
                    <th class="bg-secondary"><span class="text-light">TRT Payı</span></th>
                    <th class="bg-primary"><span class="text-light">Gecikme Zammı</span></th>
                    <th class="bg-secondary"><span class="text-light">KDV Matrahı</span></th>
                    <th class="bg-secondary"><span class="text-light">KDV Bedeli</span></th>
                    <th class="bg-secondary"><span class="text-light">Fatura Toplamı</span></th>
                    <th class="bg-primary"><span class="text-light">Birim Tüketim Ücreti</span></th>
                    <th class="bg-primary"><span class="text-light">Birim Reaktif Ücreti</span></th>
                    <th class="bg-primary"><span class="text-light">Birim Kapasitif Ücreti</span></th>
                    <th class="bg-primary"><span class="text-light">Birim Sistem Kullanım Ücreti</span></th>
                    <th class="bg-primary"><span class="text-light">Birim Dağıtım Ücreti</span></th>
                </tr>
            </thead>
            <tbody>
            @foreach($faturaList as $index => $fatura)
                <tr>
                    <td>{{ $index + \App\Imports\ElektrikFaturasImport::START_ROW }}</td>
                    <td>{{$fatura[0]}}</td>
                    <td>{{$fatura[1]}}</td>
                    <td class="text-right">{{$fatura[2]}}</td>
                    <td class="text-right">{{$fatura[3]}}</td>
                    <td class="text-right">{{$fatura[4]}}</td>
                    <td class="text-right">{{$fatura[5]}}</td>
                    <td class="text-right">{{$fatura[6]}}</td>
                    <td class="text-right">{{$fatura[7]}}</td>
                    <td class="text-right">{{$fatura[8]}}</td>
                    <td class="text-right">{{$fatura[9]}}</td>
                    <td class="text-right">{{$fatura[10]}}</td>
                    <td class="text-right">{{$fatura[11]}}</td>
                    <td class="text-right">{{$fatura[12]}}</td>
                    <td class="text-right">{{$fatura[13]}}</td>
                    <td class="text-right">{{$fatura[14]}}</td>
                    <td class="text-right">{{$fatura[15]}}</td>
                    <td class="text-right">{{$fatura[16]}}</td>
                    <td class="text-right">{{$fatura[17]}}</td>
                    <td class="text-right">{{$fatura[18]}}</td>
                    <td class="text-right">{{$fatura[19]}}</td>
                    <td class="text-right">{{$fatura[20]}}</td>
                    <td class="text-right">{{$fatura[21]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        .dataTables_filter input {
            background-color: white;
        }
        #elektrikDatatable th {
            position: sticky;
            top: 0;
        }
        thead
    </style>
@append

@section('page-script')
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script>

        $('.dataTable').DataTable( {
            "language": {
                "url":'{{asset('js/json/datatableturkish.json')}}',
            },
            "pageLength": 10,
            "order": [[ 0, "asc" ]],
        } );
    </script>
@append
