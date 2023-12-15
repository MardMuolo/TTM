@extends('layouts.modal')

@section('id_modal')
    id="create_modal"
@endsection

@section('modal-title')
    <h4 class="modal-title">Créer un Contributeur</h4>
@endsection
@section('class-modal')
    modal-lg
@endsection

@section('modal-content')
    <div class="col-lg-12">
        <form class="form-horizontal" action="{{ route('membres.store', $project->id) }}" method="POST">
            @csrf
            <div class=" row col-lg-12">
                <div class="col-lg-7">
                    <div class="form-group row">
                        <label for="user" class="col-sm-5 col-form-label">Nom d'utilisateur</label>
                        <select class="form-control select2 col-sm-10" style="width: 100%;"
                            aria-placeholder="nom d'utilisateur" name="user" id="user">
                            <option></option>
                        </select>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" name="username" id="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-5 col-form-label">Nom & Prenom</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="Nom & prenom"
                                name="noms">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-5 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" placeholder="email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-5 col-form-label">Téléphone</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" id="inputTel" placeholder="tel..." name="phone">
                        </div>
                        <input type="hidden" class="form-control" id="inputProject" value="{{ $project->id }}"
                            placeholder="email" name="project">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group row">
                        <label for="role" class="col-sm-5 col-form-label">Rôle</label>
                        <select class="form-control select2 col-sm-10" style="width: 100%;" aria-placeholder="role"
                            name="role" id="role">
                            <option value="Contributeur">Contributeur</option>
                            <option value="Steam">Steam</option>
                            <option value="Validateur">Validateur</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="manager" class="col-sm-5 col-form-label">Manager</label>
                        <input type="text" class="form-control" name="manager" id="manager">
                    </div>
                    <div class="form-group row">
                        <label for="direction" class="col-sm-5 col-form-label">Direction</label>
                        <select class="form-control select2 col-sm-10" style="width: 100%;" aria-placeholder="direction"
                            name="direction" id="directionName">
                            @forelse ($directions as $direction)
                                <option value="{{ $direction->id }}">{{ $direction->name }}</option>
                            @empty
                                <option>Aucune direction</option>
                            @endforelse
                        </select>
                        <input type="hidden" class="form-control" id="directionId" name="directionId">

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

    <!-- Inclure jQuery -->
@endsection
