<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="logo" class="navbar-brand" height="20"/>
            </a>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li><a href="{{ route('dashboard') }}"><span class="sub-item">Dashboard 1</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#app">
                        <i class="fas fa-layer-group"></i>
                        <p>Application</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="app">
                        <ul class="nav nav-collapse">
                            <li><a href="{{ route('admin.applications.index') }}"><span class="sub-item">Application List</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#payments">
                        <i class="fas fa-th-list"></i>
                        <p>Payments</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="payments">
                        <ul class="nav nav-collapse">
                            <li><a href="#"><span class="sub-item">Payments</span></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
