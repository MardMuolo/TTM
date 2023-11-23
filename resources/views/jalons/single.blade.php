@extends('layouts.app')
@section('title')
    Jalon {{ $jalon->designation }}
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a></li>
    <li class="breadcrumb-item text-secondary">Demande</li>
@endsection
@section('content')
    <section class="content">
        <!-- Vue -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            @if (empty($debutDate) && empty($echeance))
                <div class="row ml-2">
                    <div class="text-right mr-2">
                        @if (auth()->user()->name == $project->projectOwner)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="far fa-calendar-alt"></i>
                            </button>
                        @endif

                    </div>
                    <div class="mt-2">
                        <p>Veuillez planifier les dates pour ce jalon.</p>
                    </div>
                </div>
            @else
                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            @if (!empty($debutDate))
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="far fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Date Début</span>
                                        <span
                                            class="info-box-number">{{ \Carbon\Carbon::parse($debutDate)->format('d/m/Y') }}</span>
                                    </div>

                                </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            @if (!empty($echeance))
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="far fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Date Fin</span>
                                        <span
                                            class="info-box-number">{{ \Carbon\Carbon::parse($echeance)->format('d/m/Y') }}</span>
                                    </div>
                                    @if ($status == 'Finis')
                                        <span class="info-box-number"><button type="button"
                                                class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                title="Ce jalon est finis" disabled data-target="#modal-date">
                                                <i class="fas fa-edit"></i>
                                            </button></span>
                                    @else
                                        <span class="info-box-number"><button type="button"
                                                class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                data-target="#modal-date">
                                                <i class="fas fa-edit"></i>
                                            </button></span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Décider de la fin du jalon</span>
                                    <span class="info-box-number">
                                        @if ($status == 'Finis')
                                            <button type="button" class="btn btn-light btn-sm float-right"
                                                data-toggle="modal" data-target="#modal-fin-jalon"
                                                title="ce jalon est finis" disabled>
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        @else
                                            @if (auth()->user()->name == $project->projectOwner)
                                                <span class="info-box-number"><button type="button"
                                                        class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                        data-target="#modal-fin-jalon">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button></span>
                                            @endif
                                        @endif
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-history"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        <div class="card-tools">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Historique des dates</button>
                                                <div class="dropdown-menu float-right text-scroll" role="menu">
                                                    @forelse ($historiques->reverse() as $historique)
                                                        <del>
                                                            <a href="#"
                                                                class="dropdown-item">{{ \Carbon\Carbon::parse($historique->date_initiale)->format('d/m/Y') }}</a>
                                                        </del>
                                                    @empty
                                                        <div class="ml-2">Date non repoussée pour le moment</div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif
    </section>
    <section class="content">
        <div class="row justify-content-end text-right">
            @if (auth()->user()->name == $project->projectOwner)
                <div class="col-sm-12 col-md-6">
                    @if (empty($debutDate) || empty($echeance) || $status == 'Finis')
                        @if (auth()->user()->name == $project->projectOwner)
                            <button class="btn btn-light m-2 bg-dark"
                                title="{{ $status == 'Finis' ? 'Ce jalon est fini' : 'Veuillez d\'abord définir les dates' }}"
                                disabled>
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        @endif
                    @else
                        <button class="btn btn-light m-2 bg-dark" title="Ajouter une demande" data-toggle="modal"
                            data-target="#create_modal">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    @endif
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="tab_demande" class="table table-striped" aria-describedby="example1_info">
                    <thead>
                        <th style="width: 3%"></th>
                        <th style="width: 35%">Demande</th>
                        <th>Modèle</th>
                        <th>Date prévue</th>
                        <th>Retard</th>
                        <th>Status</th>
                        <th style="width: 20%"></th>
                    </thead>
                    <tbody>
                        @forelse ($jalonDemande as $item)
                            <tr>
                                <td>{{ $i++ }}</td>

                                <td style="" class="dtr-control" tabindex="0">
                                    <div class="row">
                                        <div class="col">
                                            {{ $item->demande->title }}
                                        </div>
                                        @php
                                            $data = json_encode($item);
                                        @endphp
                                    </div>
                                </td>

                                <td class="text-center"><a
                                        href="{{ asset('storage/demandes/' . basename($item->pathTask)) }}" download><i
                                            class="fas fa-download"></i></a>
                                </td>

                                <td>{{ \Carbon\Carbon::parse($item->date_prevue)->format('d/m/Y') }} </td>

                                <td>
                                    @if ($item->date_reelle && $item->date_reelle <= $item->date_prevue)
                                        <small class="badge badge-success">Pas de retard observé</small>
                                    @elseif ($item->retard === null)
                                        <small class="badge badge-success">Pas de retard observé</small>
                                    @else
                                        @if ($item->retard === 0)
                                            <small class="badge badge-warning">{{ $item->retard }}
                                                jour</small>
                                        @else
                                            <small class="badge badge-danger">{{ $item->retard }}
                                                jour{{ $item->retard > 1 ? 's' : '' }}</small>
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    @if ($item->status === 'Soumis')
                                        <small class="badge badge-success">{{ $item->status }}</small>
                                    @elseif ($item->status === 'rejeté')
                                        <small class="badge badge-danger">{{ $item->status }}</small>
                                    @elseif ($item->status === 'à corriger')
                                        <small class="badge badge-warning">{{ $item->status }}</small>
                                    @else
                                        <small class="badge badge-light">{{ $item->status }}</small>
                                    @endif
                                </td>

                                <td>
                                    <div class="row">
                                        <a class="btn btn-sm" href="{{ route('show_demande', ['project'=>$project->id,'optionttm'=>$optionTtm->id,'jalon'=>$jalon->id,'demande'=>$item->id]) }}"
                                            role="button">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($status != 'Finis')
                                            <a class="btn btn-sm" data-widget="control-sidebar"
                                                data-controlsidebar-slide="true"
                                                data-target="#edit-{{ $item->id }}-2"
                                                href="#edit-{{ $item->id }}-2" role="button">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a class="btn btn-sm bg-warning" href="/" onclick="supprimer(event)"
                                                demande="Voulez-vous supprimer cette demande {{ $item->demande->title }}"
                                                data-toggle="modal" data-target="#supprimer" title="archiver">
                                                <i class="fas fa-archive"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @include('jalons.create')
        @include('layouts.delete')
        {{-- @include('demande.delete') --}}
        {{-- @include('validation.index') --}}
        {{-- @include('jalons.edit') --}}
    </section>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var jalonPvInput = document.getElementById('jalonPv');
            var submitBtn = document.getElementById('submitBtn');

            jalonPvInput.addEventListener('change', function() {
                if (jalonPvInput.value !== '') {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.nav-link.disabled').on('click', function(e) {
                e.preventDefault();
            });
        });
    </script>
@endsection


@push('third_party_scripts')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type='module'src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page_css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
@endpush
@push('page_scripts')
    <script type="module">
        $(document).ready(function() {
            if (true) {
                (async () => {

                    /* inputOptions can be an object or Promise */
                    const inputOptions = new Promise((resolve) => {
                        setTimeout(() => {
                            resolve({
                                'd': 2
                            })
                        }, 800)
                    })
                    const {
                        value: sondage
                    } = await Swal.fire({
                        icon: 'success',
                        title: '<h2 class="text-success">Création avec Succès</h2> ',
                        html: 'Le score est de <span class="text-black-50 h6">{{ $score ?? 'N/A' }}</span> et le projet est retenu en mode <span class="text-black-50 h6">{{ $options->nom ?? 'N/A' }}</span><br> Veuillez préciser les dates des jalons du projet',
                    })
                })()
            }

            $.ajax({
                url: 'http://10.143.41.70:8000/promo2/odcapi/?method=getUsers',
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        var data = response.users;

                        var formattedData = data.map(function(user) {
                            return {
                                id: user.id,
                                username: user.username,
                                text: user.last_name + ' ' + user.first_name,
                                email: user.email,
                                phone: user.phone,
                                first_name: user.first_name,
                                last_name: user.last_name,
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

                            // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                            // $('#user').val(selectedUser.username);
                            $('#username').val(selectedUser.username);
                            $('#inputEmail').val(selectedUser.email);
                            $('#name').val(selectedUser.text);

                            var fullName = selectedUser.first_name + ' ' + selectedUser
                                .last_name;
                            $('#name').val(fullName);
                        });

                        // Événement de sélection d'utilisateur
                        $('#manager').on('select2:select', function(e) {
                            var selectedUser = e.params.data;

                            // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                            // $('#user').val(selectedUser.username);
                            $('#username_manager').val(selectedUser.username);
                            $('#inputEmail_manager').val(selectedUser.email);
                            $('#name_manager').val(selectedUser.text);

                            var fullName = selectedUser.first_name + ' ' + selectedUser
                                .last_name;
                            $('#name').val(fullName);
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

    <script>
        function update_demande(event) {
            var td = event.target.previousElementSibling;
            var data = JSON.parse(td.textContent);
            console.log(data);
            description_edit.value = data.description;
            demande_file.textContent = data.pathTask;
            var tb = data.deadLine.split(' ');
            form_edit.deadLine.value = tb[0];
            form_edit.deadline_unit.value = tb[1];
            form_edit.category_edit.value = data.demande.category_demande_id;
            form_edit.demande_edit.value = data.demande.id;

            form_edit.contributeur.value = data.one_contributeur.id;
            $("#user_edit").select2();

        }
    </script>

    <script type='module'>
        $(function() {
            $("#tab_demande").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
