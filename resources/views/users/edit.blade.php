@extends('layouts.app')
@section('title')
    Utilisateur <strong> {{ $user->name }} </strong>
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Utilisateur <strong> {{ $user->name }} </strong></a></li>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="input-group mb-3">
                        <label for="name" class="col-md-4 col-form-label">Nom : {{ $user->name }}</label>
                    </div>
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-4 col-form-label">Email : {{ $user->email }}</label>
                    </div>
                    <ul class="nav nav-tabs d-flex justify-content-end" id="custom-content-above-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill"
                                href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home"
                                aria-selected="true">Securité</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-above-tabContent">
                        <div class="tab-pane fade active show  mt-3" id="custom-content-above-home" role="tabpanel"
                            aria-labelledby="custom-content-above-home-tab">
                            @foreach ($roles as $role)
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="roles[]"
                                        value=" {{ $role->id }} " id="{{ $role->id }}"
                                        @if ($user->roles->pluck('id')->contains($role->id)) checked @endif>
                                    <label for="{{ $role->id }}" class="form-check-label"> {{ $role->name }} </label>
                                </div>
                            @endforeach
                            <div class="text-right">
                                <button type="submit" class="btn btn-outline-default border"><i
                                        class="fas fa-save"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
