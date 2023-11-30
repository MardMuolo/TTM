<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                    class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span class="col-1  elevation-2 bg-warning py-2" style="width: 300px"></span>
                {{-- <img src="@if(Auth::user()?->profile_photo == null)
                {{Vite::asset('resources/images/logo.svg')}}
                @else
                {{asset('storage/profiles/'.Auth::user()?->profile_photo)}}"
                @endif"
                    class="user-image img-circle elevation-2" alt="User Image"> --}}
                <span class="col-7 d-none d-md-inline">{{ Auth::user()?->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header thead-color">
                    {{-- <img src="@if(Auth::user()?->profile == null)
                    {{Vite::asset('resources/images/logo.svg')}}
                    @else
                    {{asset('storage/profiles/'.Auth::user()?->profile)}}"
                    @endif"
                        class="img-circle elevation-2" alt="User Image"> --}}
                        <span class="img-circle p-4 elevation-2 bg-danger  text-center">{{str(Auth::user()->username[0])->upper()}}{{str(Auth::user()->name[0])->upper()}}</span>
                    @if(Auth::user())
                    <p class="py-3">
                        {{ Auth::user()?->name }}
                        <small>Acces depuis {{ Auth::user()?->created_at?->format('M. Y') }}</small>
                    </p>
                    @endif
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    @php
                        $id=Crypt::encrypt(Auth::user()->id);    
                    @endphp
                    <a href="{{route('profile',$id)}}" class="btn btn-default btn-flat">Profile</a>
                    <a href="#" class="btn btn-default btn-flat float-right"
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