@extends('layouts.app')
@section('title')
    Roles
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Roles</a></li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card-body p-0">
            <button type="button" class="btn btn-primary m-4 float-right" data-toggle="modal" data-target="#create_modal">
                <i class="fas fa-plus-circle">
                </i>
            </button>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects text-center">
                    <thead>
                        <tr>
                            <th class="text-center col-lg-1">
                                #
                            </th>
                            <th class="text-center col-lg-9">
                                Roles
                            </th>
                            <th class="text-right col-lg-2">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center col-lg-1">
                            @foreach ($roles as $role)
                        <tr>
                            <td class="text-center col-lg-1">{{ $role->id }}</td>
                            <td class="text-center col-lg-9">{{ $role->name }}</td>
                            <td class="text-right  col-lg-2">
                                <form action="" method="POST">
                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.show', $role->id) }}">
                                        <i class="fas fa-folder">
                                        </i>
                                    </a>
                                    @access('delete', 'User')
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-danger btn-sm" href="{{ route('roles.destroy', $role->id) }}"
                                            onclick="supprimer(event)" item="Voulez-vous supprimer le role {{ $role->name }}"
                                            data-toggle="modal" data-target="#supprimer">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    @endaccess
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            @include('layouts.delete')
            @include('roles.create')
            <!-- /.card-body -->
        </div>
        <div class="d-flex justify-content-center pagination-lg">
            {!! $roles->links('pagination::bootstrap-4') !!}
        </div>
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
