<nav class="col-md-2 sidebar">
    <div class="user-box text-center pt-5 pb-3">
        <div class="user-img">
            <img src="{{ auth()->user()->present()->avatar }}" width="90" height="90" alt="user-img"
                class="rounded-circle img-thumbnail img-responsive">
        </div>
        <h5 class="my-3">
            <a href="{{ route('profile') }}">{{ auth()->user()->present()->nameOrEmail }}</a>
        </h5>

        <ul class="list-inline mb-2">
            <li class="list-inline-item">
                <a href="{{ route('profile') }}" title="@lang('My Profile')">
                    <i class="fas fa-cog"></i>
                </a>
            </li>

            <li class="list-inline-item">
                <a href="{{ route('auth.logout') }}" class="text-custom" title="@lang('Logout')">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/home') }}">
                    <i class="fas fa-calendar"></i>
                    <span>Menu Bar</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#leave" data-toggle="collapse"
                   aria-expanded="false">
                    <i class="fas fa-list-ul"></i>
                    <span>Leave</span>
                </a>
                <ul class="list-unstyled sub-menu collapse" id="leave">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leave.create') }}">
                            <span>Apply</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leave.index') }}">
                            <span>My applications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('leave.applied.to.me') }}">
                            <span>Applied to me</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('all.leave.application') }}">
                            <span>All applications</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#attendance" data-toggle="collapse"
                   aria-expanded="false">
                    <i class="fas fa-list-ul"></i>
                    <span>Attendance</span>
                </a>
                <ul class="list-unstyled sub-menu collapse" id="attendance">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('upload.csv') }}">
                            <span>Upload attendance file</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('attendance.index') }}">
                            <span>View attendance</span>
                        </a>
                    </li>
                </ul>
            </li>



            @foreach (\Vanguard\Plugins\Vanguard::availablePlugins() as $plugin)
                @include('partials.sidebar.items', ['item' => $plugin->sidebar()])
            @endforeach
            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/members')}}"> --}}
            {{--                    <i class="fas fa-user"></i> --}}
            {{--                    <span>Members List</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/members/renewal')}}"> --}}
            {{--                    <i class="fas fa-user"></i> --}}
            {{--                    <span>Member Renewal List</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/gate_pass/new')}}"> --}}
            {{--                    <i class="fas fa-calendar"></i> --}}
            {{--                    <span>New Gate Pass</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}

            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/id_card/new')}}"> --}}
            {{--                    <i class="fas fa-calendar"></i> --}}
            {{--                    <span>New ID Card</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/id_card')}}"> --}}
            {{--                    <i class="fas fa-calendar"></i> --}}
            {{--                    <span>ID Card List</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/money_collection/new')}}"> --}}
            {{--                    <i class="fas fa-calendar"></i> --}}
            {{--                    <span>New Money Receipt</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            {{--            <li class="nav-item"> --}}
            {{--                <a class="nav-link" href="{{url('admin/money_collection')}}"> --}}
            {{--                    <i class="fas fa-calendar"></i> --}}
            {{--                    <span>Money Receipt list</span> --}}
            {{--                </a> --}}
            {{--            </li> --}}

            {{--            <li class="nav-item">
                <a class="nav-link collapsed" href="#gatepass-list" data-toggle="collapse"
                   aria-expanded="false">
                    <i class="fas fa-list-ul"></i>
                    <span>Gate Pass List</span>
                </a>
                <ul class="list-unstyled sub-menu collapse" id="gatepass-list">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/gate_pass?year=2018')}}">
                            <span>2018</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/gate_pass?year=2019')}}">
                            <span>2019</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/gate_pass?year=2020')}}">
                            <span>2020</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/gate_pass?year=2021')}}">
                            <span>2021</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/gate_pass')}}">
                            <span>2022</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</nav>
