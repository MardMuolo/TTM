@extends('layouts.app')
@section('title')
    Directions : {{ $directions->count() }}
@endsection

@section('filsAriane')
    <li class="breadcrumb-item active">Directions</li>
@endsection

@section('content')
    <div class="container-fluid">
        @if (Session::get('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div>
        @elseif (Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <section class="content">
            <div class="card">

                <div class="card-body p-0">
                    <button type="button" class="btn btn-primary m-4 float-right" data-toggle="modal"
                        data-target="#create_modal">
                        <i class="fas fa-plus-circle">
                        </i>

                    </button>
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 40%">
                                    Nom de direction
                                </th>
                                <th>
                                    Directeur
                                </th>
                                <th style="width: 40%" class="text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($directions->count() == 0)
                                <tr class="text-muted">
                                    <td colspan="3" class="text-center">Aucune donnée</td>
                                </tr>
                            @endif
                            @foreach ($directions as $direction)
                                <tr>

                                    <td>
                                        {{ $direction->name }}
                                    </td>
                                    <td>
                                        {{ $direction->direction_users?->Where('is_director', true)->first()?->user?->name }}
                                    </td>
                                    <td class="project-actions text-center">
                                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('ComplexityItem.show', $direction->id) }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            
                                        </a> --}}
                                        <a class="btn btn-info btn-sm" href="{{ route('directions.update', $direction) }}"
                                            onclick="edit(event)" direction = "{{ $direction->name }}"
                                            directeur="{{ $direction->direction_users?->Where('is_director', true)->first()?->user?->name }}"
                                            directeur_email="{{ $direction->direction_users?->Where('is_director', true)->first()?->user?->email }}"
                                            data-toggle="modal" data-target="#edit">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('directions.destroy', $direction) }}" onclick="supprimer(event)"
                                            item="Voulez-vous supprimer la direction {{ $direction->name }}"
                                            data-toggle="modal" data-target="#supprimer">
                                            <i class="fas fa-trash">
                                            </i>

                                        </a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-xl m-0 float-right">
                        <li class="page-item m-2"><a class="page-link" href="{{ $directions->previousPageUrl() }}">«
                                Précedant</a></li>
                        <li class="page-item m-2"><a class="page-link" href="{{ $directions->nextPageUrl() }}">»
                                Suivant</a></li>
                    </ul>
                </div>
                @include('directions.partials.create')
                @include('layouts.delete')
                @include('directions.partials.edit')
            </div>
        </section>

    </div>
@endsection
@push('third_party_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/bs-stepper/js/bs-stepper.min.js?commonjs-entry') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js?commonjs-entry') }}"></script>
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css');
    @vite('node_modules/admin-lte/plugins/bs-stepper/css/bs-stepper.min.css');
@endpush

@push('page_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}"></script>
    <script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js?commonjs-entry') }}">
    </script>
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
                        $('#directeur').select2({
                            data: formattedData,
                            minimumInputLength: 1
                        });
                        $('#directeur_edit').select2({
                            data: formattedData,
                            minimumInputLength: 1
                        });



                        // Événement de sélection d'utilisateur
                        $('#directeur').on('select2:select', function(e) {
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
    <script>
        function supprimer(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));

            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('item') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";



        }


        function edit(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let editForm = document.getElementById('editForm');
            editForm.setAttribute('action', a.getAttribute('href'));

            let a_tag = event.target.closest('a');

            let titleEdit = document.getElementById('titleEdit');
            titleEdit.innerHTML = "Modification de l'élement " + a_tag.getAttribute('direction');

            document.getElementById('direction').value = a_tag.getAttribute('direction');
            document.getElementById('directeur_edit').innerHTML = a_tag.getAttribute('directeur') + "";
            document.getElementById('inputEmail2').value = a_tag.getAttribute('directeur_email');

        }
    </script>
@endpush
