@section('redirectBody')
    <div class="col-sm-12">
        <div class="alert alert-info" role="alert">
            <i class="fa fa-info-circle"></i>
            Lütfen bekleyin, yönlendiriliyorsunuz...
        </div>
    </div>
    <form
        id="faturaTaslakForm"
        action="{{ route("faturataslak.ekle.post") }}"
        method="post"
    >
        @csrf

        @foreach ($params as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
@endsection

@section('page-script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#faturaTaslakForm').submit();
        });
    </script>
@stop

@include('import.fatura.abstractRedirectToPay')
