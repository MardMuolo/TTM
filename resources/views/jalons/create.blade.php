<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Créer une Demande</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('demandeJalon.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body p-0">
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step" data-target="#information-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part"
                                id="information-part-trigger">
                                <span class="bs-stepper-circle bg-orange text-black">1</span>
                                <span class="bs-stepper-label text-black">Contributeur</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#logins-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                id="logins-part-trigger">
                                <span class="bs-stepper-circle bg-orange text-black">2</span>
                                <span class="bs-stepper-label text-black">Demande</span>
                            </button>
                        </div>

                    </div>
                    <div class="bs-stepper-content">


                        <div id="information-part" class="content" role="tabpanel"
                            aria-labelledby="information-part-trigger">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label text-black">Contributeur</label>
                                <select class="form-control select2 col-sm-10" style="width: 100%;"
                                    aria-placeholder="nom du contributeur" name="contributeur" id="user">
                                    <option></option>
                                    <input hidden type="hidden" class="form-control hidden" name="username" id="username">
                                    <input hidden type="hidden" class="form-control hidden" name="phone_number"
                                        id="phone_number">
                                    <input hidden type="email" class="form-control hidden" id="inputEmail"
                                        placeholder="email" name="email">
                                    <input hidden type="text" class="form-control hidden" id="name"
                                        placeholder="Nom & prenom" name="nom">

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label text-black">Line manager</label>
                                <select class="form-control select2 col-sm-10" style="width: 100%;"
                                    aria-placeholder="nom du contributeur" name="manager" id="manager">
                                    <option></option>
                                    <input hidden type="hidden" class="form-control hidden" name="username_manager"
                                        id="username_manager">
                                    <input hidden type="hidden" class="form-control hidden" name="phone_number_manager"
                                        id="phone_number_manager">
                                    <input hidden type="email" class="form-control hidden" id="inputEmail_manager"
                                        placeholder="email" name="email_manager">
                                    <input hidden type="text" class="form-control hidden" id="name_manager"
                                        placeholder="Nom & prenom" name="nom_manager">

                                </select>
                            </div>
                            <div class="col-xm-6">
                                <div class="form-group">
                                    <label for="role" class="col-sm-12 col-form-label text-black">Rôle</label>
                                    <select class="form-control  col-sm-12" style="width: 100%;" aria-placeholder="role"
                                        name="role" id="role">
                                        <option value="Contributeur">Contributeur</option>
                                        <option value="Stream">Stream</option>
                                        <option value="Validateur">Validateur</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xm-6">
                                <div class="form-group" id="delais">
                                    <label for="name" class="col-sm-12 col-form-label text-black">Délais <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="deadLine" class="form-control" min="1"
                                            required>
                                        <select class="form-control" name="deadline_unit">
                                            <option value="days">Jours</option>
                                            <option value="hours">Heures</option>
                                            <option value="minutes">Minutes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary bg-black text-orange" onclick="stepper.next()">Suivant</a>
                        </div>
                        {{-- fin de la partie 1 --}}

                        <!-- your steps content here -->
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="col-xm-6">
                                <div class="form-group">
                                    <label for="category" class="col-sm-12 col-form-label text-black">Catégorie <span
                                            class="text-danger">*</span></label>
                                            <span id="text_categorie" class="text-sencandary px-4"></span>
                                    <select name="category" id="category" class="form-control" style="width: 100%;"
                                        required>
                                        <option value="">Sélectionnez une catégorie</option>
                                        @foreach ($categoryDemandes as $categoryDemande)
                                            <option id="cat_{{ $categoryDemande->id }}"
                                                value="{{ $categoryDemande->id }}">
                                                {{ $categoryDemande->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xm-6" id="demandes">
                                <div class="form-group">
                                    <label for="demande" class="col-sm-12 col-form-label text-black">Demande <span
                                            class="text-danger">*</span></label>
                                            <span id="text_demande" class="text-sencandary px-4"></span>
                                    <select name="demande" id="demande" class="form-control" style="width: 100%;"
                                        required>
                                        <option value="" class="item">Sélectionnez une demande</option>
                                        @foreach ($allDemandes as $oneDemande)
                                            <option class="item_demande" value="{{ $oneDemande->id }}"
                                                data-cat="cat_{{ $oneDemande->category_demande_id }}">
                                                {{ $oneDemande->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="project_optionttm_jalon_id" value="{{ $pivotId }}">
                                <input type="hidden" name="date_prevue" id="date_prevue">
                                <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}">
                            </div>
                            <div class="form-group">

                                <label for="exampleInputFile" class="col-sm-12 col-form-label text-black">Model</label>
                                <span id="text_model" class="text-sencandary px-4"></span>
                                <div class="custom-file">
                                    <input type="file" class="form-control" id="model" name="file">
                                </div>

                            </div>
                            <div class="col-xm-6">
                                <div class="form-group">
                                    <label for="description" class="col-sm-12 col-form-label text-black">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" rows="5" placeholder="Enter ..." required></textarea>
                                </div>
                            </div>
                            <a class="btn btn-primary bg-black text-orange" onclick="stepper.previous()">Précedent</a>
                            <button class="btn btn-success " id="test" type="submit">Soumettre</button>

                        </div>
                        {{-- fin de la partie 2 --}}

                    </div>
                </div>
                <!-- /.card-body -->

            </div>
        </form>
    @endsection
</div>
@section('scripts')
    <script>
        // Sélection de tous les éléments avec la classe "item_demande"
        var elements = document.querySelectorAll(".item_demande");

        // Masquer tous les éléments "item_demande" par défaut
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.display = 'none';
        }

        // Sélection de la liste déroulante de catégories
        var categorySelect = document.getElementById('category');

        // Ajout d'un écouteur d'événements pour le changement de sélection dans la liste déroulante de catégories
        categorySelect.addEventListener('change', function() {
            // Récupération de l'ID de catégorie sélectionné
            var categoryId = categorySelect.options[categorySelect.selectedIndex].getAttribute('id');

            // Masquer tous les éléments "item_demande"
            for (var i = 0; i < elements.length; i++) {
                elements[i].style.display = 'none';
            }

            // Afficher les éléments "item_demande" correspondant à la catégorie sélectionnée
            for (var i = 0; i < elements.length; i++) {
                if (categoryId === elements[i].getAttribute('data-cat')) {
                    elements[i].style.display = 'block';
                }
            }

        });

        var demandeSelect = document.getElementById('demande');

        // Récupération de l'option par défaut de la liste déroulante de demandes
        var defaultOption = demandeSelect.options[0];

        // Ajout d'un écouteur d'événements pour le changement de sélection dans la liste déroulante de catégories
        categorySelect.addEventListener('change', function() {
            // Récupération de l'ID de catégorie sélectionné
            var categoryId = categorySelect.options[categorySelect.selectedIndex].getAttribute('id');

            // Réinitialiser la liste déroulante de demandes à la valeur par défaut
            demandeSelect.selectedIndex = 0;

            // Récupérer l'option sélectionnée dans la liste déroulante de demandes après la réinitialisation
            var selectedOption = demandeSelect.selectedOptions[0];

            // Modifier le texte de l'option sélectionnée si elle n'est pas l'option par défaut
            if (selectedOption !== defaultOption) {
                selectedOption.textContent = 'Sélectionner une demande';
            }
        });
    </script>
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
    <script>
        $('#role').on('change', function(e) {
            if (e.target.value === "Validateur" || e.target.value === "Stream") {
                $('#demande').css("display", "none").removeAttr('required')
                $('#category').css("display", "none").removeAttr('required')
                $('#delais').css("display", "none").removeAttr('required')
                $('#model').css("display", "none").removeAttr('required')
                $('#text_model').text('N/A')
                $('#text_demande').text('N/A')
                $('#text_categorie').text('N/A')
                console.log("ok")
            }else{
                $('#demande').css("display", "initial").attr('required')
                $('#category').css("display", "initial").attr('required')
                $('#delais').css("display", "initial").css("padding-bottom","7px").attr('required')
                $('#model').css("display", "initial").attr('required')
                $('#text_model').text('')
                $('#text_demande').text('')
                $('#text_categorie').text('')
            }

        })
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
@endpush
