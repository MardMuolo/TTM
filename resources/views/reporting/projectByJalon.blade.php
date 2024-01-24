@extends('layouts.app')
@section('title')
    Projets au Jalon @if ($status)
        <span class="text-red h-6!">/{{ $status }}</span>
    @endif
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a class="active text-orange" href="#">Projet</a></li>
@endsection
@section('content')
    <section class="content card card-orange card-outline p-4">
        <div class="card">
            <div class="card-header bg-black">
                <h3 class="card-title text-orange">Total ({{ count($projects) }})</h3>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects" id="tab_project">
                <thead class="text-left text-orange">
                    <th style="width: 1%"></th>
                    <th style="width: 20%">Nom</th>
                    <th style="width: 30%">Equipe</th>
                    <th>Progression</th>
                    <th style="width: 8%" class="text-center">Statut</th>
                    <th style="width: 20%"></th>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <strong>{{ $project->name }}
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


                                @php
                                    $uniqueValues = [];
                                @endphp

                                @forelse ($project->users as $membres)
                                    @php
                                        $directionName = $membres->direction_user?->direction->name ?? 'N/A';
                                    @endphp

                                    @if (!in_array($directionName, $uniqueValues))
                                        @php
                                            $uniqueValues[] = $directionName;
                                            $randomKey = array_rand(array_keys($tab), 1);
                                            $randomColor = $tab[$randomKey];
                                        @endphp

                                        <li class="list-inline-item">
                                            <span title="{{ $membres->pivot->role }}"
                                                class="badge bg-{{ $randomColor }} text-center">{{ $directionName }}</span>
                                        </li>
                                    @endif
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
                                        $id = Crypt::encrypt($project->id);
                                    @endphp

                                    <a class="btn btn-light btn-sm" href="{{ route('projects.show', $id) }}" title="voir"><i
                                            class="fas fa-eye"></i></a>
                                @endaccess

                                @access('update', 'Project')
                                    @php
                                        $id = Crypt::encrypt($project->id);
                                    @endphp
                                    @if (auth()->user()->name == $project->projectOwner)
                                        <a class="btn btn-light btn-sm" href="{{ route('projects.edit', $id) }}"><i
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
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}">
    </script>
@endpush
@push('page_scripts')
    @vite('resources/css/style.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js?commonjs-entry') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js?commonjs-entry') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?commonjs-entry') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js?commonjs-entry') }}">
    </script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jszip/jszip.min.js?commonjs-entry') }}">
    </script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js?commonjs-entry') }}">
    </script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js?commonjs-entry') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js?commonjs-entry') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js?commonjs-entry') }}">
    </script>
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

                }, "excel", {
                    extend: 'pdf',

                }, {
                    extend: 'print',
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
