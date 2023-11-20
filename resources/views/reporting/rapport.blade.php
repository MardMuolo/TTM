@extends('layouts.app')
@section('title')
    Rapport
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Rapports</a></li>
@endsection
@section('content')
    <section class="content">

        <div class="card">


            <div class="card-body">

                <form action="" method="get" class="mb-3">
                    <div>
                        <label for="from" class=" non-gras" style="font-weight: normal; ">De</label>
                        <input type="date" id="debut" name="debut" style=" height:30px;">
                        <label for="to" class=" non-gras" style="font-weight: normal;">A</label>
                        <input type="date" id="fin" name="fin" style=" height:30px;">
                    </div>
                    <div class="row">



                        <div class="col-2">
                            <label class="non-gras" style="font-weight: normal; height:10px;">Directions</label>
                            <select aria-label=".form-select-sm " name="direction" class="form-control " placeholder=""
                                style=" height:30px;">
                                <option value=""></option>
                                @forelse ($directions as $direction)
                                    <option value="{{ $direction->name }}">{{ $direction->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label class=" non-gras" style="font-weight: normal; height:10px;">Option TTM</label>
                            <select aria-label=".form-select-sm " class="form-control" placeholder=""name="optionttm"
                                style=" height:30px;">
                                <option value=""></option>
                                @forelse ($optionttms as $option)
                                    <option value="{{ $option->nom }}">{{ $option->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label class=" non-gras" style="font-weight: normal; height:10px;">Initiateur</label>
                            <select aria-label=".form-select-sm " class="form-control" placeholder="" name="user"
                                style=" height:30px;">

                                <option value=""></option>
                                @forelse ($projectOwners as $po)
                                    <option value="{{ $po->projectOwner }}">{{ $po->projectOwner }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="non-gras" style="font-weight: normal; height:10px;">Statut</label>
                            <select aria-label=".form-select-sm " class="form-control" placeholder=""name="statut"
                                style=" height:30px;">

                                <option value=""></option>
                                <option value="onWait">Soumis</option>
                                <option value="progress">En cours</option>
                                <option value="finish">Fini</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label class=" non-gras" style="font-weight: normal; height:10px;" for="">Jalons</label>
                            <select aria-label=".form-select-sm " class="form-control" placeholder=""name="jalon"
                                style=" height:30px;">
                                <option value=""></option>
                                @forelse ($jalons as $jalon)
                                    <option value="{{ $jalon }}">{{ $jalon->designation }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="col-1">
                            <label for=""></label> <br>
                            <div> <button type="submit" class="btn btn-light"><i class="fas fa-filter"></i></button></div>
                        </div>
                        <div class="col-1">
                            <label for=""></label> <br>
                            <div>
                                <button type="button btn-success" class="btn btn-success" onclick="exportToExcel()">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                </form>

                <table class="table table-striped projects" id="example1">

                    <thead>
                        <tr>
                            <th style="width: 50%">Nom</th>
                            <th style="width: 40%">Équipe</th>
                            <th class="text-center" style="width: 20%">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projets as $item)
                            <tr>
                                <td>
                                    <strong class="text-black">{{ $item->name }}</strong><br>
                                    <small>
                                        <b class="text-black-50">Du:</b> {{ $item->startDate }} - <b
                                            class="text-black-50">Au:</b> {{ $item->endDate }}
                                    </small>
                                </td>
                                <td>
                                    @forelse ($item->users as $membres)
                                        <li class="list-inline-item">
                                            <span title="{{ $membres->pivot->role }}"
                                                class="badge bg-{{ $tab[array_rand(array_keys($tab), 1)] }}  text-center">{{ $membres->username }}</span>
                                        </li>
                                    @empty
                                        <ul class="list-inline">
                                            <li class="list-inline-item text-black-50 h6">Aucun membre pour l'instant</li>
                                        </ul>
                                    @endforelse
                                </td>
                                <td class="project-state">
                                    <span class="badge ">{{ $item->status }}</span>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            @include('layouts.delete')
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();
        });
    </script>

    <script>
        function exportToExcel() {

            var table = document.getElementById("example1");
            var html = table.outerHTML;


            var url = 'data:application/vnd.ms-excel;base64,' + window.btoa(html);


            var a = document.createElement("a");
            a.href = url;
            a.download = "projets.xls";
            a.style.display = "none";
            document.body.appendChild(a);


            a.click();


            document.body.removeChild(a);
        }
    </script>

    <script>
        var debutInput = document.getElementById("debut");
        var finInput = document.getElementById("fin");


        debutInput.addEventListener("change", function() {

            var debutDate = new Date(debutInput.value);


            var finDate = new Date(finInput.value);


            if (finDate < debutDate) {

                finInput.value = debutInput.value;
            }


            finInput.min = debutInput.value;
        });


        finInput.addEventListener("change", function() {

            var debutDate = new Date(debutInput.value);


            var finDate = new Date(finInput.value);


            if (finDate < debutDate) {

                finInput.value = debutInput.value;
            }
        });
    </script>
@endsection
