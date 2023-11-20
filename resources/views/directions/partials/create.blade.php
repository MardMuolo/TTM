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
                        <select name="user" class="form-control select2 w-100" id="directeur">
                            @forelse ($users as $user)
                                <option value="{{$user->email}}">{{$user->first_name.' '.$user->last_name}}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="inputEmail"></label>
                        <input type="hidden" class="form-control" id="inputEmail" placeholder="email" name="email">
                        
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