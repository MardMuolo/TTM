@extends('layouts.app')
@section('title')
    Dépôt du livrable
@endsection
{{-- @section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Projets</a></li>
    <li class="breadcrumb-item"><a href="#">jalon</a></li>
    <li class="breadcrumb-item"><a href="#"> {{ $demande->demande->title }}</a></li>
@endsection --}}
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Note:</h5>
                        {{ $demande->description }}
                    </div>
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-paper-plane"></i> Livrable
                                    <small class="float-right">Date prévue: {{ $demande->date_prevue }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-10 invoice-col">
                                Categorie
                                <p>{{ $demande->demande->title }}</p>
                            </div>
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Titre</th>
                                            <th>Note</th>
                                            <th>Fichier</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($livrables as $livrable)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $livrable->nom }}</td>
                                                <td>{{ $livrable->description }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/livrable/' . basename($livrable->fichier)) }}"
                                                        download>{{ basename($livrable->fichier) ?? 'N/A' }}</a>
                                                </td>
                                                <td>{{ $livrable->status }}</td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('livrables.destroy', $livrable->id) }}"
                                                        onclick="supprimer(event)"
                                                        project="Voulez-vous supprimer ce livrable" data-toggle="modal"
                                                        data-target="#supprimer" title="archiver">
                                                        <i class="fas fa-archive"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="12" class="text-center text-secondary">Aucune livraison pour l'instant</td>
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
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"
                                    data-toggle="modal" data-target="#modal-default">
                                    <i class="fas fa-pencil-alt"></i> Deposer
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" id="modal-default">
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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
    </script>
@endpush
