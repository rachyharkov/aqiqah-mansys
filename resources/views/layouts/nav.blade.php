<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a
                class="nav-link"
                data-widget="pushmenu"
                href="#"
                role="button"
            ><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a
                class="nav-link"
                data-toggle="dropdown"
                href="#"
            >
                {{ \Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                <!-- <div class="dropdown-divider"></div> -->
                <a
                    href="{{ route('logout') }}"
                    class="nav-link ml-auto"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    {{ __('Logout') }}
                </a>
                <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-none"
                >
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
