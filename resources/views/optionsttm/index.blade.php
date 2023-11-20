@extends('layouts.app')
@section('title')
    <a href="#">
        Option Ttm</a>
@endsection
@section('filsAriane')
    <li class="breadcrumb-item active">Options Ttm</li>
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
            {{-- <button type="button" class="btn btn-primary m-4 float-right" data-toggle="modal" data-target="#create_modal">
                <i class="fas fa-plus-circle">
                </i>
                </button> --}}
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#create_modal">
                <i class="nav-icon fa fa-plus "></i>
            </button>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 10%">
                                #
                            </th>
                            <th style="width: 20%">
                                Nom
                            </th>
                            <th style="width: 20%">
                                Complexité
                            </th>
                            <th style="width: 40%">
                                Jalon
                            </th>
                            <th style="width: 30%">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($optionTtms as $optionTtm)
                            <tr>
                                <td>{{ $optionTtm->id }}</td>
                                <td>{{ $optionTtm->nom }}</td>
                                <td>
                                    Comprise entre {{ $optionTtm->minComplexite }} et {{ $optionTtm->maxComplexite }}
                                </td>
                                <td>
                                    @foreach ($optionTtm->jalons as $jalon)
                                        {{ $jalon->designation }},
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm edit-btn" href="#" data-toggle="modal"
                                        data-target="#edit-{{ $optionTtm->id }}" form="edit-{{ $optionTtm->id }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm"
                                        href="{{ route('optionsttm.destroy', $optionTtm->id) }}" onclick="supprimer(event)"
                                        item="Voulez-vous supprimer l'optionTtm {{ $optionTtm->nom }}" data-toggle="modal"
                                        data-target="#supprimer">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach ($optionTtms as $optionTtm)
                @include('optionsttm.partials.edit')
            @endforeach
        </div>
    </section>
    @include('optionsttm.partials.create')
    @include('layouts.delete')
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const minComplexiteModal1 = document.getElementById('min');
            const maxComplexiteModal1 = document.getElementById('max');
            const formModal1 = document.getElementById('modal-default');
            const erreurMessage1 = document.getElementById('erreurMessage1');


            formModal1.addEventListener('submit', function(e) {
                const minComplexiteValue = parseInt(minComplexiteModal1.value);
                const maxComplexiteValue = parseInt(maxComplexiteModal1.value);

                if (minComplexiteValue > maxComplexiteValue) {
                    e.preventDefault();
                    erreurMessage1.textContent = "minComplexite ne doit pas être supérieur à maxComplexite";
                } else {
                    erreurMessage1.textContent = "";
                }
            });

            @foreach ($optionTtms as $optionTtm)
                const minComplexiteModal2_{{ $optionTtm->id }} = document.getElementById(
                    'minComplexiteModal2_{{ $optionTtm->id }}');
                const maxComplexiteModal2_{{ $optionTtm->id }} = document.getElementById(
                    'maxComplexiteModal2_{{ $optionTtm->id }}');
                const formModal2_{{ $optionTtm->id }} = document.getElementById('edit-{{ $optionTtm->id }}');
                const erreurMessage2_{{ $optionTtm->id }} = document.getElementById(
                    'erreurMessage2_{{ $optionTtm->id }}');


                formModal2_{{ $optionTtm->id }}.addEventListener('submit', function(e) {
                    const minComplexiteValue_{{ $optionTtm->id }} = parseInt(
                        minComplexiteModal2_{{ $optionTtm->id }}
                        .value);
                    const maxComplexiteValue_{{ $optionTtm->id }} = parseInt(
                        maxComplexiteModal2_{{ $optionTtm->id }}
                        .value);

                    if (minComplexiteValue_{{ $optionTtm->id }} >
                        maxComplexiteValue_{{ $optionTtm->id }}) {
                        e.preventDefault();
                        erreurMessage2_{{ $optionTtm->id }}.textContent =
                            "minComplexite ne doit pas être supérieur à maxComplexite";
                    } else {

                    }
                });
            @endforeach
        });
    </script>
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
