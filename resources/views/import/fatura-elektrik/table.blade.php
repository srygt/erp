<div class="table-responsive">
    <div style="overflow: auto">
        <table class="table dataTable">
            <thead>
            <tr>
                <th>#</th>
                <th>Abone No</th>
                <th>Abone Adı</th>
                <th>Toplam Tüketim</th>
                <th>Gündüz</th>
                <th>Puand</th>
                <th>Gece</th>
                <th>Reaktif Tüketim</th>
                <th>Kapasitif Tüketim</th>
                <th>Reaktif Bedel</th>
                <th>Kapasitif Bedel</th>
                <th>Sistem Kullanım Bedeli</th>
                <th>Dağıtım Bedeli</th>
                <th>TRT Payı</th>
                <th>Gecikme Zammı</th>
                <th>KDV Matrahı</th>
                <th>KDV Bedeli</th>
                <th>Fatura Toplamı</th>
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
