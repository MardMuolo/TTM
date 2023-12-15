    <section class="col-12 py-3">
        <table class="table table-striped " id="tab_activity">
            <thead class="bg-black text-orange">
                <th></th>
                {{-- <th ></th>
                <th></th> --}}
            </thead>
            <tbody>
                @forelse ($activity as $activity)
                    <tr>
                        <td>
                            <i class="{{$statusColor[$activity->event]}}"></i>
                            {{-- {{$activity->causer->name}} --}}

                            {{ $activity->description }}

                            @php
                                $diff = $today->diffInHours($activity->created_at);
                            @endphp
                            @if ($diff > 0 && $diff < 24)
                                il y a {{ $today->diffInHours($activity->created_at) }}h
                            @elseif($diff == 0)
                                {{ $today->diffInMinutes($activity->created_at) == 0 ? 'à l\'instant' : 'il y a ' . $today->diffInMinutes($activity->created_at) . 'min' }}
                            @elseif($diff > 24 && $diff < 288)
                                il y a {{ $today->diffInDays($activity->created_at) }} jours
                            @else
                                {{ $activity->created_at }}
                            @endif
                            
                        </td>

                        {{-- <td>
                            {{ $activity->description }}
                        </td>
                        <td class="text-black-50">
                            @php
                                $diff = $today->diffInHours($activity->created_at);
                            @endphp
                            @if ($diff > 0 && $diff < 24)
                                il y a {{ $today->diffInHours($activity->created_at) }}h
                            @elseif($diff == 0)
                                {{ $today->diffInMinutes($activity->created_at) == 0 ? 'à l\'instant' : 'il y a ' . $today->diffInMinutes($activity->created_at) . 'min' }}
                            @elseif($diff > 24 && $diff < 288)
                                il y a {{ $today->diffInDays($activity->created_at) }} jours
                            @else
                                {{ $activity->created_at }}
                            @endif
                        </td> --}}
                    </tr>
                    @empty
                        <tr>
                            <td colspan="12"> Aucune activité pour le moment</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </section>