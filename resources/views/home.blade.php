@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-6">

                <div class="small-box bg-secondary">
                    <div class="inner">

                        <h3>{{ $projetSoumis }}</h3>
                        <p>Projets soumis</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a href="{{ route('projects.index') }}?filter={{env('projetSoumis')}}" class="small-box-footer">voir plus <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $projetEncours }}<sup style="font-size: 20px"></sup></h3>
                        <p>Projets en cours</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a href="{{ route('projects.index') }}?filter={{env('projetenCours')}}" class="small-box-footer">voir plus <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $projetFinis }}</h3>
                        <p>Projets finis</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a class="small-box-footer" href="{{ route('projects.index') }}?filter={{env('projetTerminer')}}">voir plus <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>


        </div>



    </section>

    <div class="row">

        <p data-graphique="<?php echo $data; ?>" id="data-graphique"> </p>
        <p data-graphique2="<?php echo $data2; ?>" id="data-graphique2"></p>


        <input type="hidden" value="{{ $datadonut }}" id="data-donut">

        <section class="col-lg-6 connectedSortable ui-sortable">


            <div class="card" style="position: relative; left: 0px; top: 0px;">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Projets
                    </h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">

                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class="" id="data"> </div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="revenue-chart-canvas" height="300"
                                style="height: 300px; display: block; width: 211px;" width="211"
                                class="chartjs-render-monitor">
                            </canvas>
                        </div>

                        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="sales-chart-canvas" height="300"
                                style="height: 300px; display: block; width: 576px;" class="chartjs-render-monitor"
                                width="576">
                            </canvas>

                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box " style="background-color: rgba(60,141,188,0.9)">

                                    <div class="info-box-content">
                                        <span class="info-box-text"></span>
                                        <span class="info-box-number">{{ $projetsEncours }}</span>

                                        <span class="progress-description">
                                            {{ $annee }}
                                        </span>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box bg-secondary">

                                    <div class="info-box-content">
                                        <span class="info-box-text"></span>
                                        <span class="info-box-number">{{ $projetsPrec }}</span>

                                        <span class="progress-description">
                                            {{ $annePrec }}
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

        </section>
        <section class="col-lg-5 connectedSortable ui-sortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tableProjet" class="table table-bordered table-striped">
                        <thead>
                            <th>N°</th>
                            <th>Directions</th>
                            <th>Total projets</th>
                            <th>Projets finis</th>
                        </thead>
                        <tbody>
                            @foreach ($directions as $i => $projet)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $projet->name }}</td>
                                    <td>{{ $projet->nb_projet }}</td>
                                    <td>{{ $projet->nb_projetFinis }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </section>


    </div>
    </div>
@endsection
@push('third_party_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
@endpush

@push('page_scripts')
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}>
    </script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/chart.js/Chart.min.js') }}></script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/summernote/summernote-bs4.min.js') }}>
    </script>
    <script type="module" src={{ Vite::asset('resources/js/graphique.js') }}></script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}></script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}></script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}></script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/jszip/jszip.min.js') }}></script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js') }}></script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js') }}></script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}></script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js') }}></script>
    <script type="module" src={{ Vite::asset('resources/js/tableau.js') }}></script>
@endpush
