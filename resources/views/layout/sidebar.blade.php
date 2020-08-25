<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="{{route('home')}}"><img src="{{asset('assets/images/osb.png')}}" alt="Oculux Logo" class="img-fluid logo"><span>Diyarbakır OSB</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right">
            <i class="lnr lnr-menu fa fa-chevron-circle-left text-blush"></i>
        </button>
    </div>
    <div class="sidebar-scroll">
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="{{ Request::segment(2) === 'anasayfa' ? 'active' : null }}">
                    <a href="{{route('home')}}">
                        <i class="fa fa-home"></i>
                        <span>Ana Sayfa</span>
                    </a>
                </li>
                <li class="{{ Request::segment(2) === 'faturalar' ? 'active open' : null }}">
                    <a href="#myPage" class="has-arrow"><i class="fa fa-folder-open-o"></i><span>Fatura İşlemleri</span></a>
                    <ul>
                        <li
                            class="{{ Request::segment(2) === 'faturalar' && Request::segment(3) == 'gelen' ? 'active' : null }}"
                        >
                            <a href="{{route('fatura.gelen.liste')}}">Gelen Fatura Listesi</a>
                        </li>
                        <li
                            class="{{ Request::segment(2) === 'faturalar' && Request::segment(3) == '' ? 'active' : null }}"
                        >
                            <a href="{{route('fatura.liste')}}">Giden Fatura Listesi</a>
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
                    <a href="#myPage" class="has-arrow"><i class="fa fa-cogs"></i><span>Ayar İşlemleri</span></a>
                    <ul>
                        <li
                            class="{{ Request::segment(2) === 'ayarlar' && Request::segment(3) == 'genel' ? 'active' : null }}"
                        >
                            <a href="{{route('ayar.genel.index')}}">Genel</a>
                        </li>
                        <li
                            class="{{ Request::segment(2) === 'ayarlar' && Request::segment(3) == 'ek-kalemler' && Request::segment(4) != 'ekle' ? 'active' : null }}"
                        >
                            <a href="{{route('ayar.ek-kalem.index')}}">Ek Kalem Listesi</a>
                        </li>
                        <li
                            class="{{ Request::segment(2) === 'ayarlar' && Request::segment(3) == 'ek-kalemler' && Request::segment(4) == 'ekle' ? 'active' : null }}"
                        >
                            <a href="{{route('ayar.ek-kalem.store.get')}}">Ek Kalem Oluştur</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
