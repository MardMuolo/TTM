@extends('layouts.app')
@section('title')
    <a href="#">Jalon</a>
@endsection
@section('filsAriane')
    <li class="breadcrumb-item active">Jalon</li>
@endsection
@section('content')
    <section class="content">
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
        <div class="text-right mb-2">
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modal-default">
                <i class="nav-icon fa fa-plus "></i>
            </button>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 35%">
                                #
                            </th>
                            <th style="width: 45%">
                                Désignation
                            </th>
                            <th style="width: 40%">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jalons as $jalon)
                            <tr>
                                <td>{{ $jalon->id }}</td>
                                <td>{{ $jalon->designation }}</td>
                                <td>
                                    <form action="" method="POST">
                                        <a class="btn btn-info btn-sm edit-btn" href="#" data-toggle="modal"
                                            data-target="#edit-{{ $jalon->id }}" form="edit-{{ $jalon->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-danger btn-sm" href="{{ route('jalons.destroy', $jalon->id) }}"
                                            onclick="supprimer(event)"
                                            item="Voulez-vous supprimer le jalon {{ $jalon->designation }}"
                                            data-toggle="modal" data-target="#supprimer">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach ($jalons as $jalon)
                @include('jalons.partials.edit')
            @endforeach
            @include('jalons.partials.create')
            @include('layouts.delete')
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
    <script>
        $(function() {
            $('.select2').select2({
                minimumInputLength: 2,
                ajax: {
                    url: '/fetch-categories',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
