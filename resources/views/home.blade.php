@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-6">

                <div class="small-box bg-secondary">
                    <div class="inner">

                        <h3>{{ $projetSoumis }}</h3>
                        <p>Projet {{ env('projetSoumis') }}</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a href="{{ route('projects.index') }}?filter={{ env('projetSoumis') }}" class="small-box-footer">voir
                        plus <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $projetEncours }}<sup style="font-size: 20px"></sup></h3>
                        <p>Projet {{ env('projetenCours') }}</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a href="{{ route('projects.index') }}?filter={{ env('projetenCours') }}" class="small-box-footer">voir
                        plus <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $projetFinis }}</h3>
                        <p>Projet {{ env('projetTerminer') }}</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a class="small-box-footer"
                        href="{{ route('projects.index') }}?filter={{ env('projetTerminer') }}">voir
                        plus <i class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>


        </div>



    </section>

    <section class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rapport Recapitulatif Mensuel</h5>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center">
                                <strong>{{ \Carbon\Carbon::now() }}</strong>
                            </p>

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Statistique de project</strong>
                            </p>

                            <div class="progress-group ">
                                Projet Soumis
                                <span class="float-right"><b>{{ $projetSoumis }}</b>/{{ $projets }}</span>
                                <div class="progress progress-sm">
                                <span class="float-right"></span>
                                    <div class="progress-bar bg-secondary" style="width: {{($projetSoumis*$projets)/100}}%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->

                            <div class="progress-group">
                                Projet En cours
                                <span class="float-right"><b>{{ $projetEncours }}</b>/{{ $projets }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: {{($projetEncours*$projets)/100}}%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                Projet Cloturé
                                <span class="float-right"><b>{{ $projetFinis }}</b>/{{ $projets }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: {{($projetFinis*$projets)/100}}%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="card-head">
                        <h5 class="card-title">Jalon</h5>

                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fas fa-caret-up"></i>
                                   {{ ($alljalon>0)?number_format(($jalonEnCours * 100) / $alljalon, 1):0 }}%</span>
                                <h5 class="description-header">{{ $jalonEnCours }}</h5>
                                <span class="description-text">{{ env('jalonEnCours') }}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>
                                    {{($alljalon>0)? number_format(($jalonEnAttente * 100) / $alljalon, 1):0 }}%</span>
                                <h5 class="description-header">{{ $jalonEnAttente }}</h5>
                                <span class="description-text">{{ env('jalonEnAttente') }}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fas fa-caret-up"></i>
                                    {{($alljalon>0)? number_format(($jalonCloturer * 100) / $alljalon, 1):0 }}%</span>
                                <h5 class="description-header">{{ $jalonCloturer }}</h5>
                                <span class="description-text">{{ env('jalonCloturer') }}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i>
                                    {{ ($alljalon>0)?number_format((count($jalonEnRetard) * 100) / $alljalon, 1):0 }}%</span>
                                <h5 class="description-header">{{ count($jalonEnRetard) }}</h5>
                                <span class="description-text">en retard</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </section>
    <section class="row">
        <div class="col-5">
            <p data-graphique="<?php echo $data; ?>" id="data-graphique"> </p>
            <p data-graphique2="<?php echo $data2; ?>" id="data-graphique2"></p>
            <input type="hidden" value="{{ $datadonut }}" id="data-donut">
            <section class="connectedSortable ui-sortable">
                <div class="card" style="position: relative; left: 0px; top: 0px;">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Participation
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#sales-chart" data-toggle="tab">Donut</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
    
                            <div class="chart tab-pane " id="revenue-chart" style="position: relative; height: 300px;">
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
    
                            <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;">
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
                                                Homme
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
                                                Femme
                                            </span>
                                        </div>
    
                                    </div>
    
                                </div>
                            </div>
    
                        </div>
    
                    </div>
    
            </section>
           
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reppartion de projet</h3>
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

        </div>
        

    </section>
@endsection
@push('third_party_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
@endpush

@push('page_scripts')
    @vite('resources/css/style.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}>
    </script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/chart.js/Chart.min.js') }}></script>
    {{-- <script type="module" src={{ Vite::asset('resources/js/dashboard.js') }}></script> --}}
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

    <script type="module">
        $(function() {
            var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
            var salesChartData = {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Dec'],
                datasets: [{
                        label: 'Projets soumis',
                        backgroundColor: 'rgba(169, 169, 169, 0.6)',
                        borderColor: 'rgba(169, 169, 169, 2)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(169, 169, 169, 2)',
                        pointBorderColor: 'rgba(169, 169, 169, 2)',
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: 'rgba(169, 169, 169, 2)',
                        pointHoverBorderColor: 'rgba(169, 169, 169, 2)',
                        data: @json($submittedProjects)
                    },
                    {
                        label: 'Projets en cours',
                        backgroundColor: 'rgba(255, 206, 86, 1)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(255, 206, 86, 1)',
                        pointBorderColor: 'rgba(255, 206, 86, 1)',
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: 'rgba(255, 206, 86, 1)',
                        pointHoverBorderColor: 'rgba(255, 206, 86, 1)',
                        data: @json($ongoingProjects)
                    },
                    {
                        label: 'Projets terminés',
                        backgroundColor: 'rgba(2, 150, 2, 0.505)',
                        borderColor: 'rgb(2, 150, 2)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgb(2, 150, 2)',
                        pointBorderColor: 'rgb(2, 150, 2)',
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: 'rgb(2, 150, 2)',
                        pointHoverBorderColor: 'rgb(2, 150, 2)',
                        data: @json($completedProjects)
                    }
                ]
            };

            var salesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            };

            var salesChart = new Chart(salesChartCanvas, {
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
            });
        });
    </script>
@endpush
