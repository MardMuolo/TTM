@foreach ($members as $item)
    <div class="modal fade edit-form col-lg-12" id="edit-{{ $item->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header callout callout-success">
                    <h3 class="card-light">Modifier membre "{{ $item->name }}"</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" light">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="">
                                <form class="form-horizontal" action="#" method="POST">
                                    @csrf
                                    <div class=" row col-lg-12">
                                        <div class="col-lg-7">
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-5 col-form-label">Nom &
                                                    Prenom</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" disabled
                                                        placeholder="Nom & prenom" name="noms"
                                                        value="{{ $item->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-5 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" disabled
                                                        placeholder="email" name="email" value="{{ $item->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-5 col-form-label">Tél.</label>
                                                <div class="col-sm-10">
                                                    <input type="tel" class="form-control" disabled
                                                        placeholder="tel..." name="phone" value="{{ $item->phone }}">
                                                </div>
                                                <input type="hidden" class="form-control" id="inputProject"
                                                    value="{{ $project->id }}" placeholder="email" name="project">
                                            </div>
                                        </div>
                                        <div class="col-lg-5">

                                            <div class="form-group row">
                                                <label for="role" class="col-sm-5 col-form-label">Rôle</label>
                                                <select class="form-control select2 col-sm-10" style="width: 100%;"
                                                    aria-placeholder="role" name="role" id="role">
                                                    <option value="Contributeur">Contributeur</option>
                                                    <option value="Steam">Steam</option>
                                                    <option value="Validateur">Validateur</option>
                                                </select>
                                            </div>
                                            <div class="form-group row">
                                                <label for="manager" class="col-sm-5 col-form-label">Manager</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="manager"
                                                        placeholder="manager..." name="manager">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="direction" class="col-sm-5 col-form-label">Direction</label>
                                                <select class="form-control select2 col-sm-10" style="width: 100%;"
                                                    aria-placeholder="direction" name="direction" id="directionName">
                                                    @forelse ($directions as $direction)
                                                        <option>{{ $direction->name }}</option>
                                                    @empty
                                                        <option>Aucune direction</option>
                                                    @endforelse
                                                </select>
                                                <input type="hidden" class="form-control" id="directionId"
                                                    name="directionId">

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
