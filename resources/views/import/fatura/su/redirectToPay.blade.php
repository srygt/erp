@section('redirectBody')
    <form
        id="faturaTaslakForm"
        action="{{ route("faturataslak.ekle.post") }}"
        method="post"
        style="width: 100%;"
    >
        @csrf

        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="body">
                    <div class="row clearfix">
                        <div id="ekKalemList" class="col-lg-12 col-md-12">
                            <div class="header">
                                <h2>Ek Kalemler <small>Faturaya uygulanmasını istediğiniz ek kalemleri aşağıdan seçin</small></h2>
                            </div>
                            <div class="table-responsive">
                                @include(
                                    'faturalar.ekKalemComponent',
                                    [
                                        'ekKalemler' => $ekKalemler,
                                        'openTable' => \App\Models\Abone::COLUMN_TUR_SU
                                    ]
                                )
                            </div>
                        </div>

                        @foreach ($params as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-lg-right m-t-20">
                            <button type="submit" class="btn btn-lg btn-primary">Fatura Taslağı Önizleme</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
@stop

@include('import.fatura.abstractRedirectToPay')
