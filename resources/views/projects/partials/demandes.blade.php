<div class="col-12">
    <div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped" id="example1">
                <thead>
                    <tr>
                        <th></th>
                        <th colspan="7"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @auth
                        @forelse ($demandesProject as $demande)
                            @if ($demande->contributeur === auth()->user()->name)
                                @php
                                    $jalonsLink = '
                    <td></td>
                    ';
                                    foreach ($jalonsProgress as $index => $jalon) {
                                        if ($demande->status === 'Soumis') {
                                            $jalonsLink = '
                            <td><i class="fas fa-check-circle text-green"></i></td>
                            ';
                                            break;
                                        } elseif ($demande->status === 'En attente de validation') {
                                            $jalonsLink = '
                            <td><i class="fas fa-hourglass-start fa-spin text-orange"></i></td>
                            ';
                                            break;
                                        } else {
                                            $jalonsLink =
                                                '
                            <td><a href="' .
                                                route('jalons.single', ['jalon' => $jalon['jalon']->id, 'option_ttm' => $options->id, 'project' => $project->id]) .
                                                '"><i class="fas fa-eye"></i></a></td>
                            ';
                                            break;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td colspan="10">{{ $demande->demande->title }}</td>
                                    <td>{{ $demande->description }}</td>
                                    <td>pour un délai de {{ $demande->deadLine }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="12">Aucune demande ne vous est assignée pour le moment.</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="12">Aucune demande pour le moment.</td>
                            </tr>
                        @endforelse
                    @endauth
                </tbody>
            </table>
        </div>
    </div>
</div>
