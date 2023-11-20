<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajout Option Ttm</h4>
    @endsection
    @section('modal-content')
    <form method="POST" action="{{ route('optionsttm.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Nom <span class="text-red">*</span></label>
                            <input type="text" class="form-control" placeholder="Nom de l'option Ttm"
                                name="nom" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Jalon</label>
                            <select class="form-control form-control" id="select-multiple" name="jalons[]" multiple>
                                @foreach ($jalons as $jalon)
                                    <option value="{{$jalon->id}}"> {{ $jalon->designation }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- textarea -->
                        <div class="form-group">
                            <label>Min compléxité <span class="text-red">*</span></label>
                            <input class="form-control" type="number" min="0"
                                name="minComplexite" id="min" placeholder="Entrer un nombre ..."
                                required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Max complexité <span class="text-red">*</span></label>
                            <input class="form-control" name="maxComplexite" id="max"
                                type="number" min="updateMin()" placeholder="Entrer un nombre ..."
                                required>
                        </div>
                    </div>
                    <span id="erreurMessage1" class="text-red"></span>
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