@extends('layouts.app')
@section('title')
    Dépôt du livrable
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.show', Crypt::encrypt($project->id)) }}"
            title="{{ $project->name }}"
            class="text-orange">{{ substr(str_replace([' ', "'"], '', $project->name), 0, 10) }}...</a></li>
    <li class="breadcrumb-item text-secondary">{{ $jalon->designation }}</li>
    <li class="breadcrumb-item text-secondary">Livrable</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info "></i> Note:</h5>
                        {{ $demande->description }}
                    </div>
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-paper-plane"></i> <span class="text-orange">Livrable</span>
                                    <small class="float-right">Date prévue: {{ $demande->date_prevue }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-10 invoice-col">
                                <b>Categorie</b>
                                <p>{{ $demande->demande->title }}</p>
                            </div>
                        </div>
                        <div class="row invoice-info">

                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-black text-orange">
                                        <th></th>
                                        <th>Titre</th>
                                        <th>Note</th>
                                        <th>Fichier</th>
                                        <th>Status</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @forelse ($livrables as $livrable)
                                            <tr class="{{ $livrable->status == env('livrableRejeter') ? 'bg-red' : '' }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $livrable->nom }}</td>
                                                <td>{{ $livrable->description }}
                                                    @if ($livrable->pv)
                                                        <p><span class="text-danger bold">Alerte!:</span>
                                                            {{ $livrable->pv }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $livrable->fichier) }}"
                                                        download>Telecharger <i class="fas fa-download"></i></a>
                                                </td>
                                                <td class="badge {{ $color[$livrable->status] }}">{{ $livrable->status }}
                                                </td>
                                                <td>
                                                    @if (auth()->user()->id == $demande->contributeur)
                                                        <a class="btn btn-warning btn-sm {{ $livrable->status != env('livrableValider') ? '' : 'disabled' }}"
                                                            title="validation"
                                                            href="{{ route('valider_livrable', $livrable->id) }}"
                                                            onclick="edit(event)" title = "{{ $livrable->title }}"
                                                            fichier="{{ $livrable->fichier }}" data-toggle="modal"
                                                            data-target="#edit">
                                                            <i class="fas fa-pen">
                                                            </i>
                                                        </a>

                                                        <a class="btn btn-danger btn-sm {{ $livrable->status != env('livrableValider') ? '' : 'disabled' }}"
                                                            href="{{ route('livrables.destroy', $livrable->id) }}"
                                                            onclick="supprimer(event)"
                                                            project="Voulez-vous supprimer ce livrable" data-toggle="modal"
                                                            data-target="#supprimer" title="archiver">
                                                            <i class="fas fa-archive"></i>
                                                        </a>
                                                    @endif
                                                    @php
                                                        $is_member = DB::table('project_users')
                                                            ->where('project_id', $project->id)
                                                            ->where('user_id', auth()->user()->id)
                                                            ->get()
                                                            ->first();
                                                        // dd($test);
                                                    @endphp
                                                    @foreach (Auth()->user()->roles as $role)
                                                        @if (
                                                            $role->name == env('Directeur') ||
                                                                ($is_member->status == env('membreApprouver') and $is_member->role == 'Validateur'))
                                                            @php
                                                                $id = Crypt::encrypt($livrable->id);
                                                            @endphp
                                                            <a class="btn btn-secondary btn-sm @if($livrable->status !=env('livrableEnAttente')) disabled @endif" title="validation"
                                                                href="{{ route('valider_livrable', $id) }}"
                                                                onclick="edit(event)" item = "{{ $livrable->nom }}"
                                                                description="{{ $livrable->description }}"
                                                                data-toggle="modal" data-target="#validate">
                                                                <i class="far fa-envelope-open">
                                                                </i>
                                                            </a>
                                                        @endif
                                                    @endforeach


                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center text-secondary">Aucune livraison pour
                                                    l'instant</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                {{-- <a class="btn btn-warning btn-sm" title="validation" href="{{ route('valider_livrable', $livrable->id) }}" onclick="edit(event)" item = "{{ $livrable->nom }}" fichier="{{ $livrable->fichier }}" data-toggle="modal" data-target="#edit">
                                    <i class="far fa-envelope-open">
                                    </i>  
                                </a> --}}
                                @php
                                    $is_member = DB::table('project_users')
                                        ->where('project_id', $project->id)
                                        ->where('user_id', auth()->user()->id)
                                        ->get()
                                        ->first();
                                    // dd($test);
                                @endphp
                                @if (auth()->user()->id == $demande->contributeur and
                                        $livrables->last()?->status != env('livrableEnAttente') and
                                        $livrables->last()?->status != env('livrableValider'))
                                    <button type="button"
                                        class="btn btn-primary float-right
                                    @if ($is_member->status == env('membreEnAttente')) disabled @endif
                                    "
                                        @if ($is_member->status == env('membreEnAttente')) title="En attente de validation de votre LineManger" @endif
                                        style="margin-right: 5px;" data-toggle="modal" data-target="#create_modal">
                                        <i class="fas fa-pencil-alt"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    {{-- <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Dépôt du livrable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('livrables.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Titre</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    placeholder="Entrer le titre" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Document</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="fichier"
                                            required>
                                        <label class="custom-file-label" for="exampleInputFile">choisir le fichier</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{ $demande->id }}" hidden name="demande_jalon_id">
                            </div>
                            <div class="form-group">
                                <label>Observation</label>
                                <textarea class="form-control" rows="3" placeholder="Entrer ..." name="description"></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">J'ai vérifié le document avant de
                                    l'envoyer</label>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}

    {{-- directeur modale
    <div class="modal fade" id="modal-default-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Validation du livrable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('livrables.update',5) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <h4>Votre Avis</h4>
                                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="Avis">
                                        <option value="Valider">Valider</option>
                                        <option value="corriger">A corriger</option>
                                        <option value="Rejette">Rejette</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h4>Observation</h4>
                                    <textarea class="form-control" rows="3" placeholder="Entrer ..." name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">J'ai vérifié le document avant de
                                    l'envoyer</label>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}
    @include('jalons.partials.modalCreate')
    @include('jalons.partials.modalEdit')
    @include('jalons.partials.modalValidation')
    @include('layouts.delete')
@endsection
@push('page_scripts')
    <script>
        function supprimer(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));
            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('project') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";
        }

        function edit(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let editForm = document.getElementById('editForm');
            editForm.setAttribute('action', a.getAttribute('href'));

            let a_tag = event.target.closest('a');

            let titleEdit = document.getElementById('titleEdit');
            titleEdit.innerHTML = "Modification de l'élement " + a_tag.getAttribute('item');

            document.getElementById('title').value = a_tag.getAttribute('title');
            document.getElementById('file').innerHTML = "" + a_tag.getAttribute('fichier');

        }
        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2()
        });
    </script>
@endpush
