<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajouter un message</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('messagesMails.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Code-name</label>
                        <input type="text" name="code_name" class="form-control" placeholder="Code-name" required>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Type</label>
                        <input type="text" name="type" class="form-control" placeholder="Type de message" required>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Objet</label>
                        <input type="text" name="object" class="form-control" placeholder="Objet du message" required>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="body">Contenu</label>
                        <textarea class="form-control" rows="4" placeholder="Enter ..." name="body"></textarea>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">

                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checkboxPrimary1" name="action" class="me-5">
                            <label for="action">Action</label>
                        </div>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checkboxPrimary1" name="attachement" class="me-5">
                            <label for="attachement">Attaches</label>
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
