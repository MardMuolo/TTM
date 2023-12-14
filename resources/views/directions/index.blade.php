@extends('layouts.app')
@section('title')
    Directions : {{ $directions->count() }}
@endsection

@section('filsAriane')
    <li class="breadcrumb-item active">Directions</li>
@endsection

@section('content')
    <div class="container-fluid">
        @if (Session::get('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div>
        @elseif (Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <section class="content">
            <div class="card">

                <div class="card-body p-0">
                    <button type="button" class="btn btn-primary m-4 float-right" data-toggle="modal"
                        data-target="#create_modal">
                        <i class="fas fa-plus-circle">
                        </i>

                    </button>
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 40%">
                                    Nom de direction
                                </th>
                                <th>
                                    Directeur
                                </th>
                                <th style="width: 40%" class="text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($directions->count() == 0)
                                <tr class="text-muted">
                                    <td colspan="3" class="text-center">Aucune donnée</td>
                                </tr>
                            @endif
                            @foreach ($directions as $direction)
                                <tr>

                                    <td>
                                        {{ $direction->name }}
                                    </td>
                                    <td>
                                        {{ $direction->direction_users?->Where('is_director', true)->first()?->user?->name }}
                                    </td>
                                    <td class="project-actions text-center">
                                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('ComplexityItem.show', $direction->id) }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            
                                        </a> --}}
                                        <a class="btn btn-info btn-sm" href="{{ route('directions.update', $direction) }}"
                                            onclick="edit(event)" direction = "{{ $direction->name }}"
                                            directeur="{{ $direction->direction_users?->Where('is_director', true)->first()?->user?->name }}"
                                            directeur_email="{{ $direction->direction_users?->Where('is_director', true)->first()?->user?->email }}"
                                            data-toggle="modal" data-target="#edit">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('directions.destroy', $direction) }}" onclick="supprimer(event)"
                                            item="Voulez-vous supprimer la direction {{ $direction->name }}"
                                            data-toggle="modal" data-target="#supprimer">
                                            <i class="fas fa-trash">
                                            </i>

                                        </a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-xl m-0 float-right">
                        <li class="page-item m-2"><a class="page-link" href="{{ $directions->previousPageUrl() }}">«
                                Précedant</a></li>
                        <li class="page-item m-2"><a class="page-link" href="{{ $directions->nextPageUrl() }}">»
                                Suivant</a></li>
                    </ul>
                </div>
                @include('directions.partials.create')
                @include('layouts.delete')
                @include('directions.partials.edit')
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
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


        function edit(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let editForm = document.getElementById('editForm');
            editForm.setAttribute('action', a.getAttribute('href'));

            let a_tag = event.target.closest('a');

            let titleEdit = document.getElementById('titleEdit');
            titleEdit.innerHTML = "Modification de l'élement " + a_tag.getAttribute('direction');

            document.getElementById('direction').value = a_tag.getAttribute('direction');
            document.getElementById('directeur_edit').innerHTML = a_tag.getAttribute('directeur') + "";
            document.getElementById('inputEmail2').value = a_tag.getAttribute('directeur_email');

        }
    </script>
@endsection
