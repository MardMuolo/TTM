<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la demande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('demande.update', $demande->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Titre :</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $demande->title }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category_demande_id">Catégorie de la demande :</label>
                        <select name="category_demande_id" id="category_demande_id" class="form-control" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach ($categoriesDemandes as $categoryDemande)
                                <option value="{{ $categoryDemande->id }}" {{ $demande->category_demande_id == $categoryDemande->id ? 'selected' : '' }}>
                                    {{ $categoryDemande->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jalon_id">Jalon :</label>
                        <select name="jalon_id" id="jalon_id" class="form-control" required>
                            <option value="">Sélectionner un jalon</option>
                            @foreach ($jalons as $jalon)
                                <option value="{{ $jalon->id }}" {{ $demande->jalon_id == $jalon->id ? 'selected' : '' }}>
                                    {{ $jalon->designation }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>