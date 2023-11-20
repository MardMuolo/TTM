
<div class="modal fade" id="edit_target_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleEditTarget"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="POST" id="editTargetForm">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="name">Target</label>
                                <input type="text" id="target" name="name" value="" class="form-control" placeholder="Ecrivez le target" required>
                            
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="description">Score</label>
                                <input type="number" name="value" id="score" value="" min=0 class="form-control" placeholder="Score du target" required>
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