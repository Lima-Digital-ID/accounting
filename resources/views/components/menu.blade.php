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
                                <span class="pcoded-mtext">Kode Rekening</span>
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
             {{-- master akuntansi --}}

             <div class="pcoded-navigation-label">Master Akuntansi</div>
             <ul class="pcoded-item pcoded-left-item">
             </ul>

        </div>
    </div>
</nav>
