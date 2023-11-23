<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection
    @section('name')
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Dépôt du livrable</h4>
    @endsection
    @section('modal-content')
        <form action="{{ route('livrables.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Titre</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Entrer le titre"
                        name="nom" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Document</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="fichier" required>
                            <label class="custom-file-label" for="exampleInputFile">choisir le
                                fichier</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" value="{{ $demande->id }}" hidden name="demande_jalon_id">
                </div>
                <div class="form-group">
                    <label>Observation</label>
                    <textarea class="form-control" rows="3" placeholder="Entrer ..." name="description"></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">J'ai vérifié le document avant de
                        l'envoyer</label>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
            </div>
        </form>
    @endsection
</div>
