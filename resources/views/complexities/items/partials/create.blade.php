<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection
    @section('name')
        
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajouter un Item</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('ComplexityItem.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Libellé</label>
                        <input type="text" name="name" class="form-control" placeholder="Intitulé du point de complexité" required>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="5" placeholder="Enter ..."></textarea>
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