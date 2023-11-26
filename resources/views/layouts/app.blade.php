<x-laravel-ui-adminlte::adminlte-layout>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Main Header -->
            @include('layouts.header')

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if (!(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'login'))
                    @include('layouts.breadcrumb')
                @endif
                @yield('content')
            </div>

            <!-- Main Footer -->
            @include('layouts.footer')
        </div>
        
            @yield('scripts')
            @vite('resources/css/style.css')
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
