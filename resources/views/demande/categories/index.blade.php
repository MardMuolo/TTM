@extends('layouts.app')

@section('title')
    Catégories
@endsection

@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Catégorie</a></li>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="text-right mb-2">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#create_modal">
                    <i class="nav-icon fa fa-plus "></i>
                </button>
            </div>
            @if ($errors)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul>
                        <li>{{ $error }}</li>
                    </ul>
                </div>
            @endforeach
        @endif
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects text-center">
                        <thead>
                            <tr>
                                <th class="text-center col-lg-1">
                                    ID
                                </th>
                                <th class="text-center col-lg-9">
                                    Titre
                                </th>
                                <th class="text-right col-lg-2">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categoryDemandes as $categoryDemande)
                                <tr>
                                    <td class="text-center col-lg-1">{{ $categoryDemande->id }}</td>
                                    <td class="text-center col-lg-9">{{ $categoryDemande->title }}</td>
                                    <td class="text-right col-lg-2">
                                        <form action="" method="POST">
                                            <a class="btn btn-info btn-sm edit-btn" href="#" data-toggle="modal"
                                                data-target="#edit-{{ $categoryDemande->id }}"
                                                form="edit-{{ $categoryDemande->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('categoryDemandes.destroy', $categoryDemande->id) }}"
                                                onclick="supprimer(event)"
                                                item="Voulez-vous supprimer la categorie {{ $categoryDemande->title }}"
                                                data-toggle="modal" data-target="#supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                                @include('demande.categories.partials.edit', ['categoryDemande' => $categoryDemande])
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                @include('layouts.delete')

                @include('demande.categories.partials.create')
            </div>

            <div class="d-flex justify-content-center pagination-lg">
                {{-- Pagination links --}}
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