@extends('layouts.app')
@section('title')
    Role {{ $role->name }}
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
    <li class="breadcrumb-item"><a href="#" class="text-orange">Role {{ $role->name }}</a></li>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.modify', $role->id) }}" method="POST">
                @csrf
                <input type="hidden" name="role_id" value="{{ $role->id }}" id="">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-1">#</th>
                            <th class="col-5 text-left">Entité</th>
                            <th>Créer</th>
                            <th>Lire</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $model)
                            <tr>
                                <td class="col-1 text-center"> {{ ++$i }} </td>
                                <td class="col-5 text-left">
                                    {{ $model }}
                                </td>
                                @foreach ($actions as $action)
                                    <td class="icheck-primary col-2  ">
                                        <input type="checkbox" id=""
                                            @php
$verify =  DB::select('select * from role_police where role_id = ? and model = ? and action = ? ', [$role->id, $model, $action] ); @endphp
                                            @if ($verify) checked
                                @else @endif
                                            name="form[{{ $model . '_' . $action }}]" class="justify-center"
                                            spellcheck="false">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <button type="submit" class="btn btn-default border float-right"><i class="fas fa-save"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
