<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Créer une Demande</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('demandeJalon.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card-body">
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="category">Catégorie <span class="text-danger">*</span></label>
                        <select name="category" id="category" class="form-control" style="width: 100%;" required>
                            <option  value="">Sélectionnez une catégorie</option>
                            @foreach ($categoryDemandes as $categoryDemande)
                            <option id="cat_{{$categoryDemande->id}}" value="{{$categoryDemande->id}}">{{$categoryDemande->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="demande">Demande <span class="text-danger">*</span></label>
                        <select name="demande" id="demande" class="form-control" style="width: 100%;" required>
                            <option value="" class="item">Sélectionnez une demande</option>
                            @foreach ($allDemandes as $oneDemande)
                            <option class="item_demande" value="{{$oneDemande->id}}" data-cat="cat_{{$oneDemande->category_demande_id}}">{{$oneDemande->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Délais <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="deadLine" class="form-control" min="1" required>
                            <select class="form-control" name="deadline_unit">
                                <option value="days">Jours</option>
                                <option value="hours">Heures</option>
                                <option value="minutes">Minutes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                            <label for="role" class="col-sm-12 col-form-label">Rôle</label>
                            <select class="form-control select2 col-sm-12" style="width: 100%;" aria-placeholder="role"
                                name="role" id="role">
                                <option value="Contributeur">Contributeur</option>
                                <option value="Steam">Steam</option>
                                <option value="Validateur">Validateur</option>
                            </select>
                    </div>
                </div>
                <input type="hidden" name="date_prevue" id="date_prevue">
                <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}">
                <div class="form-group">
                    
                        <label for="exampleInputFile">Model</label>
                        <div class="custom-file">
                            <input type="file" class="form-control" id="" name="file">
                        </div>
                    
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-form-label">Contributeur</label>
                    <select class="form-control select2 col-sm-10" style="width: 100%;"
                    aria-placeholder="nom du contributeur" name="contributeur" id="user">
                    <option></option>
                    <input hidden type="hidden" class="form-control hidden" name="username" id="username">
                    <input hidden type="hidden" class="form-control hidden" name="phone_number" id="phone_number">
                    <input hidden type="email" class="form-control hidden" id="inputEmail" placeholder="email" name="email">
                    <input hidden type="text" class="form-control hidden" id="name" placeholder="Nom & prenom"
                    name="nom">
                   
                </select>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-form-label">Line manager</label>
                    <select class="form-control select2 col-sm-10" style="width: 100%;"
                    aria-placeholder="nom du contributeur" name="manager" id="manager">
                    <option></option>
                    <input hidden type="hidden" class="form-control hidden" name="username_manager" id="username_manager">
                    <input hidden type="hidden" class="form-control hidden" name="phone_number_manager" id="phone_number_manager">
                    <input hidden type="email" class="form-control hidden" id="inputEmail_manager" placeholder="email" name="email_manager">
                    <input hidden type="text" class="form-control hidden" id="name_manager" placeholder="Nom & prenom"
                    name="nom_manager">
                    
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="project_optionttm_jalon_id" value="{{$pivotId}}">
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="description">Description  <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="5" placeholder="Enter ..." required></textarea>
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
