@extends('layouts.app')
@section('title')
Types de projet : {{$types->count()}}
@endsection

@section('filsAriane')
    <li class="breadcrumb-item active">Types de projet</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if($errors)
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card">
                
                <div class="card-body p-0">
                    <button type="button" class="btn btn-primary m-4 float-right" data-toggle="modal" data-target="#create_modal">
                        <i class="fas fa-plus-circle">
                        </i>
                       
                        </button>
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 20%">
                                    Nom du type
                                </th>
                                <th style="width: 50%">
                                    Description
                                </th>
                                <th style="width: 30%" class="text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>
                                        {{$type->name}}
                                    </td>
                                    <td>
                                        {{$type->description}}
                                    </td>
                                    <td class="project-actions text-center">
                                    
                                        <a class="btn btn-info btn-sm" href="{{ route('projectType.update', $type) }}" onclick="edit(event)" item = "{{ $type->name }}" description="{{ $type->description }}" data-toggle="modal" data-target="#edit">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="{{ route('projectType.destroy', $type) }}" onclick="supprimer(event)" item="Voulez-vous supprimer le type {{ $type->name }}" data-toggle="modal" data-target="#supprimer">
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
                        <li class="page-item m-2"><a class="page-link" href="{{$types->previousPageUrl()}}">« Précedant</a></li>
                        <li class="page-item m-2"><a class="page-link" href="{{$types->nextPageUrl()}}">» Suivant</a></li>
                    </ul>
                </div>
                @include('projectTypes.partials.create')
                @include('layouts.delete')
                @include('projectTypes.partials.edit')
            </div>
        </section>

        @if(session()->has('success'))

        @endif
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
    </script>
@endsection