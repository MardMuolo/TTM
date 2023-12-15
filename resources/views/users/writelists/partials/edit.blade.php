<div class="modal fade edit-form" id="edit-{{ $writelist->username }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modification l'utilisateur</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('writelist.update', $writelist->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nom d'utilisateur <span class="text-red">*</span></label>
                                <input type="text" class="form-control" value="{{ $writelist->username }}"
                                    name="nom">
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
