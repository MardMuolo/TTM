@extends('layouts.app')
@section('title')
Points de complexité : {{ $complexityItem->name }}
@endsection

@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('ComplexityItem.index') }}">Points de complexités</a></li>
    <li class="breadcrumb-item active">{{ $complexityItem->name }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{  $complexityItem->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Nombre des targets</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $complexityItem->complexityTargets->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4>Liste des targets</h4>
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">
                                                Score
                                            </th>
                                            <th style="width: 50%">
                                                Libellé
                                            </th>
                                            
                                            <th style="width: 30%" class="text-center">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($targets as $target)
                                            <tr>
                                                <td>
                                                    {{ $target->value }}
                                                </td>
                                                <td>
                                                    {{$target->name}}
                                                </td>
                                                
                                                <td class="project-actions text-center">
                                                    <a class="btn btn-info btn-sm" onclick="edit_target(event)" href="{{ route('ComplexityTarget.update', $target) }}"  item="{{ $target->name }}" score="{{ $target->value }}" data-toggle="modal" data-target="#edit_target_modal">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" onclick="supprimer(event)" href="{{ route('ComplexityTarget.destroy', $target) }}" item="Voulez-vous supprimer ce target" data-toggle="modal" data-target="#supprimer">
                                                        <i class="fas fa-trash" >
                                                        </i>
                                                        
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <div class="card-footer w-100 clearfix">
                                        
                                            <ul class="pagination pagination-xl m-0 float-right">
                                                <li class="page-item m-2"><a class="page-link fw-bold" href="{{$targets->previousPageUrl()}}">« Précedant</a></li>
                                                <li class="page-item m-2"><a class="page-link fw-bold" href="{{$targets->nextPageUrl()}}">Suivant »</a></li>
                                            </ul>
                                        </div>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Description de l'item {{ $complexityItem->name }}</h3>
                            <p class="text-muted p-4">{{ $complexityItem->description }}</p>
                            <div class="text-center mt-5 mb-3">
                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create_modal">
                                    <i class="fas fa-plus-circle">
                                    </i>
                                    Ajouter un target</a>
                                <a class="btn btn-sm btn-warning" href="{{ route('ComplexityItem.update', $complexityItem) }}" onclick="edit(event)" item = "{{ $complexityItem->name }}" description="{{ $complexityItem->description }}" data-toggle="modal" data-target="#edit">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    </a>
                                    
                            </div>
                            
                        </div>
                    </div>
                </div>
                @include('complexities.items.partials.edit')
                @include('complexities.targets.create')
                @include('complexities.targets.edit')
                @include('layouts.delete')
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        function supprimer(event){
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));

            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('item') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";

            
            
        }

        
        function edit(event){
            event.preventDefault();
            a = event.target.closest('a');

            let editForm = document.getElementById('editForm');
            editForm.setAttribute('action', a.getAttribute('href'));

            let a_tag = event.target.closest('a');

            let titleEdit = document.getElementById('titleEdit');
            titleEdit.innerHTML = "Modification de l'élement "+ a_tag.getAttribute('item');

            document.getElementById('libelle').value = a_tag.getAttribute('item');
            document.getElementById('description').innerHTML = ""+a_tag.getAttribute('description');
            
        }

        function edit_target(event){
            event.preventDefault();

            let editForm = document.getElementById('editTargetForm');
            a = event.target.closest('a');

            editForm.setAttribute('action', a.getAttribute('href'));

            let titleEditTarget = document.getElementById('titleEditTarget');
            titleEditTarget.innerHTML = "Modification du target";

            document.getElementById('target').value = a.getAttribute('item');
            document.getElementById('score').value = a.getAttribute('score');
        }
    </script>
@endsection