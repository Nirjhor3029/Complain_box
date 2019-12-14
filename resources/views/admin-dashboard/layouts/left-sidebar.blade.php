<div class="admin-dashboard-left-sidebar mb-5">
    <div class="admin-information-in-sidebar text-center mb-3">
        <div class="mb-3">
			<a href="{{ route('admin.admin-dashboard') }}">
			@if (auth()->user()->profile_picture != null || !empty(auth()->user()->profile_picture))
				<img src="{{ asset(auth()->user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" height="80" style="border: 1px solid #ffffff;">
			@else
				<img src="{{ asset('img/profile-picture-placeholder.svg') }}" alt="Profile Picture" class="rounded-circle" height="80" style="border: 1px solid #ffffff;">
			@endif
			</a>
        </div>
        <!-- /.mb-3 -->

        <div class="admin-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
        <p class="admin-designation mb-0">{{ auth()->user()->designation }}</p>
        <!-- /.mb-0 -->
    </div>
    <!-- /.admin-information-in-sidebar -->

    <div class="left-side-navbar">
        <ul class="left-side-navbar-ul">
            <li class="left-side-navbar-li">
                <a href="{{ route('admin.admin-dashboard') }}" @if (request()->is('secure/admin'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/home-icon.svg') }}" alt=""> Home</a>
            </li>
            <!-- /.left-side-navbar-li -->

            {{-- <li class="left-side-navbar-li">
                <a href="{{ route('admin.admin-previousMontIdeas') }}" @if (request()->is('secure/'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/history-icon.svg') }}" alt=""> Previous Month Ideas</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('admin.admin-featuredIdeas') }}" @if (request()->is('secure/'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/featured-icon.svg') }}" alt=""> Featured Ideas</a>
            </li>
            <!-- /.left-side-navbar-li --> --}}

            <li class="left-side-navbar-li">
                <a href="{{ route('admin.admin-allIdeas') }}" @if (request()->is('secure/admin/all-complain'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> All Complains</a>
            </li>
            <!-- /.left-side-navbar-li -->
            <li class="left-side-navbar-li">
                <a href="{{ route('admin.admin-allStatus') }}" @if (request()->is('secure/admin/all-status'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt="">Complain Status</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('dashboard.user.index') }}" @if (request()->is('secure/dashboard/user'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> Users Manager</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('dashboard.role.index') }}" @if (request()->is('secure/dashboard/role'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> User Roles</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('dashboard.permission.index') }}" @if (request()->is('secure/dashboard/permission'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> User Permissions</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('dashboard.index') }}" target="_blank"><img src="{{ asset('img/admin/home-icon.svg') }}" alt=""> Ideas Homepage</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="mb-3 mt-4"></li>

            <li class="left-side-navbar-li">
                <a href="{{ route('account.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="background-color: #1D0045;"><img src="{{ asset('img/admin/logout-icon.svg') }}" alt=""> Logout</a>

                <form id="logout-form" action="{{ route('account.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            <!-- /.left-side-navbar-li -->
        </ul>
        <!-- /.left-side-navbar-ul -->
    </div>
    <!-- /.left-side-navbar -->
</div>
<!-- /.admin-dashboard-left-sidebar -->
