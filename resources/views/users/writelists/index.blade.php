@extends('layouts.app')
@section('title')
    Utilisateur
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Utilisateurs</a></li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="text-right mb-2">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#create_modal">
                    <i class="nav-icon fa fa-plus "></i>
                </button>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects text-center">
                        <thead>
                            <tr>
                                <th class="text-center col-lg-1">
                                    #
                                </th>
                                <th class="text-center col-lg-9">
                                    Utilisateurs
                                </th>
                                <th class="text-right col-lg-2">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center col-lg-1">
                                @foreach ($writelists as $writelist)
                            <tr>
                                <td class="text-center col-lg-1">{{ $writelist->id }}</td>
                                <td class="text-center col-lg-9">{{ $writelist->username }}</td>
                                <td class="text-right  col-lg-2">
                                    <form action="" method="POST">
                                        <a class="btn btn-info btn-sm edit-btn" href="#" data-toggle="modal"
                                            data-target="#edit-{{ $writelist->username }}"
                                            form="edit-{{ $writelist->username }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('writelist.destroy', $writelist->id) }}"
                                            onclick="supprimer(event)"
                                            item="Voulez-vous supprimer l'utilisateur {{ $writelist->username }}"
                                            data-toggle="modal" data-target="#supprimer">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                            @include('users.writelists.partials.edit')
                            @include('layouts.delete')
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                @include('users.writelists.partials.create')
            </div>
            <div class="d-flex justify-content-center pagination-lg">
            </div>
        </div>



    </section>
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
