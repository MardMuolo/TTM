<x-laravel-ui-adminlte::adminlte-layout>

    <body class="hold-transition login-page">
        <div class="box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                    src="@if (Auth::user()->profile_photo == null) {{ Vite::asset('resources/images/logo.svg') }}
                @else
                {{ asset('storage/profiles/' . Auth::user()->profile_photo) }} @endif"
                    alt="User profile picture">

            </div>

            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
        </div>
        <div class="login-box">
            <!-- /.login-logo -->

            <!-- /.login-box-body -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Completez vos données</p>

                    <form autocomplete="off" method="post" action="{{ route('update-user-info') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <label for="line_manager">Line Manager</label>
                            <select name="line_manager" class="form-control select2 w-100" id="user"
                                style="width: 100%;">
                                <option disabled selected>Veuillez choisir...</option>
                                <input type="hidden" id="username" name="username">
                                <input type="hidden" id="Email" name="Email">
                                <input type="hidden" id="name" name="user_name">
                                <input type="hidden" id="phone_number" name="phone_number">
                            </select>
                        </div>
                        @error('line')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="input-group mb-3">
                            <label for="direction">Direction</label>
                            <select name="direction" class="form-control w-100 select " required>
                                <option disabled selected>Veuillez choisir...</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="inputEmail"></label>
                                <input type="hidden" class="form-control" id="inputEmail" placeholder="email"
                                    name="email">

                            </div>
                        </div>

                        <div class="row">

                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>

        </div>
        <!-- /.login-box <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js?commonjs-entry"></script> -->

        @push('page_scripts')
            <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}">
            </script>

            <script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
            <script type="module"
                src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js?commonjs-entry') }}"></script>
            @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
            <script type="module">
                $(document).ready(function() {
                    // $('[data-mask]').inputmask()
                    $.ajax({
                        url: '{{ route('getUsers') }}',
                        type: 'Get',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response)

                            if (response.status === 'success') {
                                var data = response.body;
                                console.log(data)

                                var formattedData = data.map(function(user) {
                                    return {
                                        id: user.id,
                                        username: user.username,
                                        text: user.name,
                                        email: user.email,
                                        phone: user.phone,

                                    };
                                });

                                // Initialiser le champ de sélection avec les options
                                $('#user').select2({
                                    data: formattedData,
                                    minimumInputLength: 1
                                });
                                $('#directeur_edit').select2({
                                    data: formattedData,
                                    minimumInputLength: 1
                                });



                                // Événement de sélection d'utilisateur
                                $('#user').on('select2:select', function(e) {
                                    var selectedUser = e.params.data;
                                    console.log(`name ${selectedUser.text}`)

                                    // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                                    // $('#user').val(selectedUser.username);
                                    $('#username').val(selectedUser.username);
                                    $('#Email').val(selectedUser.email);
                                    $('#name').val(selectedUser.text);
                                    $('#phone_number').val(selectedUser.phone);

                                    // var fullName = selectedUser.first_name + ' ' + selectedUser
                                    //     .last_name;
                                    // $('#name').val(fullName);
                                });
                                $('#directeur_edit').on('select2:select', function(e) {
                                    var selectedUser = e.params.data;
                                    console.log(`name ${selectedUser.text}`)

                                    // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                                    // $('#user').val(selectedUser.username);
                                    $('#username_edit').val(selectedUser.username);
                                    $('#Email_edit').val(selectedUser.email);
                                    $('#name_edit').val(selectedUser.text);
                                    $('#phone_number_edit').val(selectedUser.phone);

                                    // var fullName = selectedUser.first_name + ' ' + selectedUser
                                    //     .last_name;
                                    // $('#name').val(fullName);
                                });

                            } else {
                                console.log('Erreur: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Erreur AJAX: ' + error);
                        }
                    });



                });
            </script>
        @endpush
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
