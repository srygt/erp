<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', config('app.name'))">
    <meta name="author" content="@yield('meta_author', config('app.name'))">
    @yield('meta')

    @stack('before-styles')

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">

    @stack('after-styles')
    @if (trim($__env->yieldContent('page-styles')))
        @yield('page-styles')
    @endif
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
</head>

<body class="theme-blush font-montserrat light_version">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
    </div>
</div>

@include('layout.themesetting')

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<div id="wrapper">

    @include('layout.navbar')

    @include('layout.sidebar')

    <div id="main-content">
        <div class="container-fluid">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <h1>@yield('title')</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                                @if (trim($__env->yieldContent('parentPageTitle')))
                                    <li class="breadcrumb-item">@yield('parentPageTitle')</li>
                                @endif
                                @if (trim($__env->yieldContent('title2')))
                                    <li class="breadcrumb-item">@yield('title2')</li>
                                @endif
                                @if (trim($__env->yieldContent('title')))
                                    <li class="breadcrumb-item active">@yield('title')</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @yield('content')

        </div>

    </div>
</div>

<!-- Scripts -->
@stack('before-scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

@stack('after-scripts')

<script type="text/javascript"><!--

function deleteItem(parentElement, deleteUrl) {
    swal({
        title: "Silmek istediğinize emin misiniz?",
        text: "Silinen verileri geri getiremezsiniz!",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: 'İptal',
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Evet, sil!",
        closeOnConfirm: false
    }, () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "DELETE",
            url: deleteUrl,
        })
            .done(() => {
                parentElement.remove();
                swal("Silindi!", "Silme işlemi başarı ile tamamlandı.", "success");
            })
            .fail(( jqXHR, textStatus ) => {
                alert( "Request failed: " + textStatus );
            });
    });
}

$(document).ready(function(){
   var alertMessageExists = !!$('#alertMessages').length;

   if (alertMessageExists) {
       $('#alertMessages').scrollIntoView();
   }
});

--></script>

@if (trim($__env->yieldContent('page-script')))
    @yield('page-script')
@endif

</body>
</html>
