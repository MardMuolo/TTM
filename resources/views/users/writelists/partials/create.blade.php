<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajout d'un nouvel Utilisateur</h4>
    @endsection
    @section('modal-content')
        <form method="POST" action="{{ route('writelist.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Nom d'utilisateur<span class="text-red">*</span></label>
                            <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="username"
                                required>
                        </div>
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
