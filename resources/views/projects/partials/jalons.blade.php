<div class="card-body col-12">
    <div class="row">
        @forelse ($jalonsProgress as $index => $jalon)
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <div class="d-flex">
                            <h3 class="w-75">{{ $jalon['jalon']->designation }}</h3>
                        </div>

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
                                        <span class="font-weight-bold">{{ $joursRestants }}</span> <span class="text-orange">jour(s) restant(s)</span>
                                    </p>
                                    <p>
                                        <i class="far fa-calendar-alt text-orange"></i>
                                        <span class="font-weight-normal small">{{ $debutDate->format('d/m/Y') }} au
                                            {{ $echeance->format('d/m/Y') }}</span>
                                    </p>
                                @elseif ($jalon['status'] === env('jalonCloturer'))
                                    @if ($echeance->isPast())
                                        <p>Livrable soumis avec retard de {{ abs($joursRestants) }} jour(s)</p>
                                    @else
                                        <p>Livrable soumis à temps</p>
                                    @endif
                                    <p>
                                        <i class="far fa-calendar-alt text-primary"></i>
                                        <span class="font-weight-normal small">{{ $echeance->format('d/m/Y') }}</span>
                                    </p>
                                @else
                                    @if ($echeance->isPast())
                                        <p>Date dépassée, en retard de {{ abs($joursRestants) }} jour(s)</p>
                                    @else
                                        <p>Date définie </p>
                                    @endif
                                    <p>
                                        <i class="far fa-calendar-alt text-primary"></i>
                                        <span class="font-weight-normal small">{{ $echeance->format('d/m/Y') }}</span>
                                    </p>
                                @endif
                            @else
                                <p>Date dépassée</p>
                                <p>
                                    <i class="far fa-calendar-alt text-primary"></i>
                                    <span class="font-weight-normal small">En retard de {{ abs($joursRestants) }}
                                        jour(s)</span>
                                </p>
                            @endif
                        @else
                            <p>Dates non définies</p>
                            <p><i class="far fa-calendar-alt text-primary"></i> Dates non définies</p>
                        @endif

                        <div class="progress">
                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                style="width: {{ $jalon['status'] ? $jalon['progression'] : 0 }}%"
                                aria-valuenow="{{ $jalon['status'] ? $jalon['progression'] : 0 }}" aria-valuemin="0"
                                aria-valuemax="100">
                                {{ $jalon['status'] ? number_format($jalon['progression'], 0) . '%' : '0%' }}</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-2">
                        @if ($jalon['status'] === env('jalonEnCours'))
                            <small class="badge badge-primary bg-primary p-2">{{ $jalon['status'] }}</small>
                        @elseif ($jalon['status'] === env('jalonCloturer'))
                            <small class="badge badge-success bg-success p-2">{{ $jalon['status'] }} </small>
                        @else
                            <small class="badge badge-warning bg-yellow p-2">{{ $jalon['status'] }}</small>
                        @endif
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    @access('read','Jalon')
                    @if ($index === 0 || ($index > 0 && $jalonsProgress[$index - 1]['status'] === env('jalonCloturer')) || 
                    (auth()->check() && auth()->user()->hasRoles(['admin', 'ttofficer', 'project_owner'])))

                            <a href="{{ route('jalons.single',['jalon' => Crypt::encrypt($jalon['jalon']->id), 'option_ttm' => Crypt::encrypt($options->id), 'project' =>Crypt::encrypt( $project->id)]) }}"
                                class="small-box-footer text-orange bg-black ">
                                <span class="text-orange">Plus d'infos</span> <i class="fas fa-arrow-circle-right text-orange"></i>
                            </a>
                        
                        @else
                            <a href="#" class="small-box-footer bg-black disabled">
                                <span class="text-orange">Plus d'infos</span> <i class="fas fa-arrow-circle-right text-orange"></i>
                            </a>
                        @endif
                    @endaccess
                </div>
            </div>
        @empty
            <div class="col-lg-12">
                <p class="text-danger h6 fw-bold text-center">
                    Erreur : Score non géré, veuillez contacter l'administrateur système.
                </p>
            </div>
        @endforelse
    </div>
</div>


