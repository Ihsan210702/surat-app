<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu</div>

            @if (Auth::user()->role == 'admin')
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('admin-dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <!-- <a class="nav-link {{ request()->is('admin/department') ? 'active' : '' }}"
                    href="{{ url('admin/department') }}">
                    <div class="nav-link-icon"><i data-feather="home"></i></div>
                    Data Departemen
                </a> -->
                <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ url('admin/user') }}">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Data User
                </a>
                <a class="nav-link {{ request()->is('admin/disposisi*') ? 'active' : '' }}" href="{{ url('admin/disposisi') }}">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Data Disposisi
                </a>
                <a class="nav-link {{ request()->is('admin/surat-masuk') ? 'active' : '' }}"
                    href="{{ url('admin/surat-masuk') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-right"></i></div>
                    Surat Masuk
                </a>
                <a class="nav-link {{ request()->is('admin/surat-keluar') ? 'active' : '' }}"
                    href="{{ url('admin/surat-keluar') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-left"></i></div>
                    Surat Keluar
                </a>

                <a class="nav-link {{ request()->is('admin/arsip') ? 'active' : '' }}"
                    href="{{ url('admin/arsip') }}">
                    <div class="nav-link-icon"><i data-feather="folder"></i></div>
                    Arsip
                </a>

                {{-- <a class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}"
                    href="{{ url('admin/setting') }}">
                    <div class="nav-link-icon"><i data-feather="settings"></i></div>
                    Profile
                </a> --}}
            @endif
            <!-- Sidenav Link (Dashboard)-->

            @if (Auth::user()->role == 'staff')
                
                <a class="nav-link {{ request()->is('staff/dashboard') ? 'active' : '' }}"
                    href="{{ route('staff-dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <a class="nav-link {{ request()->is('staff/surat-masuk') ? 'active' : '' }}"
                    href="{{ url('staff/surat-masuk') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-right"></i></div>
                    Surat Masuk
                </a>
                <a class="nav-link {{ request()->is('staff/surat-keluar') ? 'active' : '' }}"
                    href="{{ url('staff/surat-keluar') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-left"></i></div>
                    Surat Keluar
                </a>

            @endif

            @if (Auth::user()->role == 'kepsek')
                
                <a class="nav-link {{ request()->is('kepsek/dashboard') ? 'active' : '' }}"
                    href="{{ url('kepsek/dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>

                <a class="nav-link {{ request()->is('kepsek/user*') ? 'active' : '' }}"
                    href="{{ url('kepsek/user/') }}">
                    <div class="nav-link-icon"><i data-feather="user"></i></div>
                    Data User
                </a>
                <a class="nav-link {{ request()->is('kepsek/surat-masuk') ? 'active' : '' }}"
                    href="{{ url('kepsek/surat-masuk') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-right"></i></div>
                    Surat Masuk
                </a>
                <a class="nav-link {{ request()->is('kepsek/surat-keluar') ? 'active' : '' }}"
                    href="{{ url('kepsek/surat-keluar') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-left"></i></div>
                    Surat Keluar
                </a>
            @endif

            @if (Auth::user()->role == 'guru')
                
                <a class="nav-link {{ request()->is('guru/dashboard') ? 'active' : '' }}"
                    href="{{ url('guru/dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>
                <a class="nav-link {{ request()->is('guru/surat-masuk') ? 'active' : '' }}"
                    href="{{ url('guru/surat-masuk') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-right"></i></div>
                    Surat Masuk
                </a>
                <a class="nav-link {{ request()->is('guru/surat-keluar') ? 'active' : '' }}"
                    href="{{ url('guru/surat-keluar') }}">
                    <div class="nav-link-icon"><i data-feather="arrow-left"></i></div>
                    Surat Keluar
                </a>
            @endif

        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
        </div>
    </div>
</nav>
