<div class="col-12 p-2">
    <table class="table table-striped" id="tab_demande2">
        <thead class="thead-color">
            {{-- <th style="width: 1%"></th> --}}
            <th style="width: 30%"></th>
            <th style="width: 30%"></th>
            <th></th>
        </thead>
        <tbody>
            @auth
                @forelse ($demandesProject as $demande)
                    @if ($demande->contributeur === auth()->user()->id)
                        {{-- @php
                                    $jalonsLink = '<td></td>';
                                    foreach ($jalonsProgress as $index => $jalon) {
                                        if ($demande->status === 'Soumis') {
                                            $jalonsLink = '<td><i class="fas fa-check-circle text-green"></i></td>';
                                            break;
                                        } elseif ($demande->status === 'En attente de validation') {
                                            $jalonsLink = '<td><i class="fas fa-hourglass-start fa-spin text-orange"></i></td>';
                                            break;
                                        } else {
                                            $jalonsLink =
                                                '<td><a href="'.route('jalons.single', ['jalon' => $jalon['jalon']->id, 'option_ttm' => $options->id, 'project' => $project->id]).'"><i class="fas fa-eye"></i></a></td>';
                                            break;
                                        }
                                    }
                                @endphp --}}
                        <tr>
                            {{-- <td>{{ $i++ }}</td> --}}
                            <td>{{ $demande->demande->title }}</td>
                            <td>{{ $demande->description }}</td>
                            <td>pour un délai de {{ $demande->deadLine }}</td>
                        </tr>
                    @else
                       
                    @endif
                @empty
                @endforelse
            @endauth
        </tbody>
    </table>
</div>
