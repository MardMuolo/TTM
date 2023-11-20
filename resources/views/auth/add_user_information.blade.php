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
                            <select name="line_manager" class="form-control select2 w-100" id="user">
                                <option value=""></option>
                            </select>
                        </div>
                        @error('line')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="input-group mb-3">
                            <label for="direction">Direction</label>
                            <select name="direction" class="form-control w-100 " required>
                                <option></option>
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
        <!-- /.login-box <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> -->
        
        
        

        <script>

        </script>

        
        @push('page_scripts')
            <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
            
            <script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
            <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
            @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')

            <script type="module">
           
                $(document).ready(function() {
    
                    $.ajax({
                        url: 'http://10.143.41.70:8000/promo2/odcapi/?method=getUsers',
                        dataType: 'json',
                        success: function(response) {
    
                            if (response.success) {
                                var data = response.users;
    
                                var formattedData = data.map(function(user) {
                                    return {
                                        id: user.id,
                                        username: user.username,
                                        text: user.last_name + " " + user.first_name,
                                        email: user.email,
                                        phone: user.phone,
                                        first_name: user.first_name,
                                        last_name: user.last_name,
                                    };
                                });
    
                                // Initialiser le champ de sélection avec les options
                                $('#user').select2({
                                    data: formattedData,
                                    minimumInputLength: 1
                                });
    
                                // Événement de sélection d'utilisateur
                                $('#user').on('select2:select', function(e) {
                                    var selectedUser = e.params.data;
    
                                    // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                                    $('#user').val(selectedUser.email);
                                    // $('#username').val(selectedUser.username);
                                    $('#inputEmail').val(selectedUser.email);
                                    // $('#inputTel').val(selectedUser.phone);
    
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
