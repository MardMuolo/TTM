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
                <div class="card-body">
                    <table class="table table-striped projects text-center" id="tab_writeList">
                        <thead class="thead-color">
                                <th class="text-center col-lg-1">
                                    #
                                </th>
                                <th class="text-center col-lg-9">
                                    Utilisateurs
                                </th>
                                <th class="text-right col-lg-2">
                                    Actions
                                </th>
                        </thead>
                        <tbody>
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
            $("#tab_writeList").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",
            }).buttons().container().appendTo('#tab_writeList_wrapper .col-md-6:eq(0)');
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