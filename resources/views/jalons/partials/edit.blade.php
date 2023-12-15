<div class="modal fade edit-form" id="edit-{{ $jalon->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="">
                    <div class="card-header">
                        <h3 class="card-title">Modification du Jalon</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('jalons.update', $jalon->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label> Désignation <span class="text-red">*</span></label>
                                        <input type="text" class="form-control"
                                            value="{{ $jalon->designation }}" name="designation">
                                    </div>
                                </div>
                            </div>
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
    </div>
</div>
