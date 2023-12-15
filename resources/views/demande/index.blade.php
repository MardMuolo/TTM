@extends('layouts.app')

@section('title')
    Demandes
@endsection

@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Demandes</a></li>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="text-right mb-2">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#new_modal">
                    <i class="nav-icon fa fa-plus"></i>
                </button>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects text-center">
                        <thead>
                            <tr>
                                <th class="text-center col-lg-1">
                                    Id
                                </th>
                                <th class="text-center col-lg-6">
                                    Demandes
                                </th>
                                <th class="text-center col-lg-2">
                                    Categories
                                </th>
                                <th class="text-center col-lg-1">
                                    Jalons
                                </th>
                                <th class="text-right col-lg-2">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demandes as $demande)
                                <tr>
                                    <td class="text-center col-lg-1">{{ $demande->id }}</td> 
                                    <td class="text-left col-lg-6">{{ $demande->title }}</td>
                                    <td class="text-center col-lg-2">{{ $demande->categoryDemande->title }}</td>
                                    <td class="text-center col-lg-1">{{ $demande->jalon->designation }}</td>

                                    <td class="text-right  col-lg-2">
                                        <form action="" method="POST">
                                            <a class="btn btn-info btn-sm edit-btn" href="#" data-toggle="modal"
                                                data-target="#edit_modal" form="edit-{{ $demande->title }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('demande.destroy', $demande->id) }}" onclick="supprimer(event)"
                                                item="Voulez-vous supprimer la demande {{ $demande->title }}" data-toggle="modal"
                                                data-target="#supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                @include('demande.partials.create')
                @include('demande.partials.edit')
                @include('layouts.delete')
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-xl m-0 float-right">
                        <li class="page-item m-2"><a class="page-link" href="{{ $demandes->previousPageUrl() }}">« Précédant</a></li>
                        <li class="page-item m-2"><a class="page-link" href="{{ $demandes->nextPageUrl() }}">Suivant »</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function supprimer(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));

            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('item') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";
        }
    </script>
@endsection