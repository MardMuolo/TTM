<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="new_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Créer une Demande</h4>
    @endsection
    @section('modal-content')
    <form action="{{ route('demande.store') }}" method="POST">
        @csrf
    
        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="category_demande_id">Catégorie de la demande :</label>
            <select name="category_demande_id" id="category_demande_id" class="form-control" required>
                <option value="">Sélectionner une catégorie</option>
                @foreach ($categoriesDemandes as $categoryDemande)
                    <option value="{{ $categoryDemande->id }}">{{ $categoryDemande->title }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="jalon_id">Jalon :</label>
            <select name="jalon_id" id="jalon_id" class="form-control" required>
                <option value="">Sélectionner un jalon</option>
                @foreach ($jalons as $jalon)
                    <option value="{{ $jalon->id }}">{{ $jalon->designation }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i>
          </button>
    </form>
    @endsection
</div>