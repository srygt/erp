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

                <li class="{{ Request::segment(2) === 'faturalar' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="fa fa-folder-open-o"></i><span>Fatura İşlemleri</span></a>
                    <ul>
                        <li
                            class="{{ Request::segment(2) === 'faturalar' && Request::segment(3) == '' ? 'active' : null }}"
                        >
                            <a href="{{route('fatura.liste')}}">Fatura Listesi</a>
                        </li>
                        <li
                            class="{{ Request::segment(2) === 'faturalar' && Request::segment(3) === 'ekle' ? 'active' : null }}"
                        >
                            <a href="{{route('faturataslak.ekle.get')}}">Fatura Olustur</a>
                        </li>

                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'aboneler' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="fa fa-handshake-o"></i><span>Abone İşlemleri</span></a>
                    <ul>
                        <li
                            class="{{ Request::segment(2) === 'aboneler' && Request::segment(3) == '' ? 'active' : null }}"
                        >
                            <a href="{{route('aboneler.liste')}}">Aboneler</a>
                        </li>
                        <li
                            class="{{ Request::segment(2) === 'aboneler' && Request::segment(3) === 'ekle' ? 'active' : null }}"
                        >
                            <a href="{{route('abone.ekle.get')}}">Abone Ekle</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'mukellefler' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="fa fa-building-o"></i><span>Mükellef İşlemleri</span></a>
                    <ul>
                        <li
                            class="{{ Request::segment(2) === 'mukellefler' && Request::segment(3) == '' ? 'active' : null }}"
                        >
                            <a href="{{route('mukellef.liste')}}">Mükellef Listesi</a>
                        </li>
                        <li
                            class="{{ Request::segment(2) === 'mukellefler' && Request::segment(3) === 'ekle' ? 'active' : null }}"
                        >
                            <a href="{{route('mukellef.ekle.get')}}">Mükellef Oluştur</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'ayarlar' ? 'active' : null }}">
                    <a href="{{route('ayar.get')}}">
                        <i class="fa fa-cogs"></i>
                        <span>Ayarlar</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
