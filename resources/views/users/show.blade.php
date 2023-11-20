@extends('layouts.app')
@section('title')
    Utilisateur <strong> {{ $user->name }} </strong>
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Utilisateur <strong> {{ $user->name }} </strong></a></li>
@endsection
@section('content')
    <div class="container">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs d-flex justify-content-end" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                                href="#custom-content-below-profile" role="tab"
                                aria-controls="custom-content-below-profile" aria-selected="false">Agent</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-above-tabContent">
                        <div class="tab-pane active show fade" id="custom-content-below-profile" role="tabpanel"
                            aria-labelledby="custom-content-below-profile-tab">
                            <table id="example1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> {{ $user->name }}</td>
                                        <td> {{ $user->email }} </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
