<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="">
                    <div class="card-header">
                        <h3 class="card-title">Jalons</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('jalons.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Designation <span class="text-red">*</span></label>
                                        <input type="text" class="form-control" placeholder="Jalon T0"
                                            name="designation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="">
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