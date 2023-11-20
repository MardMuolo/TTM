@extends('layouts.app')
@section('title')
    Collaborateurs ({{ count($users) }})
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Mes Collaborateurs</a></li>
@endsection
@section('content')
    <section class="content card card-primary card-outline p-4">
        <div class="card-body p-0">
            <table class="table table-striped projects" id="example1">
                <thead class="text-left">
                    <tr>
                        <th style="width: 1%">N°</th>
                        <th style="width: 20%">Nom</th>
                        <th style="width: 30%">Projet</th>
                        <th>Rôle</th>
                        <th style="width: 8%" class="text-center">Statut</th>
                        <th style="width: 20%"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->project_name }}</< /td>
                            <td class="item_progress">{{ $user->role }}</td>
                            @php

                            @endphp
                            @if ($user->status == 'accepter')
                                <td class="item-state badge bg-success">{{ $user->status }}</td>
                            @elseif($user->status == 'en attente')
                                <td class="item-state badge bg-orange">{{ $user->status }}</td>
                            @else
                                <td class="item-state badge bg-danger">{{ $user->status }}</td>
                            @endif
                            <td class="item-actions text-right">
                                @access('read', 'Project')
                                    <a class="btn btn-light text-danger btn-sm" data-toggle="modal"
                                        data-target="#modal-default-{{ $user->id }}"><i class="fas fa-user-times"></i></a>
                                @endaccess

                                @access('update', 'Project')
                                    <a class="btn btn-light text-success btn-sm" data-toggle="modal"
                                        data-target="#modal-default-{{ $user->id }}-accepter"><i
                                            class="fas fa-user-check"></i></a>
                                @endaccess
                            </td>
                        </tr>

                        <div class="modal fade" id="modal-default-{{ $user->id }}">
                            <form
                                action="{{ route('approuving.update', $user->user_id) }}?response=refus&project={{ $user->project_id }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Refus</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Vous-voulez vous refuser {{ $user->name }} à paticiper au projet
                                                {{ $user->project_name }}?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary"><i
                                                    class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                            </form>

                            <!-- /.modal-dialog -->
                        </div>
                        <div class="modal fade" id="modal-default-{{ $user->id }}-accepter">
                            <form
                                action="{{ route('approuving.update', $user->user_id) }}?response=accepter&project={{ $user->project_id }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Autorisation</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Vous-voulez vous autoriser {{ $user->name }} à paticiper au projet
                                                {{ $user->project_name }}?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary"><i
                                                    class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                            </form>

                            <!-- /.modal-dialog -->
                        </div>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>



    </section>
@endsection
@section('scripts')
@endsection
