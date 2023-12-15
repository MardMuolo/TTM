<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleEdit"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="POST" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="name">Code-name</label>
                                <input type="text" name="code_name" class="form-control" placeholder="Code-name"
                                    required id="code_name">
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="name">Type</label>
                                <input type="text" name="type" class="form-control" placeholder="Type de message"
                                    required id="type">
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="name">Objet</label>
                                <input type="text" name="object" class="form-control" placeholder="Objet du message"
                                    required id="object">
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="body">Contenu</label>
                                <textarea class="form-control" rows="4" placeholder="Enter ..." name="body" id="body"></textarea>
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">

                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" name="action" id="action" class="me-5">
                                    <label for="action">Action</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" name="attachement" id="attachement" class="me-5">
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

            </div>

        </div>

    </div>
</div>
