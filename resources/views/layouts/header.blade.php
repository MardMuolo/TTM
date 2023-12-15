<nav class="main-header navbar navbar-expand bg-black navbar-light mb-2">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link border" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars text-orange"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle text-orange" data-toggle="dropdown">
                <img src="@if (Auth::user()?->profile_photo == null) {{ asset('/icone.jpg') }}
                @else
                {{ asset('storage/profiles/' . Auth::user()?->profile_photo) }} @endif"
                    class="user-image img-circle elevation-2" alt="User Image">
                <span class="col-7 d-none d-md-inline">{{ Auth::user()?->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-orange">
                    <img src="@if (Auth::user()?->profile_photo == null) {{ asset('/icone.jpg') }}
                @else
                {{ asset('storage/profiles/' . Auth::user()?->profile_photo) }} @endif"
                        class="user-image img-circle elevation-2" alt="User Image">
                    @if (Auth::user())
                        <p class="py-3">
                            {{ Auth::user()?->name }}
                            <small>Acces depuis {{ Auth::user()->created_at?->format('M. Y') }}</small>
                        </p>
                    @endif
                </li>
                <!-- Menu Footer-->
                <li class="user-footer bg-black">
                    @php
                        $id = Crypt::encrypt(Auth::user()->id);
                    @endphp
                    <a href="{{ route('profile', $id) }}" class="btn btn-default bg-yellow">Profile</a>
                    <a href="#" class="btn btn-default btn-flat float-right bg-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Se deconnecter
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
