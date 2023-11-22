<x-laravel-ui-adminlte::adminlte-layout>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <div class="text-center">
                    <img class="profile-user-img img-fluid" src="{{Vite::asset('resources/images/logo.svg')}}"
                    alt="User profile picture">
                    
                </div>
                <a href="{{ url('/home') }}"><b>Easy TTM</b></a>
            </div>
            <!-- /.login-logo -->

            <!-- /.login-box-body -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Connectez-vous</p>

                    <form method="post" action="{{ url('/login') }}" autocomplete="off">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="Nom d'utilisateur"
                                class="form-control @error('username') is-invalid @enderror" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('username')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" placeholder="Mot de passe"
                                class="form-control @error('password') is-invalid @enderror" autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember" style="font-size:0.78vw;">Se souvenir de moi</label>
                                </div>
                            </div>

                            <div class="col-6 py-4">
                                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>

        </div>
        <!-- /.login-box -->
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
