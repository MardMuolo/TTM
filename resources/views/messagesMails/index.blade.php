 @extends('layouts.app')
 @section('title')
     Messages : {{ $messages->count() }}
 @endsection

 @section('filsAriane')
     <li class="breadcrumb-item active">Messages</li>
 @endsection

 @section('content')
     <div class="container-fluid">
         <section class="content-header">
             <div class="container-fluid">
                 <div class="row mb-2">
                     <div class="col-sm-6">
                         @if ($errors)
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
                     <button type="button" class="btn btn-primary m-4 float-right" data-toggle="modal"
                         data-target="#create_modal">
                         <i class="fas fa-plus-circle">
                         </i>
                     </button>
                     <table class="table table-striped projects">
                         <thead>
                             <tr>
                                 <th style="width: 10%">
                                     Code
                                 </th>
                                 <th style="width: 10%">
                                     Type
                                 </th>
                                 <th style="width: 20%">
                                     Objet
                                 </th>
                                 <th style="width: 40%">
                                     Contenu
                                 </th>
                                 <th style="width: 5%">
                                     Action
                                 </th>
                                 <th style="width: 5%">
                                     Attaches
                                 </th>
                                 <th style="width: 15%" class="text-center">
                                     Actions
                                 </th>
                             </tr>
                         </thead>
                         <tbody>
                             @if ($messages->count() == 0)
                                 <tr class="text-muted">
                                     <td colspan="7" class="text-center">Aucune donnée</td>
                                 </tr>
                             @endif
                             @foreach ($messages as $message)
                                 <tr>

                                     <td class="callout callout-success">
                                         {{ $message->code_name }}
                                     </td>
                                     <td class="callout">
                                         <p>
                                             {{ $message->type }}
                                         </p>

                                     </td>
                                     <td class="callout">
                                         <p>
                                             {{ $message->object }}
                                         </p>

                                     </td>
                                     <td class="callout callout-danger text-justify">
                                         <p>
                                             {{ $message->body }}
                                         </p>

                                     </td>
                                     <td class="callout">
                                         @if ($message->action)
                                             <span class="badge badge-success">accepté</span>
                                         @else
                                             <span class="badge badge-danger">non requise</span>
                                         @endif
                                     </td>
                                     <td class="callout">
                                         @if ($message->attachement)
                                             <span class="badge badge-success">accepté</span>
                                         @else
                                             <span class="badge badge-danger">non requis</span>
                                         @endif
                                     </td>
                                     <td class="project-actions text-center">
                                         {{-- <a class="btn btn-primary btn-sm" href="{{ route('ComplexityItem.show', $direction->id) }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            
                                        </a> --}}
                                         <a class="btn btn-warning btn-sm"
                                             href="{{ route('messagesMails.update', $message) }}" onclick="edit(event)"
                                             code_name = "{{ $message->code_name }}" type="{{ $message->type }}"
                                             object="{{ $message->object }}" body="{{ $message->body }}"
                                             action="{{ $message->action }}" attachement="{{ $message->attachement }}"
                                             data-toggle="modal" data-target="#edit">
                                             <i class="fas fa-pencil-alt">
                                             </i>

                                         </a>
                                         <a class="btn btn-danger btn-sm"
                                             href="{{ route('messagesMails.destroy', $message) }}"
                                             onclick="supprimer(event)"
                                             item="Voulez-vous supprimer ce message {{ $message->code_name }}"
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
                         <li class="page-item m-2"><a class="page-link" href="{{ $messages->previousPageUrl() }}">«
                                 Précedant</a></li>
                         <li class="page-item m-2"><a class="page-link" href="{{ $messages->nextPageUrl() }}">» Suivant</a>
                         </li>
                     </ul>
                 </div>
                 @include('messagesMails.partials.create')
                 @include('messagesMails.partials.edit')
                 @include('layouts.delete')
             </div>
         </section>

     </div>
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


         function edit(event) {
             event.preventDefault();
             a = event.target.closest('a');

             let editForm = document.getElementById('editForm');
             editForm.setAttribute('action', a.getAttribute('href'));

             let a_tag = event.target.closest('a');

             let titleEdit = document.getElementById('titleEdit');
             titleEdit.innerHTML = "Modification du message " + a_tag.getAttribute('code_name');

             document.getElementById('code_name').value = a_tag.getAttribute('code_name');
             document.getElementById('type').value = a_tag.getAttribute('type');
             document.getElementById('object').value = a_tag.getAttribute('object');

             if (a_tag.getAttribute('action') == "1") {
                 document.getElementById('action').setAttribute('checked', true);
             }

             if (a_tag.getAttribute('attachement') == "1") {
                 document.getElementById('attachement').setAttribute('checked', true);
             }

             document.getElementById('body').innerHTML = a_tag.getAttribute('body') + "";

         }
     </script>
 @endsection
