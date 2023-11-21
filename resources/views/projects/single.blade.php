@extends('layouts.app')
@section('title')
    {{ $project->name }}
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
    <li class="breadcrumb-item"><a href="#">{{ $project->name }}</a></li>
@endsection
@section('content')
    <div class="card card-primary card-outline p-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                        href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                        aria-selected="true">Détails</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-membre-tab" data-toggle="pill"
                        href="#custom-content-below-membre" role="tab" aria-controls="custom-content-below-membre"
                        aria-selected="true">Equipe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-jalon-tab" data-toggle="pill"
                        href="#custom-content-below-jalon" role="tab" aria-controls="custom-content-below-jalon"
                        aria-selected="true">Jalons ({{ count($jalons) }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="custom-content-below-task-tab" data-toggle="pill"
                        href="#custom-content-below-task" role="tab" aria-controls="custom-content-below-task"
                        aria-selected="false">Démandes ({{ count($demandesProject) }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                        href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile"
                        aria-selected="false">Activités ({{ count($activity) }}) </a>
                </li>
                <li class="nav-item">
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill"
                        href="#custom-content-below-settings" role="tab" aria-controls="custom-content-below-settings"
                        aria-selected="false">Gantt</a>
                </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
                    aria-labelledby="custom-content-below-home-tab">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Coût</span>
                                                <span
                                                    class="info-box-number text-center text-muted mb-0">{{ $project->coast }}
                                                    $</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Date du début</span>
                                                <span
                                                    class="info-box-number text-center text-muted mb-0">{{ $project->startDate }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Date de fin</span>
                                                <span
                                                    class="info-box-number text-center text-muted mb-0">{{ $project->endDate }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-muted">
                                    <div class="col-12">
                                        <h4 class="fs-1">Complexité</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Elements</th>
                                                    <th>Option de complexité
                                                        (à selectionner dans la liste déroulante)</th>
                                                    <th style="width: 40px">Score de complexité</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($project->projectComplexityItems as $item)
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        @foreach ($complexity_items as $complexityItem)
                                                            @if ($complexityItem->id == $item->complexity_item_id)
                                                                <td>{{ $complexityItem->name }}</td>
                                                            @endif
                                                        @endforeach
                                                        <td style="padding: 0; width: 100%;">
                                                            <div class="form-group" style="margin-bottom: 0;">
                                                                <select class="custom-select form-control-border w-100"
                                                                    id="exampleSelectBorder" style="height: 100%;"
                                                                    @disabled(true)
                                                                    data-item-id="{{ $item->id }}"
                                                                    onchange="updateTargetValue(this, {{ $item->id }})">
                                                                    <!-- Options du menu déroulant -->
                                                                    @foreach ($complexityTargets as $complexityTarget)
                                                                        @if ($complexityTarget->complexity_item_id == $item->complexity_item_id)
                                                                            <option class="w-100"
                                                                                value="{{ $complexityTarget->id }}"
                                                                                data-value="{{ $complexityTarget->value }}"
                                                                                selected>{{ $complexityTarget->value }} -
                                                                                {{ $complexityTarget->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="target-value" id="target-value-{{ $item->id }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="3" style="text-align: right"><strong>Complexité du
                                                            Projet</strong></td>
                                                    <td id="total-value">{{ $project->score }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {{-- <div class="clearfix">
                                 <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                 </ul>
                              </div> --}}
                                    </div>
                                    {{-- 
                        <div class="post clearfix">
                           <div class="user-block">
                              <img class="img-circle img-bordered-sm"
                                 src="{{ Vite::asset('resources/images/logo.svg') }}" alt="User Image">
                              <span class="username"><a href="#">{{ $project->projectOwner }}
                              </a></span>
                              <span class="description">envoyé depuis {{ $project->created_at }} </span>
                           </div>
                           <p>{{ $project->description }}</p>
                           @forelse ($file as $item)
                           <p><a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i>
                              {{ str_replace('documents/', '', $item->filePath) }}</a>
                           </p>
                           @empty
                           @endforelse
                        </div>
                        --}}
                                </div>
                            </div>
                            <div class="ol-12 col-md-12 col-lg-4 order-1 order-md-2">
                                <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ $project->name }}</h3>
                                <p class="text-muted">{{ $project->description }}</p>
                                <br>
                                <div class="text-muted">
                                    <p class="text-sm">Type de projet<b class="d-block">{{ $project->type }}</b></p>
                                    <p class="text-sm">Initiateur<b class="d-block">{{ $project->projectOwner }}</b>
                                    </p>
                                    <p class="text-sm">Sponsor<b class="d-block">{{ $project->sponsor ?? 'N/A' }}</b>
                                    </p>
                                    <p class="text-sm">Options TTM<b class="d-block">
                                            {{ $options->nom ?? 'Veuillez définir les options ttm ainsi que les jalons pour afficher les jalons de ce projet' }}
                                        </b>
                                    </p>
                                </div>
                                <div class="border-bottom">
                                    <h5 class="mt-5 text-muted">Document du projet</h5>
                                    <ul class="list-unstyled">
                                        @forelse ($file as $item)
                                            <li><a href="{{ asset('storage/documents/' . basename($item->filePath)) }}"
                                                    download class="btn-link text-secondary"><i
                                                        class="far fa-fw fa-file-word"></i>{{basename($item->filePath) }}</a>
                                            </li>
                                        @empty
                                            <li><a href="#" class="btn-link text-secondary"><i
                                                        class="far fa-fw fa-file-pdf"></i> Aucun document soumis</a></li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="text-center mt-5 mb-3 row">
                                    <div class="col-lg-5 nav-item ">
                                        <button
                                            class=" btn btn-sm btn-gray nav-link border">{{ $project->status }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade row" id="custom-content-below-membre"
                    role="tabpanel"aria-labelledby="custom-content-below-membre-tab">
                    <div class="row">
                        @include('projects.membres.index')
                    </div>
                </div>
                <div class="tab-pane fade row" id="custom-content-below-task"
                    role="tabpanel"aria-labelledby="custom-content-below-task-tab">
                    <div class="row">
                        @include('projects.partials.demandes')
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-jalon" role="tabpanel"
                    aria-labelledby="custom-content-below-profile-tab">
                    @include('projects.partials.jalons')
                </div>
                <div class="tab-pane fade" id="custom-content-below-profile"
                    role="tabpanel"aria-labelledby="custom-content-below-profile-tab">
                    <div class="row">
                        @include('projects.partials.activity')
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel"
                    aria-labelledby="custom-content-below-settings-tab">
                    <div class="row">
                        @include('projects.partials.gantt')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_css')
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
    @vite('node_modules/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
@endpush
@push('third_party_scripts')
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}">
    </script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="module" src="{{ vite::asset('node_modules/admin-lte/dist/js/demo.js') }}"></script>
@endpush
@push('page_scripts')
    <script type="module">
        // Fonction pour mettre à jour la valeur du target dans la dernière cellule <td>
        function updateTargetValue(selectElement, itemId) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var targetValueCell = document.querySelector('#target-value-' + itemId);
            var targetValue = selectedOption.getAttribute('data-value');
            targetValueCell.textContent = targetValue;
        }
        // Mettre à jour les valeurs par défaut au chargement de la page
        window.addEventListener('DOMContentLoaded', function() {
            var selectElements = document.querySelectorAll('.custom-select');
            selectElements.forEach(function(selectElement) {
                var itemId = selectElement.dataset.itemId;
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var targetValueCell = document.querySelector('#target-value-' + itemId);
                var targetValue = selectedOption.getAttribute('data-value');
                targetValueCell.textContent = targetValue;
            });
        });
    </script>
    <script type="module">
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": ""
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
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

                        // preConfirm: () => {
                        //     var debutDate = document.getElementById('dateStart').value;
                        //     var echeance = document.getElementById('dateEnd').value;

                        //     return {
                        //         debutDate: debutDate,
                        //         echeance:echeance
                        //     }
                        // },
                    })

                    // if (sondage) {
                    //     var Url="{{ route('repouserDate', ['jalon' => '1', 'option_ttm' => '1', 'project' => '1']) }}"
                    //     $.ajax({
                    //         url: Url,
                    //         type: 'POST',
                    //         data: {
                    //             date: sondage
                    //         },
                    //         success: (response) => {
                    //             console.log('Date enregistrée avec succès');
                    //         },
                    //         error: (xhr, status, error) => {
                    //             alert('Erreur lors de l\'enregistrement de la date '+Url);
                    //         }

                    //     })
                    // }


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


                        // Événement de sélection d'utilisateur
                        $('#user').on('select2:select', function(e) {
                            var selectedUser = e.params.data;

                            // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                            // $('#user').val(selectedUser.username);
                            $('#username').val(selectedUser.username);
                            $('#inputEmail').val(selectedUser.email);
                            $('#inputTel').val(selectedUser.phone);

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
            // $.ajax({
            //     url: '/directions.index/?direction_id='+directionId,
            //     dataType: 'json',
            //     success: function(response) {

            //         if (response.success) {
            //             var data = response.users;

            //             var formattedData = data.map(function(user) {
            //                 return {
            //                     id: directiion.id,
            //                     name: direction.name,

            //                 };
            //             });

            //             // Initialiser le champ de sélection avec les options
            //             $('#direction').select2({
            //                 data: formattedData,
            //                 minimumInputLength: 1
            //             });

            //             // Événement de sélection d'utilisateur
            //             $('#direction').on('select2:select', function(e) {
            //                 var selectedUser = e.params.data;

            //                 // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
            //                 // $('#user').val(selectedUser.username);
            //                 $('#directionName').val(selectedUser.name);
            //                 $('#directionId').val(selectedUser.id);
            //             });
            //         } else {
            //             console.log('Erreur: ' + response.message);
            //         }
            //     },
            //     error: function(xhr, status, error) {
            //         console.log('Erreur AJAX: ' + error);
            //     }
            // });
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
        $(document).ready(function() {
            swal({
                title: "Crétion de projet avec succes!",
                text: "Veuillez signaler les dates pour chaque jalon!",
                icon: "success",
                button: "Continuer!",
            });
        });
    </script>
@endpush
