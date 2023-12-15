@extends('layouts.app')
@section('title')
    {{ $project->name }}
@endsection
@section('content')
    <div class="card card-outline p-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-jalon-tab" data-toggle="pill"
                        href="#custom-content-below-jalon" role="tab" aria-controls="custom-content-below-jalon"
                        aria-selected="true">jalons ({{ count($jalons) }})</a>
                </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="custom-content-below-jalon" role="tabpanel"
                    aria-labelledby="custom-content-below-profile-tab">
                    <div class="card-body">
                        <div class="row">
                            @php
                                $previousEndDate = null;
                            @endphp
                            @forelse ($jalonsProgress as $index => $jalon)
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-light">
                                        <div class="inner">
                                            <div class="d-flex">
                                                <h3 class="w-75">{{ $jalon['jalon']->designation }}</h3>
                                                <div class="text-right p-0 w-25">
                                                    @if (auth()->user()->name == $project->projectOwner)
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#modal-default-{{ $jalon['jalon']->id }}">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- modal section  --}}
                                            <div class="modal fade" id="modal-default-{{ $jalon['jalon']->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" style="font-size: 20px;">Date pour le
                                                                Jalon {{ $jalon['jalon']->designation }}</h3>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('jalons.addDate', ['jalon' => $jalon['jalon']->id, 'option_ttm' => $optionTtm->id, 'project' => $project->id]) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="col">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="debutDate">Date Début</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i
                                                                                            class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                                <input type="date" class="form-control"
                                                                                    inputformat="mm/dd/yyyy"
                                                                                    name="debutDate" id="debutDate"
                                                                                    value="{{ $previousEndDate ?? '' }}"
                                                                                    min="{{ $previousEndDate ?? '' }}">
                                                                            </div>
                                                                            @if ($previousEndDate && $jalon['jalon']->pivot->debutDate < $previousEndDate)
                                                                                <small class="text-danger">La date de début
                                                                                    doit être postérieure à la date de fin
                                                                                    du jalon précédent.</small>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="echeance">Date Fin</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i
                                                                                            class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                                <input type="date" class="form-control"
                                                                                    inputformat="mm/dd/yyyy" name="echeance"
                                                                                    min="{{ $previousEndDate ?? '' }}"
                                                                                    id="echeance">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <button type="submit" class="btn btn-secondary"><i
                                                                            class="fa fa-check"></i></button>
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-dismiss="modal">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $previousEndDate = $jalon['jalon']->pivot->echeance ?? $previousEndDate;
                                            @endphp

                                            @if ($jalon['jalon']->pivot->debutDate && $jalon['jalon']->pivot->echeance)
                                                @php
                                                    $debutDate = \Carbon\Carbon::parse($jalon['jalon']->pivot->debutDate);
                                                    $echeance = \Carbon\Carbon::parse($jalon['jalon']->pivot->echeance);
                                                    $today = \Carbon\Carbon::today();
                                                    $joursRestants = $today->diffInDays($echeance, false);
                                                @endphp
                                                @if ($joursRestants > 0)
                                                    @if ($jalon['status'] === env('jalonEnCours'))
                                                        <p class="{{ $joursRestants <= 3 ? 'text-danger' : '' }}">
                                                            <span class="font-weight-bold">{{ $joursRestants }}</span>
                                                            jour(s) restant(s)
                                                        </p>
                                                        <p>
                                                            <i class="far fa-calendar-alt text-primary"></i>
                                                            <span
                                                                class="font-weight-normal small">{{ $debutDate->format('d/m/Y') }}
                                                                au
                                                                {{ $echeance->format('d/m/Y') }}</span>
                                                        </p>
                                                    @elseif ($jalon['status'] === env('jalonCloturer'))
                                                        @if ($echeance->isPast())
                                                            <p>Livrable soumis avec retard de {{ abs($joursRestants) }}
                                                                jour(s)</p>
                                                        @else
                                                            <p>Livrable soumis à temps</p>
                                                        @endif
                                                        <p>
                                                            <i class="far fa-calendar-alt text-primary"></i>
                                                            <span
                                                                class="font-weight-normal small">{{ $echeance->format('d/m/Y') }}</span>
                                                        </p>
                                                    @else
                                                        @if ($echeance->isPast())
                                                            <p>Date dépassée, en retard de {{ abs($joursRestants) }}
                                                                jour(s)</p>
                                                        @else
                                                            <p>Date définie</p>
                                                        @endif
                                                        <p>
                                                            <i class="far fa-calendar-alt text-primary"></i>
                                                            <span
                                                                class="font-weight-normal small">{{ $echeance->format('d/m/Y') }}</span>
                                                        </p>
                                                    @endif
                                                @else
                                                    <p>Date dépassée</p>
                                                    <p>
                                                        <i class="far fa-calendar-alt text-primary"></i>
                                                        <span class="font-weight-normal small">En retard de
                                                            {{ abs($joursRestants) }}
                                                            jour(s)</span>
                                                    </p>
                                                @endif
                                            @else
                                                <p><i class="far fa-calendar-alt text-primary"></i> Dates non définies</p>
                                            @endif
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
                                        </div>
                                    </div>
                                </div>
                            @empty
                        </div>

                        <div class="col-lg-12">
                            <p class="text-danger h6 fw-bold text-center">
                                Erreur : Score non géré, veuillez contacter l'administrateur système.
                            </p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- voir le projet --}}
    <div class="text-right mt-4">
        @php
            $id=Crypt::encrypt( $project->id)
        @endphp
        <a href="{{ route('projects.show', $id) }}" class="btn btn-primary"><i
                class="fa fa-save"></i></a>         
    </div>
    </div>
    </div>
@endsection


@push('third_party_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@push('page_scripts')
    {{-- <script>
         $(document).ready(function() {
           alert("bonjour")
        })
    </script> --}}
    <script>
        if ({{Session::get('message')!==Null}}) {
            swal({
                title: "Crétion de projet avec succes!",
                text: "Veuillez signaler les dates pour chaque jalon!",
                icon: "success",
                button: "Continuer!",
            });
        }   
    </script>
@endpush
