<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('member/') }}">
            <img src="{{ url('front/assets/img/logo.png') }}" alt="{{ setting('app_name') }}" class="navbar-brand-img h-200">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member' ? 'active' : '' }}" href="{{ url('member/') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fab fa-dashcube"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @if(auth()->guard('front')->user()->check_privilege('gate_pass'))
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member/gate_pass/new' ? 'active' : '' }}" href="{{ url('member/gate_pass/new') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fab fa-app-store"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gate Pass Form</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member/gate_pass' ? 'active' : '' }}" href="{{ url('member/gate_pass') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fab fa-app-store"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gate Pass List</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member/' ? 'active' : '' }}" href="{{ url('member/') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fab fa-affiliatetheme"></i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member/' ? 'active' : '' }}" href="{{ url('member/') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="far fa-id-badge"></i>
                    </div>
                    <span class="nav-link-text ms-1">ID Card</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member/' ? 'active' : '' }}" href="{{ url('member/') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <span class="nav-link-text ms-1">Message</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->path() === 'member/' ? 'active' : '' }}" href="{{ url('member/') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="far fa-user-circle"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('logout') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="far fa-user-circle"></i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

