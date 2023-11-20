@extends('layouts.app')
@section('title')
Profil
@endsection

@section('filsAriane')
    <li class="breadcrumb-item active">Profil utilisateur</li>
@endsection

@section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="@if(Auth::user()->profile_photo == null)
                                {{Vite::asset('resources/images/logo.svg')}}
                                @else
                                {{asset('storage/profiles/'.Auth::user()->profile_photo)}}
                                @endif"
                                alt="User profile picture">
                                
                            </div>

                            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>


                            {{-- <p class="text-muted text-center">Software Engineer</p> --}}

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                <b>Projets</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                <b>Livrables</b> <a class="float-right">543</a>
                                </li>
                                {{-- <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                                </li> --}}
                            </ul>
                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">A propos de moi</h3>
                        </div>
                        
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Nom et Prenom</strong>
                            <p class="text-muted">
                                {{Auth::user()->name}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted">{{Auth::user()->email}}</p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Nom d'utilisateur</strong>
                            <p class="text-muted">{{Auth::user()->username}}</p>
                            <hr>
                            <strong><i class="far fa-user mr-1"></i> Line Manager</strong>
                            <p class="text-muted">{{$line_manager?->name}}</p>
                            <hr>
                            <strong><i class="far fa-address-book mr-1"></i> Direction</strong>
                            <p class="text-muted">{{Auth::user()->direction_user?->direction?->name}}</p>
                            <hr>
                            <strong><i class="far fa-user mr-1"></i> Directeur</strong>
                            <p class="text-muted">{{$directeur?->name}}</p>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <p class="text-muted">Formulaire</p>
                        </div>
                        <div class="car-body">
                            <div class="card-body">
                                <form class="form-horizontal" method="post" action="{{ route('update-user-info') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nom et prenom</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Nom d'utilisateur</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputUsername" value="{{ Auth::user()->username }}" disabled>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label for="profile" class="col-sm-2 form-label">Photo de profil</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="profile" class="form-control @error('profile') is-invalid @enderror" id="profile">
                                            @error('profile')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group row">
                            
                                        <label for="line_manager" class="col-sm-2 col-form-label">Line Manager</label>
                                        <div class="col-sm-10">
                                            <select name="line_manager" class="form-control select2 w-100 h-5" id="user">
                                                <option value="{{$line_manager?->email}}">{{$line_manager?->name}}</option>
                                                
                                            </select>
                                        </div>
                                        @error('line')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    
                                    </div>
                                
                                <div class="form-group row">
                                    
                                    <label for="direction" class="col-sm-2 col-form-label">Direction</label>
                                    <div class="col-sm-10">
                                        <select name="direction" class="form-control">
                                            <option value="{{ Auth::user()->direction_user?->direction?->id }}">{{ Auth::user()->direction_user?->direction?->name }}</option>
                                            @foreach($directions as $direction)
                                                <option value="{{$direction->id}}">{{ $direction->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                </div>
        
                                    <input type="hidden" class="form-control" id="inputEmail" value="{{$line_manager?->email}}" placeholder="email" name="email">
                                  
                                    <div class="form-group row float-left">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
<script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
@vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')

<script>
    $(document).ready(function() {

        $.ajax({
            url: 'http://10.143.41.70:8000/promo2/odcapi/?method=getUsers',
            dataType: 'json',
            success: function(response) {

                if (response.success) {
                    var data = response.users;

                    var formattedData = data.map(function(user) {
                        return {
                            id: user.id,
                            username: user.username,
                            text: user.last_name+" "+user.first_name,
                            email: user.email,
                            phone: user.phone,
                            first_name: user.first_name,
                            last_name: user.last_name,
                        };
                    });

                    // Initialiser le champ de sélection avec les options
                    $('#user').select2({
                        data: formattedData,
                        minimumInputLength: 1
                    });

                    // Événement de sélection d'utilisateur
                    $('#user').on('select2:select', function(e) {
                        var selectedUser = e.params.data;

                        // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                        $('#user').val(selectedUser.email);
                        // $('#username').val(selectedUser.username);
                        $('#inputEmail').val(selectedUser.email);
                        // $('#inputTel').val(selectedUser.phone);
                        
                        // var fullName = selectedUser.first_name + ' ' + selectedUser
                        //     .last_name;
                        // $('#name').val(fullName);
                    });
                } else {
                    console.log('Erreur: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Erreur AJAX: ' + error);
            }
        });
    });
</script>

@endsection
