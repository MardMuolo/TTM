@extends('layouts.app')
@section('title')
    Création
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item"><a href="#">Créer</a></li>
@endsection

@section('content')
    @if ($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul>
                    <li>{{ $error }}</li>
                </ul>
            </div>
        @endforeach
    @endif
    <div class="card card-primary card-outline p-4">
        <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-10 container my-4">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Création du projet</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="bs-stepper">
                            <div class="bs-stepper-header" role="tablist">
                                <!-- your steps here -->
                                <div class="step" data-target="#logins-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                        id="logins-part-trigger">
                                        <span class="bs-stepper-circle bg-black text-orange ">1</span>
                                        <span class="bs-stepper-label">Information</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#information-part">
                                    <button type="button" class="step-trigger" role="tab"
                                        aria-controls="information-part" id="information-part-trigger">
                                        <span class="bs-stepper-circle bg-black text-orange">2</span>
                                        <span class="bs-stepper-label">Description</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#complexity-part">
                                    <button type="button" class="step-trigger" role="tab"
                                        aria-controls="complexity-part" id="complexity-part-trigger">
                                        <span class="bs-stepper-circle bg-black text-orange">3</span>
                                        <span class="bs-stepper-label">Complexité</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <!-- your steps content here -->
                                <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                    <div class="form-group">
                                        <label class="text-black" for="exampleInputEmail1">Nom <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            placeholder="nom du projet" name="name" @required(true)>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-black" for="exampleInputPassword1">Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%;" aria-placeholder="type de projet"
                                            name="type">
                                            <option>Produit Offre ou Service</option>
                                            <option>Application Outil ou Infra</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-black" for="exampleInputFile">Cible <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            placeholder=" cible" name="target" @required(true)>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-black" for="exampleInputFile">Début <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" name="startDate"
                                            @required(true)>
                                    </div>
                                    <a class="btn btn-primary bg-black text-orange" onclick="stepper.next()">Suivant</a>
                                </div>
                                {{-- fin de la partie 1 --}}
                                <div id="information-part" class="content" role="tabpanel"
                                    aria-labelledby="information-part-trigger">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="text-black" for="exampleInputFile " class="text-black">Sponsor
                                                <span class="text-danger">*</span></label>
                                            <div class="form-group">
                                                <select class="select2" data-placeholder="Any" style="width: 100%;"
                                                    name="sponsor" id="user">
                                                    <option value=""></option>
                                                    <input type="hidden" id="sponsor_username" name="sponsor_username">
                                                    <input type="hidden" id="sponsor_Email" name="sponsor_Email">
                                                    <input type="hidden" id="sponsor_name" name="sponsor_name">
                                                    <input type="hidden" id="sponsor_phone_number"
                                                        name="sponsor_phone_number">
                                                    {{-- @forelse ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @empty
                                                        <option>Aucun utilisateur trouvé</option>
                                                    @endforelse --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-black" for="exampleInputFile">Coût du projet <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="exampleInputEmail1"
                                                placeholder=" coût" name="coast" @required(true)>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-black">Descriptiion <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="3" placeholder="Description" name="description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-black" for="exampleInputFile">Cahier des charges ou
                                                EBM<span class="text-black-50">(optionel)</span></label>
                                            <div class="input-group border rounded text-black z-99">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-fle-input" id="doc"
                                                        name="file[]" multiple>
                                                    {{-- <label class="text-black" class="custom-file-label"
                                                        for="doc">fichier</label> --}}
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <a class="btn btn-primary bg-black text-orange"
                                        onclick="stepper.previous()">Précedent</a>
                                    <a class="btn btn-primary bg-black text-orange" onclick="stepper.next()">Suivant</a>
                                </div>
                                {{-- fin de la partie 2 --}}
                                <div id="complexity-part" class="content" role="tabpanel"
                                    aria-labelledby="complexity-part-trigger">
                                    @foreach ($complexity_items as $item)
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="text-black">{{ $item->name }}</label>
                                                <select class="form-control" name="score[]" required
                                                    onchange="updateTargetId(this, {{ $item->id }})">
                                                    <option disabled selected>null</option>
                                                    @foreach ($item->complexityTargets as $target)
                                                        <option value="{{ $target->value }}"
                                                            data-target-id="{{ $target->id }}">{{ $target->value }} -
                                                            {{ $target->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span dir="ltr" style="width: 100%;">
                                                    <span class="dropdown-wrapper" aria-hidden="true"></span>
                                                </span>
                                                <input type="hidden" name="target_id[]"
                                                    id="target_id_{{ $item->id }}" value="{{ $target->id }}">
                                                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                                <!-- Ajout du champ hidden pour enregistrer l'ID de l'item -->
                                            </div>
                                        </div>
                                    @endforeach
                                    <a class="btn btn-primary bg-black text-orange"
                                        onclick="stepper.previous()">Précedent</a>
                                    <button class="btn btn-success" id="test" type="submit">Soumettre</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </form>
    </div>
@endsection
@push('third_party_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/bs-stepper/js/bs-stepper.min.js?commonjs-entry') }}">
    </script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js?commonjs-entry') }}">
    </script>
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css');
    @vite('node_modules/admin-lte/plugins/bs-stepper/css/bs-stepper.min.css');
@endpush
@push('page_scripts')
    <script type="module">
        $(document).ready(function() {
            // $('[data-mask]').inputmask()
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
                            $('#sponsor_username').val(selectedUser.username);
                            $('#sponsor_Email').val(selectedUser.email);
                            $('#sponsor_name').val(selectedUser.text);
                            $('#sponsor_phone_number').val(selectedUser.phone);

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
    <script type="module">
        function updateTargetId(selectElement, itemId) {
            var targetIdInput = document.getElementById("target_id_" + itemId);
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var targetId = selectedOption.getAttribute("data-target-id");
            targetIdInput.value = targetId;
        }

        // Handle BS-Stepper
        document.addEventListener('DOMContentLoaded', function(e) {
            e.preventDefault();
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        //handle Select2 field
        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2()
        });
    </script>
@endpush
