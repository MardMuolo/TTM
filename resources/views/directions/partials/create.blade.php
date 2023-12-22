<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajouter une direction</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('directions.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Nom de la direction</label>
                        <input type="text" name="name" class="form-control" placeholder="Nom  de la direction" required>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="input-group mb-3">
                        <label for="directeur">Directeur</label>
                        <select name="user" class="form-control select2 w-100" id="directeur" style="width: 100%;">
                           <option value=""></option>
                           <input type="hidden" id="username" name="username">
                           <input type="hidden" id="Email" name="Email">
                           <input type="hidden" id="name" name="user_name">
                           <input type="hidden" id="phone_number" name="phone_number">
                        </select>
                    </div>
                </div>
                {{-- <div class="col-xm-6">
                    <div class="form-group">
                        <label for="inputEmail">Directeur</label>
                        <input type="checkbox" class="form-control" id="inputEmail" placeholder="email" name="email">
                        
                    </div>
                </div> --}}
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