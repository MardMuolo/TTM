@extends('layouts.app')
@section('title')
    Roles
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#" class="text-orange">Roles</a></li>
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
        <div class="card p-2">
            <div class="card-body">
                <table class="table table-striped projects text-center" id="tab_role">
                    <thead class="thead-color">
                        <th class="text-center col-lg-1"></th>
                        <th class="text-center col-lg-9"> Roles</th>
                        <th class="text-right col-lg-2">Actions</th>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
            </div>
            @include('layouts.delete')
            @include('roles.create')
            <!-- /.card-body -->
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
    <script type='module'>
        $(function() {
            $("#tab_role").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",
            }).buttons().container().appendTo('#tab_role_wrapper .col-md-6:eq(0)');
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
