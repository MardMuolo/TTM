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
                                <label for="name">Libellé</label>
                                <input type="text" name="name" value="" class="form-control" required id="libelle">
                            
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" rows="5" id="description"></textarea>
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