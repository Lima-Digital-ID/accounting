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
                @if (auth()->user()->level == 'Admin')
                    <li class="{{ Request::segment(1) == 'kabupaten' ? 'active' : '' }}">
                        <a href="{{ url('kabupaten') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-map-pin"></i>
                            </span>
                            <span class="pcoded-mtext">Kabupaten</span>
                        </a>
                    </li>

                    <li class="{{ Request::segment(1) == 'kecamatan' ? 'active' : '' }}">
                        <a href="{{ url('kecamatan') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-map-pin"></i>
                            </span>
                            <span class="pcoded-mtext">Kecamatan</span>
                        </a>
                    </li>

                    <li class="{{ Request::segment(1) == 'desa' ? 'active' : '' }}">
                        <a href="{{ url('desa') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-map-pin"></i>
                            </span>
                            <span class="pcoded-mtext">Desa</span>
                        </a>
                    </li>

                    <li class="{{ Request::segment(1) == 'user' ? 'active' : '' }}">
                        <a href="{{ url('user') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">User</span>
                        </a>
                    </li>
                @endif
            </ul>
            {{-- end master --}}


            {{-- hls --}}
            <div class="pcoded-navigation-label">HLS</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(2) == 'master-hls' ? 'active' : '' }}">
                    <a href="{{ url('hls/master-hls') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Master HLS</span>
                    </a>
                </li>

                <li class="{{ Request::segment(2) == 'faktor-koreksi-pesantren' ? 'active' : '' }}">
                    <a href="{{ url('hls/faktor-koreksi-pesantren') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Faktor Koreksi Pesantren</span>
                    </a>
                </li>

                <li class="{{ Request::segment(2) == 'hitung-hls' ? 'active' : '' }}">
                    <a href="{{ url('hls/hitung-hls') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-calculator"></i>
                        </span>
                        <span class="pcoded-mtext">Hitung HLS</span>
                    </a>
                </li>

            </ul>
            {{-- end hls --}}

            {{-- rls --}}
            <div class="pcoded-navigation-label">RLS</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(2) == 'master-rls' ? 'active' : '' }}">
                    <a href="{{ url('rls/master-rls') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Master RLS</span>
                    </a>
                </li>

                <li class="{{ Request::segment(2) == 'hitung-rls' ? 'active' : '' }}">
                    <a href="{{ url('rls/hitung-rls') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-calculator"></i>
                        </span>
                        <span class="pcoded-mtext">Hitung RLS</span>
                    </a>
                </li>

            </ul>
            {{-- end rls --}}

            {{-- ip --}}
            <div class="pcoded-navigation-label">Indeks Pendidikan</div>
            <ul class="pcoded-item pcoded-left-item">

                <li class="{{ Request::segment(1) == 'indeks-pendidikan' ? 'active' : '' }}">
                    <a href="{{ url('indeks-pendidikan') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-calculator"></i>
                        </span>
                        <span class="pcoded-mtext">Hitung Indeks Pendidikan</span>
                    </a>
                </li>

            </ul>
            {{-- end ip --}}
            {{-- indeks kesehatan --}}
            <div class="pcoded-navigation-label">Indeks Kesehatan</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(1) == 'indeks-kesehatan' ? 'active' : '' }}">
                    <a href="{{ url('indeks-kesehatan') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-file-medical-alt"></i>
                        </span>
                        <span class="pcoded-mtext">Indeks Kesehatan</span>
                    </a>
                </li>
            </ul>
            {{-- end indeks kesehatan --}}

            {{-- indeks pengeluaran --}}
            <div class="pcoded-navigation-label">Indeks Pengeluaran</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(1) == 'indeks-pengeluaran' ? 'active' : '' }}">
                    <a href="{{ url('indeks-pengeluaran') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-donate"></i>
                        </span>
                        <span class="pcoded-mtext">Indeks Pengeluaran</span>
                    </a>
                </li>
            </ul>
            {{-- end indeks pengeluaran --}}

            {{-- indeks pembangunan-manusia --}}
            <div class="pcoded-navigation-label">Indeks Pembangunan Manusia</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(1) == 'indeks-pembangunan-manusia' ? 'active' : '' }}">
                    <a href="{{ url('indeks-pembangunan-manusia') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-chart-line"></i>
                        </span>
                        <span class="pcoded-mtext">Indeks Pembangunan <br> Manusia</span>
                    </a>
                </li>
            </ul>
            {{-- end indeks pembangunan-manusia --}}
            
        </div>
    </div>
</nav>
