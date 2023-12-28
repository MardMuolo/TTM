@extends('layouts.app')
@section('title')
    metiers : {{ $metiers->count() }}
@endsection

@section('filsAriane')
    <li class="breadcrumb-item active">Metiers</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if ($errors)
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </section>
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
                                    Nom du metier
                                </th>
                                {{-- <th>
                                    Direction
                                </th> --}}
                                <th>
                                    LineManager
                                </th>
                                <th style="width: 40%" class="text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($metiers->count() == 0)
                                <tr class="text-muted">
                                    <td colspan="3" class="text-center">Aucune donnée</td>
                                </tr>
                            @endif
                            @foreach ($metiers as $metier)
                                <tr>

                                    <td>
                                        {{ $metier->name }}

                                    </td>
                                    {{-- <td>
                                        {{$metier->direction_id}}

                                    </td> --}}
                                    <td>
                                        {{ $metier->metier_users?->Where('is_manager', true)->first()?->user?->name }}
                                    </td>
                                    <td class="project-actions text-center">
                                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('ComplexityItem.show', $metier->id) }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            
                                        </a> --}}
                                        <a class="btn btn-info btn-sm" href="{{ route('metiers.update', $metier) }}"
                                            onclick="edit(event)" metier = "{{ $metier->name }}"
                                            directeur="{{ $metier->metier_users?->Where('is_director', true)->first()?->user?->name }}"
                                            directeur_email="{{ $metier->metier_users?->Where('is_director', true)->first()?->user?->email }}"
                                            data-toggle="modal" data-target="#edit">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm" href="{{ route('metiers.destroy', $metier) }}"
                                            onclick="supprimer(event)"
                                            item="Voulez-vous supprimer la metier {{ $metier->name }}" data-toggle="modal"
                                            data-target="#supprimer">
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
                        <li class="page-item m-2"><a class="page-link" href="{{ $metiers->previousPageUrl() }}">«
                                Précedant</a></li>
                        <li class="page-item m-2"><a class="page-link" href="{{ $metiers->nextPageUrl() }}">» Suivant</a>
                        </li>
                    </ul>
                </div>
                @include('metiers.partials.create')
                @include('layouts.delete')
                @include('metiers.partials.edit')
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
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
            titleEdit.innerHTML = "Modification de l'élement " + a_tag.getAttribute('metier');

            document.getElementById('metier').value = a_tag.getAttribute('metier');
            document.getElementById('directeur_edit').innerHTML = a_tag.getAttribute('directeur') + "";
            document.getElementById('inputEmail2').value = a_tag.getAttribute('directeur_email');

        }
    </script>

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

                    $('#manager').select2({
                        data: formattedData,
                        minimumInputLength: 1
                    });


                    // Événement de sélection d'utilisateur
                    $('#user').on('select2:select', function(e) {
                        var selectedUser = e.params.data;
                        console.log(`name ${selectedUser.text}`)

                        // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                        // $('#user').val(selectedUser.username);
                        $('#sponsor_username').val(selectedUser.username);
                        $('#sponsor_Email').val(selectedUser.email);
                        $('#sponsor_name').val(selectedUser.text);
                        $('#sponsor_phone_number').val(selectedUser.phone);

                        // var fullName = selectedUser.first_name + ' ' + selectedUser
                        //     .last_name;
                        // $('#name').val(fullName);
                    });

                    // Événement de sélection d'utilisateur
                    $('#manager').on('select2:select', function(e) {
                        var selectedUser = e.params.data;
                        // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                        // $('#user').val(selectedUser.username);
                        $('#username_manager').val(selectedUser.username);
                        $('#inputEmail_manager').val(selectedUser.email);
                        $('#name_manager').val(selectedUser.text);
                        $('#phone_number_manager').val(selectedUser.phone);

                        // var fullName = selectedUser.first_name + ' ' + selectedUser
                        //     .last_name;
                        // $('#name').val(name);
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
</script>
@endsection
