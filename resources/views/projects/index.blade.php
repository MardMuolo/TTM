@extends('layouts.app')
@section('title')
    Projets @if ($filter)
        <span class="text-red h-6!">/{{ $filter }}</span>
    @endif
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Projets</a></li>
@endsection
@section('content')
    <section class="content card card-orange card-outline p-4">
        @access('create', 'Project')
            <div class="text-right mx-4">
                <a class="btn m-2 bg-dark " href="{{ route('projects.create') }}"><i class="fas fa-plus-circle icon"></i></a>
            </div>
        @endaccess
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Total:{{ count($projects) }}</h3>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects" id="tab_project">
                <thead class="text-left thead-color">
                    <tr>
                        <th style="width: 1%"></th>
                        <th style="width: 20%">Nom</th>
                        <th style="width: 30%">Equipe</th>
                        <th>Progression</th>
                        <th style="width: 8%" class="text-center">Statut</th>
                        <th style="width: 20%"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <strong class="text-black">{{ $project->name }}
                                    @if (auth()->user()->name == $project->projectOwner)
                                        <i class="fas fa-user-tie text-orange"></i>
                                    @else
                                        <i class="fas fa-group text-darkblue"></i>
                                    @endif
                                </strong><br>
                                <small>
                                    <b class="text-black-50">Du:</b> {{ $project->startDate }} - <b
                                        class="text-black-50">Au:</b> {{ $project->endDate }}
                                </small>
                            </td>
                            <td>
                                @forelse ($project->users as $membres)
                                    <li class="list-inline-item">
                                        <span title="{{ $membres->pivot->role }}"
                                            class="badge bg-{{ $tab[array_rand(array_keys($tab), 1)] }}  text-center">{{ $membres->username }}</span>
                                    </li>
                                @empty
                                    <ul class="list-inline">
                                        <li class="list-inline-item text-black-50 h6">Aucun membre pour l'instant</li>
                                    </ul>
                                @endforelse
                            </td>
                            <td class="item_progress">
                                @php
                                    $onProgress = [];
                                    $finish = [];
                                    $total = [];
                                    foreach ($project->optionsJalons as $jalon) {
                                        if ($jalon->pivot->status == env('jalonCloturer')) {
                                            array_push($finish, $jalon->pivot->status);
                                        } else {
                                            array_push($onProgress, $jalon->pivot->status);
                                        }
                                        array_push($total, $jalon->pivot->status);
                                    }
                                    $moyenne = count($finish) != 0 ? (count($finish) * 100) / count($total) : 0;
                                    $moyenne_arrondie = round($moyenne, 0);
                                @endphp
                                <div class="progress progress-sm">
                                    @php
                                        if ($moyenne_arrondie < 30) {
                                            $color = 'bg-red';
                                        } elseif ($moyenne_arrondie > 30 && $moyenne_arrondie < 60) {
                                            $color = 'bg-orange';
                                        } elseif ($moyenne_arrondie > 60 && $moyenne_arrondie < 100) {
                                            $color = 'bg-green';
                                        } else {
                                            $color = 'bg-primary';
                                        }
                                    @endphp
                                    <div class="progress-bar {{ $color }}" role="progressbar" aria-valuenow="57"
                                        aria-valuemin="0" aria-valuemax="100" style="width: {{ $moyenne_arrondie }}%">
                                    </div>
                                </div>
                                <small>{{ $moyenne_arrondie }}% Complete</small>
                            </td>
                            <td class="item-state">
                                <span
                                    class="badge  {{ $project->status == env('projetSoumis') ? 'bg-secondary' : $color }}">{{ $project->status }}</span>
                            </td>
                            <td class="item-actions text-right">
                                @access('read', 'Project')
                                @php
                                    $id=Crypt::encrypt($project->id)
                                @endphp

                                    <a class="btn btn-light btn-sm" href="{{ route('projects.show',$id) }}"
                                        title="voir"><i class="fas fa-eye"></i></a>
                                @endaccess

                                @access('update', 'Project')
                                    @if (auth()->user()->name == $project->projectOwner)
                                        <a class="btn btn-light btn-sm" href="{{ route('projects.edit', $project->id) }}"><i
                                                class="fas fa-pencil-alt" title="editer"></i></a>
                                    @endif
                                @endaccess

                                @access('delete', 'Project')
                                    <a class="btn btn-danger btn-sm" href="{{ route('projects.destroy', $project->id) }}"
                                        onclick="supprimer(event)"
                                        project="Voulez-vous supprimer le Projet {{ $project->name }}" data-toggle="modal"
                                        data-target="#supprimer" title="archiver">
                                        <i class="fas fa-archive"></i>
                                    </a>
                                @endaccess
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('layouts.delete')
        </div>
    </section>
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
            $("#tab_project").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",
                "buttons": [{
                    extend: 'csv',
                    title: 'les projects  {{ $filter }}',

                }, "excel", {
                    extend: 'pdf',
                    title: 'les projects  {{ $filter }}',

                }, {
                    extend: 'print',
                    title: 'les projects  {{ $filter }}'
                }, "colvis"]
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
