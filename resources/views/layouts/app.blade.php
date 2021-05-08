<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Sortable.js -->
    <script src="/js/Sortable.min.js" defer></script>

    <!-- Jquery toast -->
    <script src="/js/jquery.toast.min.js" defer></script>
    <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @else
                    <a class="navbar-brand" href="{{ auth()->user()->hasrole(\App\Models\User::ROLE_SUPER_ADMIN) ? route('admin.dashboard') : url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @endguest

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @else
                        @role(\App\Models\User::ROLE_SUPER_ADMIN)
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->routeIs('admin.dashboard')) ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">{{ __('lang.navigation_dashboard_title') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#">Commandes</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#">Clients</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->routeIs('admin.poform.index')) ? 'active' : '' }}" href="{{ route('admin.poform.index') }}">Mise à jour du formulaire</a>
                                </li>
                            </ul>
                        @else
                            <!-- Member menu -->
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->routeIs('dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}">{{ __('lang.navigation_dashboard_title') }}</a>
                                </li>
                                @can(\App\Models\User::PERMISSION_FILL_PURCHASE_ORDER)
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->routeIs('purchase_orders.*')) ? 'active' : '' }}" href="{{ route('purchase_orders.index') }}">{{ __('lang.navigation_purchase_order_title') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        @endrole
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('lang.login_button') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('lang.register_button') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('lang.navigation_logout_button') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('js_custom')
</body>
</html>
