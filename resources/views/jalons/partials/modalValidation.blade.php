{{-- directeur modale --}}
<div class="modal fade" id="validate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Validation du livrable </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <h4>Votre Avis</h4>
                                <select class="custom-select form-control-border" id="exampleSelectBorder" name="Avis">
                                    <option value="Valider">Valider</option>
                                    <option value="A Corriger">A Corriger</option>
                                    <option value="Rejeter">Rejeter</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <h4>Observation</h4>
                                <textarea class="form-control" rows="3" placeholder="Entrer ..." name="description"></textarea>
                            </div>
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
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>