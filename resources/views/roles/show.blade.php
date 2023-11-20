@extends('layouts.app')
@section('title')
    Role {{ $role->name }}
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Role {{ $role->name }}</a></li>
@endsection
@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs d-flex justify-content-end" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                            href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                            aria-selected="false">Securité</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                            href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile"
                            aria-selected="false">Agent</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-above-tabContent">
                    <div class="tab-pane active show  fade" id="custom-content-below-home" role="tabpanel"
                        aria-labelledby="custom-content-below-home-tab">
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-1 text-left">id</th>
                                    <th class="text-left col-4">Entité</th>
                                    <th>Créer</th>
                                    <th>Lire</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($models as $model)
                                    <tr>
                                        <td> {{ ++$i }} </td>
                                        <td class="text-left col-4">
                                            {{ $model }}
                                        </td>
                                        @foreach ($actions as $action)
                                            <td class="text-center">
                                                @php
                                                    $verify = DB::select('select * from role_police where role_id = ? and model = ? and action = ? ', [$role->id, $model, $action]);
                                                @endphp
                                                @if ($verify)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <i class="fas fa-circle gray"></i>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <a class="btn btn-outline-default border" href="{{ route('roles.edit', $role->id) }}"><i
                                    class="fas fa-pen"></i></a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel"
                        aria-labelledby="custom-content-below-profile-tab">
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td> <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td> {{ $user->email }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
