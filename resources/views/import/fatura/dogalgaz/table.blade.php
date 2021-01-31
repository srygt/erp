<div class="table-responsive">
    <div style="overflow: auto; resize: vertical; height: 600px;">
        <table id="dogalgazDatatable" class="table dataTable">
            <thead>
                <tr>
                    <th class="bg-secondary"><span class="text-light">#</span></th>
                    <th class="bg-primary"><span class="text-light">Abone No</span></th>
                    <th class="bg-secondary"><span class="text-light">Firma Adı</span></th>
                    <th class="bg-secondary"><span class="text-light">Basınç (Bar)</span></th>
                    <th class="bg-secondary"><span class="text-light">İlk Endeks (m³)</span></th>
                    <th class="bg-secondary"><span class="text-light">Son Endeks(m³)</span></th>
                    <th class="bg-secondary"><span class="text-light">Fark(m³)</span></th>
                    <th class="bg-secondary"><span class="text-light">Ger. Tük.(m³)</span></th>
                    <th class="bg-secondary"><span class="text-light">Düz. Tük. (Sm³)</span></th>
                    <th class="bg-primary"><span class="text-light">Toplam Sm3</span></th>
                    <th class="bg-secondary"><span class="text-light">Kw Dönüşüm Katsayısı</span></th>
                    <th class="bg-secondary"><span class="text-light">Düzeltilmiş Tüketim (Kw)</span></th>
                    <th class="bg-secondary"><span class="text-light">Toplam Düzeltilmiş Tüketim (Kw)</span></th>
                    <th class="bg-primary"><span class="text-light">Birim Fiyat (TL/Kw)</span></th>
                    <th class="bg-secondary"><span class="text-light">KDV Hariç Bedel (TL)</span></th>
                    <th class="bg-secondary"><span class="text-light">ÖTV Birim Fiyat(TL/Kw)</span></th>
                    <th class="bg-secondary"><span class="text-light">KDV Hariç ÖTV (TL)</span></th>
                    <th class="bg-secondary"><span class="text-light">%18 KDV (TL)</span></th>
                    <th class="bg-secondary"><span class="text-light">KDV Dahil Fat.(TL)</span></th>
                    <th class="bg-secondary"><span class="text-light">Toplam Fat. Bedeli</span></th>
                    <th class="bg-primary"><span class="text-light">Gecikmeler</span></th>
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
                    <td class="text-right">{{$params[\App\Models\Fatura::COLUMN_BIRIM_FIYAT_TUKETIM]}}</td>
                    <td class="text-right">{{$fatura[14]}}</td>
                    <td class="text-right">{{$fatura[15]}}</td>
                    <td class="text-right">{{$fatura[16]}}</td>
                    <td class="text-right">{{$fatura[17]}}</td>
                    <td class="text-right">{{$fatura[18]}}</td>
                    <td class="text-right">{{$fatura[19]}}</td>
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
        #dogalgazDatatable th {
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
