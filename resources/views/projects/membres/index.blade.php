<div class="col-lg-12">
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
    <div class="text-right mx-4 col">
        {{-- @access('create', 'Project')
            @if (auth()->user()->name == $project->projectOwner)
                <button class="btn btn-light mx-5 my-2" data-toggle="modal" data-target="#create_modal">
                    <i class="fas fa-plus-circle"></i>
                </button>
            @endif
        @endaccess --}}

    </div>
    <section class="content p-4">
        <table class="table table-striped " id="example1">
            <thead>
                <tr>
                    <th></th>
                    <th>Noms</th>
                    <th class="text-center">Contribution</th>
                    <th class="text-center">Rôle</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $item->name }}<br>
                            <small>
                                <b class="text-black-50">Masculin</b>
                            </small>
                        </td>
                        <td class="project_progress ">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-red" role="progressbar" aria-valuenow="57" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 0%"></div>
                            </div>
                            <small>loading...</small>
                        </td>
                        <td class="project-state ">
                            {{ $item->pivot->role }}
                        </td>
                        <td class="project-state">
                            <span
                                class="badge {{ $item->pivot->status == 'En Attente' ? 'bg-secondary' : ($item->pivot->status == 'refus' ? 'bg-danger' : 'bg-success') }} p-2">{{ $item->pivot->status }}</span>
                        </td>
                        <td class="project-actions text-center">
                            <a class="btn btn-light btn-sm" href="#"><i class="fas fa-eye"></i></a>
                            @access('delete', 'projectUser   ')
                                @if (auth()->user()->name == $project->projectOwner)
                                    <a class="btn btn-info btn-sm edit-btn" href="#" data-toggle="modal"
                                        data-target="#edit-{{ $item->id }}" form="edit-{{ $item->id }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @if ($item->pivot->role != 'projectOwner')
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('contributeur.destroy', $item->id) }}" onclick="supprimer(event)"
                                            item="Voulez-vous supprimer le contributeur {{ $item->name }}"
                                            data-toggle="modal" data-target="#supprimer"><i class="fas fa-trash"></i></a>
                                    @endif
                                @endif
                            @endaccess
                        </td>
                    </tr>
                @empty
                    <tr class="col-lg-12  text-center text-black-50 h5">
                        <td colspan="6">Aucun membre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
    @include('projects.membres.edit')
    @include('layouts.delete')
    @include('projects.membres.create')
</div>
