<br>
<ul class="pcoded-item pcoded-left-item">
    <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
            <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

    <li>
        <a href="#" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-user"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Kelola Data User</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

    <li>
        <a href="#" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Kelola Data Mahasiswa</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

   <li class="{{ Request::routeIs('jurnal.*') ? 'active' : '' }}">
        <a href="{{ route('jurnal.index') }}">
            <span class="pcoded-micon">
                <i class="ti-book"></i>
            </span>
            <span class="pcoded-mtext">Data Jurnal</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

    <li>
        <a href="#" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-panel"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Kelola Data Kategori</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

    <li>
        <a href="#" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-file"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Laporan</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
</ul>
</nav>