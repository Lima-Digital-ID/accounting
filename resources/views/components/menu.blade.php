<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            {{-- master --}}
            <div class="pcoded-navigation-label">Master</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="{{ Request::segment(1) == 'user' ? 'active' : '' }}">
                    <a href="{{ url('user') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-user"></i>
                        </span>
                        <span class="pcoded-mtext">User</span>
                    </a>
                </li>
                {{-- master akuntansi --}}
                <li class="pcoded-hasmenu {{ Request::segment(1) == 'master-akuntasi' ? 'active' : '' }} {{ Request::segment(1) == 'master-akuntasi' ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-bookmark"></i></span>
                        <span class="pcoded-mtext">Master Akuntasi</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ Request::segment(2) == 'kode-induk' ? 'active' : '' }}">
                            <a href="{{ url('master-akuntasi/kode-induk') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Kode Induk</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) == 'kode-akun' ? 'active' : '' }}">
                            <a href="{{ url('master-akuntasi/kode-akun') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Kode Akun</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) == 'kunci-transaksi' ? 'active' : '' }}">
                           <a href="{{ url('master-akuntasi/kunci-transaksi') }}" class="waves-effect waves-dark">
                               <span class="pcoded-micon">
                                   <i class="feather icon-bookmark"></i>
                               </span>
                               <span class="pcoded-mtext">Kunci Transaksi</span>
                           </a>
                       </li>
                    </ul>
                </li>
            </ul>
            {{-- <div class="pcoded-navigation-label">Master Akuntansi</div> --}}
            {{-- Kas --}}
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ Request::segment(1) == 'kas' ? 'active' : '' }} {{ Request::segment(1) == 'kas' ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-wallet"></i></span>
                        <span class="pcoded-mtext">Kas</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ Request::segment(2) == 'kas-transaksi' ? 'active' : '' }}">
                            <a href="{{ url('kas/kas-transaksi') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Transaksi Kas</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) == 'laporan-kas' ? 'active' : '' }}">
                            <a href="{{ url('kas/laporan-kas') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Laporan Kas</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            {{-- Bank --}}
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ Request::segment(1) == 'bank' ? 'active' : '' }} {{ Request::segment(1) == 'bank' ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-credit-card"></i></span>
                        <span class="pcoded-mtext">Bank</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ Request::segment(2) == 'bank-transaksi' ? 'active' : '' }}">
                            <a href="{{ url('bank/bank-transaksi') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Transaksi Bank</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) == '' ? 'active' : '' }}">
                            <a href="{{ url('master-akuntasi/kode-induk') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Laporan Bank</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            {{-- Memorial Jurnal Umum --}}
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ Request::segment(1) == 'memorial' ? 'active' : '' }} {{ Request::segment(1) == 'memorial' ? 'pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-folder"></i></span>
                        <span class="pcoded-mtext">Memorial</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ Request::segment(2) == 'memorial' ? 'active' : '' }}">
                            <a href="{{ url('memorial/memorial') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Transaksi Memorial (Jurnal Umum)</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) == '' ? 'active' : '' }}">
                            <a href="{{ url('master-akuntasi/kode-induk') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon">
                                    <i class="feather icon-bookmark"></i>
                                </span>
                                <span class="pcoded-mtext">Laporan Bank</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
