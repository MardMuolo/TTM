@extends('layouts.app')
@section('title')
    Profil
@endsection

@section('filsAriane')
    <li class="breadcrumb-item active">Profil utilisateur</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            {{-- <span class="user-image img-circle elevation-2 bg-danger p-4 my-3 text-center">
                                {{ str($user->username[0])->upper() }}{{ str($user->name[0])->upper() }}
                            </span> --}}
                            <img class="profile-user-img img-fluid img-circle" src="@if(Auth::user()->profile_photo == null)
                                {{Vite::asset('resources/images/logo.svg')}}
                                @else
                                {{asset('storage/profiles/'.Auth::user()->profile_photo)}}
                                @endif"
                                class="user-image img-circle elevation-2"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center py-3">{{ $user->name }}</h3>


                        {{-- <p class="text-muted text-center">Software Engineer</p> --}}

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Projets</b> <a class="float-right">{{ count($userProjects) }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Livrables</b> <a class="float-right">543</a>
                            </li>
                            {{-- <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                                </li> --}}
                        </ul>
                        {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                    </div>

                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title">A propos de moi</h4>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-user mr-1"></i> Nom et Prenom</strong>
                        <p class="text-muted">
                            {{ $user->name }}
                        </p>
                        <hr>
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">{{ $user->email }}</p>
                        <hr>
                        <strong><i class="fas fa-pencil-alt mr-1"></i> Nom d'utilisateur</strong>
                        <p class="text-muted">{{ $user->username }}</p>
                        <hr>
                        <strong><i class="far fa-user mr-1"></i> Line Manager</strong>
                        <p class="text-muted">{{ $line_manager?->name }}</p>
                        <hr>
                        <strong><i class="far fa-address-book mr-1"></i> Direction</strong>
                        <p class="text-muted">{{ $user->direction_user?->direction?->name }}</p>
                        <hr>
                        <strong><i class="far fa-user mr-1"></i> Directeur</strong>
                        <p class="text-muted">{{ $directeur?->name }}</p>
                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activité</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Gantt</a></li>
                            @if ($user->id == Auth::user()->id)
                                <li class="nav-item"><a class="nav-link" href="#settings"
                                        data-toggle="tab">Configuration</a>
                            @endif
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- activité -->
                                @include('users.partials.activity')
                                <!-- /.activité -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <!-- Gantt -->
                                @include('users.partials.gantt')
                                <!-- Gantt -->
                                {{-- @include('projects.partials.gantt') --}}
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" method="post" action="{{ route('update-user-info') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nom et prenom</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value="{{ $user->name }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value="{{ $user->email }}"
                                                disabled>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Nom d'utilisateur</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputUsername" value="{{ $user->username }}" disabled>
                                    </div>
                                </div> --}}
                                    <div class="form-group row">
                                        <label for="profile" class="col-sm-2 form-label">Photo de profil</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="profile"
                                                class="form-control @error('profile') is-invalid @enderror" id="profile">
                                            @error('profile')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label for="line_manager" class="col-sm-2 col-form-label">Line Manager</label>
                                        <div class="col-sm-10">
                                            <select name="line_manager" class="form-control select2 w-100 h-5"
                                                id="user">
                                                <option value="{{ $line_manager?->email }}">{{ $line_manager?->name }}
                                                </option>

                                            </select>
                                        </div>
                                        @error('line')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="form-group row">

                                        <label for="direction" class="col-sm-2 col-form-label">Direction</label>
                                        <div class="col-sm-10">
                                            <select name="direction" class="form-control">
                                                <option value="{{ $user->direction_user?->direction?->id }}">
                                                    {{ $user->direction_user?->direction?->name }}</option>
                                                @foreach ($directions as $direction)
                                                    <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" id="inputEmail"
                                        value="{{ $line_manager?->email }}" placeholder="email" name="email">

                                    <div class="form-group row float-left">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
@push('third_party_scripts')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
@endpush
@push('page_scripts')
    @vite('resources/css/style.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jszip/jszip.min.js') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
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
    <script type='module'>
        $(function() {
            $("#tab_user_activity").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",

            }).buttons().container().appendTo('#tab_project_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        function supprimer(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));
            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('project') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";
        }
    </script>
@endpush
