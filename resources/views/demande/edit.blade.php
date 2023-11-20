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
                                            <label for="category">Catégorie <span class="text-danger">*</span></label>
                                            <select name="category" id="category" class="form-control" style="width: 100%;" required>
                                                @foreach ($categoryDemandes as $categoryDemande)
                                                <option id="cat_{{$categoryDemande->id}}" value="{{$categoryDemande->id}}"
                                                    {{ $item->demande->category_demande_id == $categoryDemande->id ? 'selected' : '' }}>
                                                    {{$categoryDemande->title}}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="demande">Titre de la demande <span class="text-danger">*</span></label>
                                            <select name="demande" id="demande" class="form-control" style="width: 100%;" required>
                                                @foreach ($allDemandes as $oneDemande)
                                                <option class="item_demande" value="{{$oneDemande->id}}"
                                                    data-cat="cat_{{$oneDemande->category_demande_id}}"
                                                    {{ $item->demande->id == $oneDemande->id ? 'selected' : '' }}>
                                                    {{$oneDemande->title}}
                                                </option>
                                            @endforeach
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
                                        <label for="inputEmail3" class="col-form-label">Contributeur</label>
                                        <select class="form-control select2 col-sm-9" style="width: 100%;"
                                            aria-placeholder="type de projet" name="contributeur">

                                            @forelse ($users as $user)
                                                <option value="{{ $user->name }}"
                                                    {{ $item->contributeur == $user->name ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @empty
                                                <option>Aucune suggestion</option>
                                            @endforelse

                                        </select>
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
    categorySelect.addEventListener('change', function(i) {
        // Récupération de l'ID de catégorie sélectionné
        var categoryId = categorySelect.options[categorySelect.options.selectedIndex].getAttribute('id');
        
        // Masquer tous les éléments "item_demande"
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.display = 'none';
        }
        
        // Afficher les éléments "item_demande" correspondant à la catégorie sélectionnée
        for (var i = 0; i < elements.length; i++) {
            if(categoryId == elements[i].getAttribute('data-cat')) {
                elements[i].style.display = 'block';
            }
        }
        
        // Sélection de l'élément de demande par défaut
        var element = document.querySelector(".item_demande");
        elementhidden = element.getAttribute('data-cat');
        
        // Masquer l'élément de demande par défaut si sa catégorie ne correspond pas à la catégorie sélectionnée
        if (element.getAttribute('data-cat') !== categoryId) {
            element.style.visible = 'hidden';
        }
    });
</script>
@endsection
    