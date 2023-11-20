<div class="col-lg-11">
    <section class="content">
        <table class="table table-striped " id="example1">
            <thead>
                <tr>
                    <th></th>
                    <th colspan="7"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activity as $activity)
                    <tr>
                        <td>
                            @switch($activity->event)
                                @case('create')
                                    <i class="fas fa-user-tie"></i>
                                    @break
                                @case('update')
                                    <i class="fas fa-edit"></i>
                                    @break
                                @case('add')
                                    <i class="fas fa-chart-line"></i>
                                    @break
                                @case('addUser')
                                    <i class="fas fa-user-plus"></i>
                                    @break
                                @case('deleteUser')
                                    <i class="fas fa-user-minus"></i>
                                    @break
                                @case('updateUser')
                                    <i class="fas fa-user-cog"></i>
                                    @break
                                @case('addFile')
                                    <i class="fas fa-file-upload"></i>
                                    @break
                                @case('updateDate')
                                    <i class="fas fa-clock"></i>
                                    @break
                                @case('addDate')
                                    <i class="fas fa-clock"></i>
                                    @break
                                @default
                                    <i class="fas fa-random"></i>
                                    
                            @endswitch
                        </td>

                        <td colspan="7">
                            {{ $activity->description }}
                        </td>
                        <td class="text-black-50">
                            @php
                                $diff=$today->diffInHours($activity->created_at);
                            @endphp
                            @if ($diff >0 && $diff <24)
                                il y a {{$today->diffInHours($activity->created_at)}}h
                            @elseif($diff == 0)
                                {{$today->diffInMinutes($activity->created_at) == 0 ? 'à l\'instant' : 'il y a '.$today->diffInMinutes($activity->created_at).'min'}}
                            @elseif($diff > 24 && $diff<288)
                                il y a {{$today->diffInDays($activity->created_at)}} jours
                            @else
                                {{$activity->created_at}}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12"> Aucune activité pour le moment</td>
                    </tr>
                @endforelse
            </tbody>
    
        </table>
    </section>
    
</div>