@extends('layout.authentication')
@section('title', 'Login')


@section('content')
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
    </div>
</div>

<div class="auth-main2 particles_js">
    <div class="auth_div vivify fadeInTop">
        <div class="card">
            <div class="body">
                <div class="login-img">
                    <img class="img-fluid" src="../assets/images/login-img.png" />
                </div>
                <form class="form-auth-small" method="post" action="{{route('Login.post')}}">
                    @csrf
                    <div class="mb-3">
                        <p class="lead">Oturum Açın</p>
                    </div>
                    <div class="form-group">
                        <label  class="control-label sr-only">Kullanıcı Adı</label>
                        <input type="text" name='username' class="form-control round" id="signin-email"  placeholder="Kullanıcı Adı">
                    </div>
                    <div class="form-group">
                        <label for="signin-password" class="control-label sr-only">Password</label>
                        <input type="password" name="password"  class="form-control round" id="signin-password"  placeholder="Şifre">
                    </div>
                    <div class="form-group clearfix">
                        <label class="fancy-checkbox element-left">
                            <input type="checkbox">
                            <span>Beni Hatırla</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-round btn-block">GİRİŞ</button>
                </form>
                @if($errors->any())
                    <div class="col-lg-6 col-md-12">
                        <div class="alert alert-danger">
                            {{$errors->first()}}
                        </div>
                    </div>
                    @endif

                <div class="pattern">
                    <span class="red"></span>
                    <span class="indigo"></span>
                    <span class="blue"></span>
                    <span class="green"></span>
                    <span class="orange"></span>
                </div>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>
<!-- END WRAPPER -->
@stop

@section('page-styles')

@stop

@section('page-script')
@stop
