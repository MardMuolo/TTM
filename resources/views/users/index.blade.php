@extends('layouts.app')
@section('title')
    Liste des Utilisateurs
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Liste des Utilisateurs</a></li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body  p-0">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">Nom</th>
                            <th>Email</th>
                            <th>Rôles</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-left"> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a>
                                    @endforeach
                                </td>

                                <td class="text-right">
                                    <a href=" {{ route('users.edit', $user->id) }} "><button
                                            class=" btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></button></a>
                                    @access('delete', 'User')
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-danger btn-sm" href="{{ route('users.destroy', $user->id) }}"
                                                onclick="supprimer(event)"
                                                item="Voulez-vous supprimer l'utilisateur {{ $user->username }}"
                                                data-toggle="modal" data-target="#supprimer">
                                                <i class="fas fa-trash">
                                                </i>

                                            </a>
                                        </form>
                                    @endaccess
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('layouts.delete')
    </div>
@endsection
@section('scripts')
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
    </script>
@endsection
