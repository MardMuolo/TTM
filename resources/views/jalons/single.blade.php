@extends('layouts.app')
@section('title')
    Jalon {{ $jalon->designation }}
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
    <li class="breadcrumb-item"><a
            href="{{ route('projects.show', Crypt::encrypt($project->id)) }}">{{ substr(str_replace([' ', "'"], '', $project->name), 0, 10) }}...</a>
    </li>
    <li class="breadcrumb-item text-orange">Demande</li>
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
        <div class="row">
            @if (empty($debutDate) && empty($echeance))
                <div class="col">
                    <div class="text-right mr-2">
                        @if (auth()->user()->name == $project->projectOwner)
                            <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="far fa-calendar-alt "></i>
                            </button>
                        @endif

                    </div>
                    <div class="mt-2">
                        <p>Veuillez planifier les dates pour ce jalon.</p>
                    </div>
                </div>
            @else
                <div class="col">
                    <div class="row">
                        <div class="col">
                            @if (!empty($debutDate))
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary"><i class="far fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Date Début</span>
                                        <span
                                            class="info-box-number">{{ \Carbon\Carbon::parse($debutDate)->format('d/m/Y') }}</span>
                                    </div>

                                </div>
                            @endif
                        </div>

                        <div class="col">
                            @if (!empty($echeance))
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="far fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Date Fin</span>
                                        <span
                                            class="info-box-number">{{ \Carbon\Carbon::parse($echeance)->format('d/m/Y') }}</span>
                                    </div>
                                    @if ($status == env('jalonCloturer'))
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
                        @access('update', 'Jalon')
                            @foreach (Auth()->user()->roles as $role)
                                @if ($role->name == env('TtmOfficer'))
                                    <div class="col">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-warning"><i class="far fa-calendar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Décider de la fin du jalon</span>
                                                <span class="info-box-number">
                                                    @if ($status == env('jalonCloturer'))
                                                        <button type="button" class="btn btn-light btn-sm float-right"
                                                            data-toggle="modal" data-target="#modal-fin-jalon"
                                                            title="ce jalon est finis" disabled>
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    @else
                                                        <span class="info-box-number"><button type="button"
                                                                class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                                data-target="#modal-fin-jalon">
                                                                <i class="fas fa-plus-circle"></i>
                                                            </button></span>
                                                    @endif
                                                </span>
                                            </div>

                                        </div>

                                    </div>
                                @endif
                            @endforeach
                        @endaccess

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fas fa-history"></i></span>
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
    </section>
    <section class="content">
        <div class="card-header bg-black">
            <h3 class="card-title text-orange">Total Demande ({{ count($jalonDemande) }})</h3>
        </div>
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
                        <button class="btn btn-light m-2 bg-black text-orange" title="Ajouter une demande" data-toggle="modal"
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
                    <thead class="bg-black text-orange">
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
                                        href="{{ asset('storage/' . $item->pathTask) }}"
                                        download>Telecharger<i class="fas fa-download"></i></a>
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
                                    @if ($item->status === env('demandeSoumise'))
                                        <small class="badge badge-success">{{ $item->status }}</small>
                                    @elseif ($item->status === env('demandeNonSoumise'))
                                        <small class="badge badge-danger">{{ $item->status }}</small>
                                    @elseif ($item->status === env('demandeRenvoyer'))
                                        <small class="badge badge-warning">{{ $item->status }}</small>
                                    @else
                                        <small class="badge badge-light">{{ $item->status }}</small>
                                    @endif
                                </td>

                                <td>
                                    <div class="row">
                                        <a class="btn btn-sm"
                                            href="{{ route('show_demande', ['project' => encrypt($project->id), 'optionttm' => encrypt($optionTtm->id), 'jalon' => encrypt($jalon->id), 'demande' => $item->id]) }}"
                                            role="button">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($status != env('jalonCloturer'))
                                            @access(['update', 'delete'], 'DemandeJalon')
                                                <a class="btn btn-sm" data-widget="control-sidebar"
                                                    data-controlsidebar-slide="true"
                                                    data-target="#edit-{{ $item->id }}-2"
                                                    href="#edit-{{ $item->id }}-2" role="button">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="btn btn-sm bg-warning"
                                                    href="{{ route('demandeJalon.destroy', $item->id) }}"
                                                    onclick="supprimer(event)"
                                                    demande="Voulez-vous supprimer cette demande '{{ $item->demande->title }}'"
                                                    data-toggle="modal" data-target="#supprimer" title="archiver">
                                                    <i class="fas fa-archive"></i>
                                                </a>
                                            @endaccess
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

        <div class="modal fade" id="modal-fin-jalon" tabindex="-1" role="dialog"
            aria-labelledby="modal-fin-jalon-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    @if ($totalDemandes <= 0 || $demandesSoumises < $totalDemandes)
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-finish-jalon-label">Message d'avertissement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $demandesSoumises }}Toutes les demandes doivent être soumises avant de terminer le jalon.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    @else
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-finish-jalon-label">Voulez-vous vraiment <span
                                    id="comiteAlerte">cloturer ce jalon?</span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form
                            action="{{ route('jalons.updateStatus', [
                                'jalon' => Crypt::encrypt($jalon->id),
                                'option_ttm' => Crypt::encrypt($optionTtm->id),
                                'project' => Crypt::encrypt($project->id),
                            ]) }}"
                            method="POST" style="display: inline" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group" id="depot">
                                    <label for="exampleInputFile">Deposez un PV</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="jalonPv"
                                                name="jalonPv" required>
                                            <label class="custom-file-label" for="jalonPv">choisir un fichier</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="depot">
                                    <label for="exampleInputFile">Date effective</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="date" class="form-control" min="{{ $echeance ?? '' }}"
                                                id="dateEffective" name="dateEffective" required>
                                        </div>
                                    </div>
                                </div>
                                @if ($jalon->designation == 'T0')
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="comite" name="comite">
                                        <label for="comite">Passé au comité</label>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times"></i></button>
                                <button type="submit" class="btn btn-primary" id="submitBtn"><i
                                        class="fa fa-check"></i></button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-date">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Repouser l'écheance</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"
                            action="{{ route('repouserDate', ['jalon' => Crypt::encrypt($jalon->id), 'option_ttm' => Crypt::encrypt($optionTtm->id), 'project' => Crypt::encrypt($project->id)]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="col">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="echeance">Date Fin</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" value="{{ $echeance }}"
                                                inputformat="mm/dd/yyyy" name="echeance" id="echeance">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        @include('jalons.create')
        @include('layouts.delete')
        {{-- @include('demande.delete') --}}
        {{-- @include('validation.index') --}}
        {{-- @include('jalons.edit') --}}
        @php
            $url = route('jalons.updateStatus', [
                'jalon' => Crypt::encrypt($jalon->id),
                'option_ttm' => Crypt::encrypt($optionTtm->id),
                'project' => Crypt::encrypt($project->id),
            ]);
        @endphp
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js?commonjs-entry') }}">
    </script>
    {{-- <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/inputmask/jquery.inputmask.min.js?commonjs-entry') }}">
    </script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/moment/moment.min.js?commonjs-entry') }}">
    </script> --}}
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js?commonjs-entry') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js?commonjs-entry') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js?commonjs-entry') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js?commonjs-entry') }}">
    </script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?commonjs-entry') }}">
    </script>
@endpush

@push('page_css')
    @vite('node_modules/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
@endpush
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('[data-mask]').inputmask()
            $.ajax({
                url: '{{ route('getUsers') }}',
                type: 'Get',
                dataType: 'json',
                success: function(response) {
                    console.log(response)

                    if (response.status === 'success') {
                        var data = response.body;
                        console.log(data)

                        var formattedData = data.map(function(user) {
                            return {
                                id: user.id,
                                username: user.username,
                                text: user.name,
                                email: user.email,
                                phone: user.phone,

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
                            console.log(`name ${selectedUser.text}`)

                            // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                            // $('#user').val(selectedUser.username);
                            $('#username').val(selectedUser.username);
                            $('#inputEmail').val(selectedUser.email);
                            $('#name').val(selectedUser.text);
                            $('#phone_number').val(selectedUser.phone);

                            // var fullName = selectedUser.first_name + ' ' + selectedUser
                            //     .last_name;
                            // $('#name').val(fullName);
                        });

                        // Événement de sélection d'utilisateur
                        $('#manager').on('select2:select', function(e) {
                            var selectedUser = e.params.data;
                            // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                            // $('#user').val(selectedUser.username);
                            $('#username_manager').val(selectedUser.username);
                            $('#inputEmail_manager').val(selectedUser.email);
                            $('#name_manager').val(selectedUser.text);
                            $('#phone_number_manager').val(selectedUser.phone);

                            // var fullName = selectedUser.first_name + ' ' + selectedUser
                            //     .last_name;
                            // $('#name').val(name);
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
        // $('#comite').on('click', function() {
        //     if ($(this).is(':checked')) {
        //         $('#jalonPv').removeAttr('required')
        //         $('#depot').css('display','none')
        //         $('#comiteAlerte').text('faire passer ce jalon au comité')
        //         console.log('is checked')
        //     }
        //     else{
        //         // $('#jalonPv').ttr('required')
        //         $('#depot').css('display','block')
        //         $('#comiteAlerte').text('cloturé ce jalon')
        //     }

        // })

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
            bsCustomFileInput.init();
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

    <script>
        function supprimer(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));
            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('demande') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";
        }
    </script>
@endpush
