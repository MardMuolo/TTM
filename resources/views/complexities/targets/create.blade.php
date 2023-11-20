<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajouter un target pour l'item {{ $complexityItem->name }}</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('ComplexityTarget.store') }}" method="POST">
            @csrf
            
            <div class="card-body">
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Target</label>
                        <input type="text" name="name" class="form-control" placeholder="Ecrivez le target" required>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="description">Score</label>
                        <input type="number" name="value" min=0 class="form-control" placeholder="Score du target" required>
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{ $complexityItem->id }}" name="item">
            <div class="card-footer">
                <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                  </button>
            </div>
        </form>
    @endsection
</div>