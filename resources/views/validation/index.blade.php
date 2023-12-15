@foreach ($demandes as $item)
    <aside class="control-sidebar control-sidebar-light" style="top: 57px; height: 568px; display: block;width: 50%;"
        id="edit-{{ $item->id }}-2">
        <div class="p-3 control-sidebar-content os-host os-theme-light os-host-resize-disabled  os-host-transition os-host-overflow os-host-overflow-y"
            style="height: 568px;">
            <div class="os-padding">
                <div class="os-viewport">
                    <div style="position: absolute; top: 0; left: 0;">
                        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                            data-target="#edit-{{ $item->id }}-2" href="#edit-{{ $item->id }}-2" role="button">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <?php $m = App\Models\Livrable::where('demande_id', $item->id)->get(); ?>
                    @forelse ($m as $livrable)
                        <div class="card card-default m-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i>
                                    Validations
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="callout callout-danger">
                                    <h5>{{ $livrable->nom }}</h5>
                                    <p>{{ $livrable->description }}</p>
                                    <small>Soumis par : {{ $item->contributeur }}</small>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <a href="{{ asset('storage/' . $livrable->file) }}" download class="btn btn-default">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                                {{ $livrable->file }}
                            </div>
                        </div>

                        <div class="card card-default m-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i>
                                    Emettre son avis
                                </h3>
                            </div>
                            <form class="form-horizontal" action="{{ route('validations.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="name">Décision <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-control" name="avis" required>
                                                    <option value="">Décision</option>
                                                    <option value="Valider">Valider</option>
                                                    <option value="A corriger">A corriger</option>
                                                    <option value="Rejeter">Rejeter</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="livrable_id" value="{{ $livrable->id }}">
                                    </div>
                                    <div class="col-xm-6">
                                        <div class="form-group">
                                            <label for="description">Description (Observation, motif rejet...) <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description" rows="5" placeholder="Enter ..." required></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-secondary"><i
                                            class="fa fa-check"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </form>
                        @empty
                            <div class="card card-default m-3">
                                Aucun livrable pour le moment
                            </div>
                    @endforelse
                </div>
            </div>
        </div>
    </aside>
@endforeach


@foreach ($demandes as $item)
    <aside class="control-sidebar control-sidebar-light" style="top: 57px; height: 568px; display: block;width: 50%;"
        id="edit-{{ $item->id }}-3">
        <div class="p-3 control-sidebar-content os-host os-theme-light os-host-resize-disabled  os-host-transition os-host-overflow os-host-overflow-y"
            style="height: 568px;">
            <div class="os-padding">
                <div class="os-viewport">
                    <div style="position: absolute; top: 0; left: 0;">
                        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                            data-target="#edit-{{ $item->id }}-3" href="#edit-{{ $item->id }}-2"
                            role="button">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <?php $m = App\Models\Livrable::where('demande_id', $item->id)->get(); ?>
                    @forelse ($m as $livrable)
                        <div class="card card-default m-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i>
                                    Observations
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($loop->first)
                                    <h5>{{ $livrable->nom }}</h5>
                                @endif
                                <?php $p = App\Models\Validation::where('livrable_id', $livrable->id)->get(); ?>
                                @if ($p->count() > 0)
                                    @foreach ($p as $validation)
                                        <div class="callout callout-danger">
                                            <h4>{{ $validation->avis }}</h4>
                                            <p>{{ $validation->description }}</p>
                                            <small>Soumis par : {{ $item->contributeur }}</small>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card card-default">
                                        Aucun avis pour le moment
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="card card-default m-3">
                            Aucun avis pour le moment
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </aside>
@endforeach
