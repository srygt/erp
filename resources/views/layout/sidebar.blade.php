<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="{{route('home')}}"><img src="{{asset('assets/images/osb.png')}}" alt="Oculux Logo" class="img-fluid logo"><span>Diyarbakır OSB</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img src="{{asset('assets/images/user.png')}}" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span>Hoşgeldin,</span>
                <a href="javascript:void(0);" class=" user-name" data-toggle="dropdown"><strong>{{\Illuminate\Support\Facades\Auth::User()->name}} {{\Illuminate\Support\Facades\Auth::User()->lastname}}</strong></a>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">

                <li class="{{ Request::segment(1) === 'mypage' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="icon-home"></i><span>Fatura İşlemleri</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('faturalar.suFaturasi')}}">Su Faturası Olustur</a></li>

                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'mypage' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="icon-home"></i><span>Abone İşlemleri</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('aboneler.abonelistesi')}}">Aboneler</a></li>
                        <li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('aboneler.aboneekle')}}">Abone Ekle</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'mypage' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="icon-home"></i><span>Mükellef İşlemleri</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('mukellef.ekle.get')}}">Mükellef Oluştur</a></li>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
