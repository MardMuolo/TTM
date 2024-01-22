<x-laravel-ui-adminlte::adminlte-layout>

    <body class="hold-transition login-page">
        @push('page_css')
            @vite('resources/css/style.css')
            <link rel="stylesheet" href="{{ asset('fa/css/all.css') }}">
        @endpush
        <div class="login-box">
            <div class="login-logo col">
                <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Logo"
                    class="brand-image w-10 h-10 elevation-4">
                <a href="{{ url('/home') }}"><b>{{ env('APP_NAME') }}</b></a>
            </div>
            <!-- /.login-logo -->

            <!-- /.login-box-body -->
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-body login-card-body white-bg opacity_low">
                    <p class="login-box-msg black fs-4 fw-bold">Nous vous avons envoyé un code secret par
                        {{ $send_type }} de réference {{ $ref }}. Veilllez entrer ce code à 6 chiffres.</p>

                    <form method="post" action="{{ route('loginAfterOtp') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="otp" placeholder="Code secret" class="form-control"
                                required>
                            <div class="input-group-append black-bg">
                                <div class="input-group-text">
                                    <span class="fas fa-lock white"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-dark btn-block fw-bold text-white">Checker</button>
                            </div>

                        </div>
                    </form>
                    <div>
                        <a href="/" class="link">Retour à la page de connexion</a>
                    </div>
                </div>
                <!-- /.login-card-body -->
            </div>

        </div>
        <!-- /.login-box -->
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
