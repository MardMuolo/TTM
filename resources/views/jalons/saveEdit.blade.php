@foreach ($demandes as $item)
    @php
        $deadlineCombinee = $item->deadLine;
        $deadlineParts = explode(' ', $deadlineCombinee);
        $ancienDeadLine = $deadlineParts[0];
        $ancienneUnite = $deadlineParts[1];
    @endphp
    <aside class="control-sidebar control-sidebar-light" style="top: 57px; height: 568px; display: block; width: 50%;"
        id="edit-{{ $item->id }}-edit">
        <div class="p-3 control-sidebar-content os-host os-theme-light os-host-resize-disabled os-host-transition os-host-overflow os-host-overflow-y"
            style="height: 568px;">
            <div class="os-padding">
                <div class="os-viewport">
                    <div style="position: absolute; top: 0; left: 0;">
                        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                            data-target="#edit-{{ $item->id }}-edit" href="#edit-{{ $item->id }}-edit"
                            role="button">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <div class="card card-default m-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Modifier la demande
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Form for editing the demand -->
                            <form method="POST" action="{{ route('demandeJalon.update', ['demandeJalon' => $item->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="category_edit">Catégorie <span class="text-danger">*</span></label>
                                            <select name="category" id="category_edit" class="form-control" style="width: 100%;" required>
                                                <option  value="">Sélectionnez une catégorie</option>
                                                @foreach ($categoryDemandes as $categoryDemande)
                                                <option id="cat_edit_{{$categoryDemande->id}}" @if ($item->demande->category_demande_id == $categoryDemande->id)
                                                    selected
                                                @endif value="{{$categoryDemande->id}}">{{$categoryDemande->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="demande">Demande <span class="text-danger">*</span></label>
                                            <select name="demande" id="demande_edit" class="form-control" style="width: 100%;" required>
                                                <option value="" class="item">Sélectionnez une demande</option>
                                                @foreach ($allDemandes as $oneDemande)
                                                <option class="item_demande_edit" value="{{$oneDemande->id}}" @if ($item->demande_id == $oneDemande->id)
                                                    selected
                                                @endif data-cat="cat_edit_{{$oneDemande->category_demande_id}}">{{$oneDemande->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-form-label">Contributeur</label>
                                            <select class="form-control user_edit select2 col-sm-12" style="width: 100%;"
                                            aria-placeholder="nom du contributeur" name="contributeur" id="user_edit">
                                            <option value=""></option>
                                            {{-- <option value="{{($item->contributeur)}}">{{App\Models\User::find($item->contributeur)->username}}</option> --}}
                                            <input hidden type="hidden" class="form-control hidden" name="username" id="username">
                                            <input hidden type="email" class="form-control hidden" id="inputEmail" placeholder="email" name="email">
                                            <input hidden type="text" class="form-control hidden" id="name" placeholder="Nom & prenom"
                                            name="nom">
                                           
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-form-label">Line manager</label>
                                            <select class="form-control manager_edit select2 col-sm-12" style="width: 100%;"
                                            aria-placeholder="nom du contributeur" name="manager" id="manager_edit">
                                            <option></option>
                                            <input hidden type="hidden" class="form-control hidden" name="username_manager" id="username_manager">
                                            <input hidden type="email" class="form-control hidden" id="inputEmail_manager" placeholder="email" name="email_manager">
                                            <input hidden type="text" class="form-control hidden" id="name_manager" placeholder="Nom & prenom"
                                            name="nom_manager">
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="name">Délais <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" name="deadLine" class="form-control"
                                                    value="{{ $ancienDeadLine }}">
                                                <select class="form-control" name="deadline_unit">
                                                    <option value="days"
                                                        {{ $ancienneUnite == 'days' ? 'selected' : '' }}>Jours</option>
                                                    <option value="hours"
                                                        {{ $ancienneUnite == 'hours' ? 'selected' : '' }}>Heures
                                                    </option>
                                                    <option value="minutes"
                                                        {{ $ancienneUnite == 'minutes' ? 'selected' : '' }}>Minutes
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Modèle </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="file">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            @if ($item->pathTask)
                                                <span class="text-muted">Fichier actuel : {{ $item->pathTask }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="project_optionttm_jalon_id"
                                            value="{{ $pivotId }}">
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="description">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description" rows="5" placeholder="Enter ..." required>{{ $item->description }}</textarea>
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
        </div>
    </aside>
@endforeach

<script>
// Sélection de tous les éléments avec la classe "item_demande"
var elementsEdit = document.querySelectorAll(".item_demande_edit");
    console.log(elementsEdit.length);
// Masquer tous les éléments "item_demande" par défaut
// for (var i = 0; i < elementsEdit.length; i++) {
//     elementsEdit[i].style.display = 'block';
// }
var contributeurs = document.querySelectorAll('#user_edit > option')
// Sélection de la liste déroulante de catégories

for (var i = 0; i < contributeurs.length; i++) {
    alert(contributeurs[i].value)
}
var categorySelectEdit = document.getElementById('category_edit');

// Ajout d'un écouteur d'événements pour le changement de sélection dans la liste déroulante de catégories
categorySelectEdit.addEventListener('change', function() {
    // Récupération de l'ID de catégorie sélectionné
    var categoryIdEdit = categorySelectEdit.options[categorySelectEdit.selectedIndex].getAttribute('id');

    // Masquer tous les éléments "item_demande"
    for (var i = 0; i < elementsEdit.length; i++) {
        elementsEdit[i].style.display = 'none';
    }

    // Afficher les éléments "item_demande" correspondant à la catégorie sélectionnée
    for (var i = 0; i < elementsEdit.length; i++) {
        if (categoryIdEdit === elementsEdit[i].getAttribute('data-cat')) {
            elementsEdit[i].style.display = 'block';
        }
    }

});

var demandeSelect = document.getElementById('demande_edit');

// Récupération de l'option par défaut de la liste déroulante de demandes
var defaultOption = demandeSelect.options[0];

// Ajout d'un écouteur d'événements pour le changement de sélection dans la liste déroulante de catégories
categorySelectEdit.addEventListener('change', function() {
    // Récupération de l'ID de catégorie sélectionné
    var categoryIdEdit = categorySelectEdit.options[categorySelectEdit.selectedIndex].getAttribute('id');

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

    