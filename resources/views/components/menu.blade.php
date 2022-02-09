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
            </ul>
             {{-- master akuntansi --}}
             <div class="pcoded-navigation-label">Master Akuntansi</div>
             <ul class="pcoded-item pcoded-left-item">
                 <li class="{{ Request::segment(1) == 'kode-induk' ? 'active' : '' }}">
                     <a href="{{ url('kode-induk') }}" class="waves-effect waves-dark">
                         <span class="pcoded-micon">
                             <i class="feather icon-bookmark"></i>
                         </span>
                         <span class="pcoded-mtext">Kode Induk</span>
                     </a>
                 </li>
                 {{-- <li class="{{ Request::segment(1) == 'kode-akun' ? 'active' : '' }}">
                     <a href="{{ url('kode-akun') }}" class="waves-effect waves-dark">
                         <span class="pcoded-micon">
                             <i class="feather icon-user"></i>
                         </span>
                         <span class="pcoded-mtext">User</span>
                     </a>
                 </li> --}}
             </ul>

        </div>
    </div>
</nav>
