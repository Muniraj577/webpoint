<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block mr-5">
            <a class="nav-link">@yield('title')</a>
        </li>
        <li class="nav-item">
            <span class="nav-link" id="display_time"></span>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                <img
                    class="img-circle elevation-2 img-size-32 mr-1 ml-3"
                    src="{{asset('assets/images/default.png')}}"
                    alt="{{env('APP_NAME', 'Web Point Solution')}}">
                {{env('APP_NAME', 'Web Point Solution')}}
                <span class="caret"></span>
            </a>

{{--            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="far fa-user-circle nav-icon"></i> User Profile--}}
{{--                </a>--}}
{{--                <a class="dropdown-item" href="#" onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                    <i class="fas fa-sign-out-alt"></i>--}}
{{--                    {{ __('Logout') }}--}}
{{--                </a>--}}

{{--                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                    @csrf--}}
{{--                </form>--}}
{{--            </div>--}}
        </li>
    </ul>
</nav>
