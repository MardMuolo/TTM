<div>
    @extends('layouts.modal')

    @section('id_modal')
        id="create_modal"
    @endsection

    @section('modal-title')
        <h4 class="modal-title">Ajouter une metier</h4>
    @endsection
    @section('modal-content')
        <form class="form-horizontal" action="{{ route('metiers.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="name">Nom du metier</label>
                        <input type="text" name="name" class="form-control" placeholder="Nom  de la metier" required>
                    </div>
                    <div class="form-group">
                        <label for="direction" class="col-lg-8">Direction</label>
                        <select name="direction" style="width: 75%" class="form-control" id="direction">
                            @forelse ($directions as $direction)
                                <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                            @empty
                                <option value="">Aucune direction</option>
                            @endforelse

                        </select>
                    </div>
                </div>
                <hr>
                <div class="col-xm-6">
                    <div class="form-group">
                        <label for="directeur">Manager</label>
                        <select name="directeur" style="width: 75%" class="form-control" id="user">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="isManager" id="isManager">
                        <label class="text-black-50 fw-normal">Est-ce LineManager?</label>
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
