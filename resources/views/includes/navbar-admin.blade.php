<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
    id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle">
        <i data-feather="menu"></i>
    </button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('admin-dashboard') }}">
        E-Arsip Surat
    </a>
    <!-- Navbar Search Input-->
    <!-- * * Note: * * Visible only on and above the lg breakpoint-->
    <form class="form-inline me-auto d-none d-lg-block me-3">
        <div class="input-group input-group-joined input-group-solid">

        </div>
    </form>
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <!-- Navbar Search Dropdown-->
        <!-- * * Note: * * Visible only below the lg breakpoint-->
        @if(auth()->user()->unreadNotifications->count())
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle btn btn-primary text-white" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell"></i><span class="badge badge-light">{{ auth()->user()->unreadNotifications->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                <h6 class="dropdown-header">Notifikasi</h6>
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <a class="dropdown-item" href="">
                        <strong>{{ $notification->data['perihal'] }}</strong><br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($notification->data['tanggal_surat'])->format('d M Y') }}</small>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
                <a class="dropdown-item text-center text-primary" href="#">Tandai semua telah dibaca</a>
            </div>
        </li>
    @else
        <li class="nav-item">
            <div class="alert alert-secondary m-0" role="alert">
                Tidak ada notifikasi baru.
            </div>
        </li>
    @endif


        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                @if (auth()->user()->profile != null)
                    <img class="img-fluid" src="{{ Storage::url(Auth::user()->profile) }}" />
                @else
                    <img class="img-fluid" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" />
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                @if (auth()->user()->profile != null)
                    <img class="dropdown-user-img" src="{{ Storage::url(auth()->user()->profile) }}" />
                @else
                    <img class="dropdown-user-img" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" />
                @endif

                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ auth()->user()->name }}</div>
                        <div class="dropdown-user-details-email">{{ auth()->user()->email }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item"
                @if (auth()->user()->role == 'admin')
                    <a href="{{ url('admin/setting') }}">
                @elseif (auth()->user()->role == 'guru')
                    <a href="{{ url('guru/setting') }}">
                @elseif (auth()->user()->role == 'kepsek')
                    <a href="{{ url('kepala-sekolah/setting') }}">
                @elseif (auth()->user()->role == 'staff')
                    <a href="{{ url('staff/setting') }}">
                @endif
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Account
                </a>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
