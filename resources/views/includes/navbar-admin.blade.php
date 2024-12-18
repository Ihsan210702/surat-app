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
       <!-- Notifications Dropdown -->
       @if(auth()->check())
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle position-relative d-flex align-items-center" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fs-4 text-primary"></i>&nbsp;
                @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                @if($unreadCount > 0)
                    <span class="position-absolute badge rounded-pill bg-danger" style="top: -8px; right: 4px; font-size: 0.65rem; width: 15px; height: 15px; padding: 0; line-height: 18px; text-align: center;">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 scrollable-menu" aria-labelledby="notificationDropdown" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                <div class="dropdown-header bg-primary px-3 py-2 border-bottom">
                    <h6 class="mb-0 text-white">Notifikasi</h6>
                </div>
                <div class="notifications-scroll">
                    @if($unreadCount > 0)
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <div class="dropdown-item notification-item px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center mb-1">
                                    <div class="notification-content flex-grow-1">
                                        <a href="{{ url(auth()->user()->role . '/notifications/read/' . $notification->id) }}" class="text-decoration-none text-dark">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold">{{ data_get($notification->data, 'tipe_surat', 'Tidak Diketahui') }}</span>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse(data_get($notification->data, 'tanggal_surat'))->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div class="fw-semibold">
                                                {{ data_get($notification->data, 'jenis_surat', 'Tidak Diketahui') }} - 
                                                <span class="text-muted small">
                                                    {{ Str::limit(data_get($notification->data, 'perihal', 'Tidak ada perihal'), 100) }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="dropdown-footer bg-light p-2 text-center">
                            <form method="POST" action="{{ url(auth()->user()->role . '/mark-all-read') }}">
                                @csrf
                                <button class="btn btn-sm btn-primary w-100" type="submit">
                                    <i class="bi bi-check2-all me-1"></i> Tandai Semua Telah Dibaca
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="dropdown-item px-3 py-2 text-center text-muted">
                            Tidak ada notifikasi baru
                        </div>
                    @endif
                </div>
            </div>
        </li>
        @endif

        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user ms-4 me-lg-4">
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
                    <a href="{{ url('kepsek/setting') }}">
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
