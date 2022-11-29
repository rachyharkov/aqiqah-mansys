<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fa fa-pie-chart"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item {{ \Request::is('order*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ \Request::is('order*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-book"></i>
                <p>
                    Order Management
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 25px;">
                <li class="nav-item {{ \Request::routeIs('order.create') ? 'active' : '' }}">
                    <a href="{{route('order.create')}}" class="nav-link" style="width: 100%">
                        <p>New Order</p>
                    </a>
                </li>
                <li class="nav-item {{ \Request::routeIs('order.index') ? 'active' : '' }}">
                    <a href="{{ route('order.index') }}" class="nav-link" style="width: 100%">
                        <p>Order List</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- @if ()

        @endif --}}
        <li class="nav-item custom-auth-sidebar {{ \Request::is('users*') || \Request::is('branch*') || \Request::is('role*') ? 'menu-open' : '' }}" class="menu">
            <a href="#" class="nav-link {{ \Request::is('users*') || \Request::is('branch*') || \Request::is('role*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-users"></i>
                <p>
                    User Management
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 25px;">
                <li class="nav-item {{\Request::routeIs('users.index') ? 'active' : ''}}">
                    <a href="{{ route('users.index') }}" class="nav-link" style="width: 100%">
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item {{\Request::routeIs('branch.index') ? 'active' : ''}}">
                    <a href="{{ route('branch.index') }}" class="nav-link" style="width: 100%">
                        <p>Branch</p>
                    </a>
                </li>
                <li class="nav-item {{\Request::routeIs('role.index') ? 'active' : ''}}">
                    <a href="{{ route('role.index') }}" class="nav-link" style="width: 100%">
                        <p>Role</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-users-cog"></i>
                <a href="{{route('admin.create')}}" class="nav-link @yield('order')" style="width: 100%">
                    <p>User</p>
                </a>
            </a>
        </li>    --}}
    </ul>
</nav>
