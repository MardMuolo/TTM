@extends('layouts.app')
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a></li>
    <li class="breadcrumb-item"><a href="#">Editer</a></li>
@endsection

@section('content')
    <form action="{{ route('projects.update', $project->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-10 container my-4">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Modifier le projet</h3>
                </div>
                <div class="card-body p-0">
                    <div class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#logins-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                    id="logins-part-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">information1</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#information-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part"
                                    id="information-part-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">information2</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#complexity-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="complexity-part"
                                    id="complexity-part-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Complexité</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <!-- your steps content here -->
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nom</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nom du projet" name="name" value="{{ $project->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Type</label>
                                    <select class="form-control" style="width: 100%;" aria-placeholder="type de projet"
                                        name="type">
                                        <option>Produit Offre ou Service</option>
                                        <option>Application Outil ou Infra</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Cible</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder=" cible"
                                        name="target" value="{{ $project->target }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Début</label>
                                    <input type="date" class="form-control" id="exampleInputEmail1" name="startDate"
                                        value="{{ $project->startDate }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Fin</label>
                                    <input type="date" class="form-control" id="exampleInputEmail1" name="endDate"
                                        value="{{ $project->endDate }}">
                                </div>
                                <a class="btn btn-primary" onclick="stepper.next()">Précedent</a>
                            </div>
                            {{-- fin de la partie 1 --}}

                            <div id="information-part" class="content" role="tabpanel"
                                aria-labelledby="information-part-trigger">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Project Owner</label>
                                        <div class="form-group">
                                            <select class="" data-placeholder="Any" style="width: 100%;"
                                                name="owner">
                                                @forelse ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @empty
                                                    <option>Aucun utilisateur trouvé</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Coût du projet</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1"
                                            placeholder=" coût" name="coast" value="{{ $project->coast }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Descriptiion</label>
                                        <textarea class="form-control" rows="3" placeholder="Description" name="description">{{ $project->description }} </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Documents <span
                                                class="text-black-50">(optionel)</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="form-control" id="" name="file[]"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" onclick="stepper.previous()">Précedent</a>
                                <a class="btn btn-primary" onclick="stepper.next()">Suivant</a>
                            </div>
                            {{-- fin de la partie 2 --}}
                            <div id="complexity-part" class="content" role="tabpanel"
                                aria-labelledby="complexity-part-trigger">
                                @foreach ($complexity_items as $item)
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>{{ $item->name }}</label>
                                            <select class="form-control " name="score[]" required>
                                                <option disabled selected>null</option>
                                                @foreach ($item->complexityTargets as $target)
                                                    <option value="{{ $target->value }}">{{ $target->value }} -
                                                        {{ $target->name }}</option>
                                                @endforeach

                                            </select>
                                            <span dir="ltr" style="width: 100%;">
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach

                                <a class="btn btn-primary" onclick="stepper.previous()">Précedent</a>
                                <button class="btn btn-primary" id="test" type="submit">Soumettre</button>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-black">
                    Orange Digital Center
                </div>

            </div>
            <!-- /.card -->
        </div>
    </form>
@endsection
@push('third_party_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css');
    @vite('node_modules/admin-lte/plugins/bs-stepper/css/bs-stepper.min.css');
@endpush
@push('page_scripts')
    <script>
        function updateTargetId(selectElement, itemId) {
            var targetIdInput = document.getElementById("target_id_" + itemId);
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var targetId = selectedOption.getAttribute("data-target-id");
            targetIdInput.value = targetId;
        }

        // Handle BS-Stepper
        document.addEventListener('DOMContentLoaded', function(e) {
            e.preventDefault();
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        //handle Select2 field
        $(function() {
            $('.select2').select2()
        });
    </script>
@endpush
