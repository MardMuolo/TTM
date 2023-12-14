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
                <table class="table table-striped" id="tab_user">
                    <thead>
                        <th class="text-left">Nom</th>
                        <th>Email</th>
                        <th>Rôles</th>
                        <th class="text-right">Actions</th>
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
@push('third_party_scripts')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}"></script>
@endpush
@push('page_scripts')
    @vite('resources/css/style.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js?commonjs-entry') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js?commonjs-entry') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?commonjs-entry') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js?commonjs-entry') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jszip/jszip.min.js?commonjs-entry') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js?commonjs-entry') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js?commonjs-entry') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js?commonjs-entry') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js?commonjs-entry') }}"></script>
    <script type='module'>
        $(function() {
            $("#tab_user").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",
            }).buttons().container().appendTo('#tab_user_wrapper .col-md-6:eq(0)');
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
