@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gray">
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

            <div class="col-lg-3 col-6">
                <div class="small-box bg-orange">
                    <div class="inner">

                        <h3>{{ $projetEncours }}</h3>
                        <p>Projet {{ env('projetenCours') }}</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a href="{{ route('projects.index') }}?filter={{ env('projetSoumis') }}" class="small-box-footer">voir
                        plus <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $projetEncours }}<sup style="font-size: 20px"></sup></h3>
                        <p>Projet {{ env('projetCloturer') }}</p>
                    </div>
                    <div class="icon">
                        <i class=""></i>
                    </div>
                    <a href="{{ route('projects.index') }}?filter={{ env('projetenCours') }}"
                        class="small-box-footer">voir
                        plus <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

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
        <div class="col-md-12 px-3">
            <div class="card ">
                <div class="card-header bg-black text-orange">
                    <h5 class="card-title">Rapport Recapitulatif Mensuel</h5>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus text-orange"></i>
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
                                <b>Projet Prévu</b>
                                <span class="float-right"><b>{{ $projetSoumis }}</b>/{{ $projets }}</span>
                                <div class="progress progress-sm">
                                    <span class="float-right"></span>
                                    <div class="progress-bar bg-orange"
                                        style="width: {{ ($projetSoumis * 100) / $projets }}%">
                                    </div>
                                </div>
                            </div>
                            <!-- /.progress-group -->

                            <div class="progress-group">
                                <b>Projet En cours</b>
                                <span class="float-right"><b>{{ $projetEncours }}</b>/{{ $projets }} </span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-orange"
                                        style="width: {{ ($projetEncours * 100) / $projets }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <b>Projet Cloturé</b>
                                <span class="float-right"><b>{{ $projetEncours }}</b>/{{ $projets }} </span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-yellow"
                                        style="width: {{ ($projetEncours * 100) / $projets }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <b>Projet Terminé</b>
                                <span class="float-right"><b>{{ $projetFinis }}</b>/{{ $projets }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ ($projetFinis * 100) / $projets }}%">
                                    </div>
                                </div>
                            </div>

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
                                <span class="description-percentage text-yellow"><i class="fas fa-caret-up"></i>
                                    {{ $alljalon > 0 ? number_format(($jalonEnCours * 100) / $alljalon, 1) : 0 }}%
                                </span>
                                <h5 class="description-header">{{ $jalonEnCours }}</h5>
                                <span class="description-text">
                                    {{ env('jalonEnCours') }}
                                    <a href="{{ route('filtrage.index') }}" class="small-box-footer">
                                        <i class="fas fa-arrow-circle-right text-black"></i>
                                    </a>
                                </span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-orange"><i class="fas fa-caret-left"></i>
                                    {{ $alljalon > 0 ? number_format(($jalonEnAttente * 100) / $alljalon, 1) : 0 }}%
                                </span>
                                <h5 class="description-header">{{ $jalonEnAttente }}</h5>
                                <span class="description-text">
                                    {{ env('jalonEnAttente') }}
                                    <a href="{{ route('projects.index') }}" class="small-box-footer">
                                        <i class="fas fa-arrow-circle-right text-black"></i>
                                    </a>
                                </span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage"><i class="fas fa-caret-up"></i>
                                    {{ $alljalon > 0 ? number_format(($jalonCloturer * 100) / $alljalon, 1) : 0 }}%
                                </span>
                                <h5 class="description-header">{{ $jalonCloturer }}</h5>
                                <span class="description-text">
                                    {{ env('jalonCloturer') }}
                                    <a href="{{ route('projects.index') }}" class="small-box-footer">
                                        <i class="fas fa-arrow-circle-right text-black"></i>
                                    </a>
                                </span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i>
                                    {{ $alljalon > 0 ? number_format((count($jalonEnRetard) * 100) / $alljalon, 1) : 0 }}%</span>
                                <h5 class="description-header">{{ count($jalonEnRetard) }}</h5>
                                <span class="description-text">
                                    en retard
                                    <a href="{{ route('projects.index') }}?filter={{ env('projetenCours') }}"
                                        class="small-box-footer"><i class="fas fa-arrow-circle-right text-black"></i></a>
                                </span>
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

@endsection
@push('third_party_scripts')
    <script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js?commonjs-entry') }}"></script>
@endpush

@push('page_scripts')
    @vite('resources/css/style.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js?commonjs-entry') }}>
    </script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/chart.js/Chart.min.js?commonjs-entry') }}>
    </script>
    {{-- <script type="module" src={{ Vite::asset('resources/js/dashboard.js?commonjs-entry') }}></script> --}}
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/summernote/summernote-bs4.min.js?commonjs-entry') }}></script>
    <script type="module" src={{ Vite::asset('resources/js/graphique.js') }}></script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js?commonjs-entry') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?commonjs-entry') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js?commonjs-entry') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js?commonjs-entry') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js?commonjs-entry') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js?commonjs-entry') }}>
    </script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/jszip/jszip.min.js?commonjs-entry') }}>
    </script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js?commonjs-entry') }}>
    </script>
    <script type="module" src={{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js') }}></script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js?commonjs-entry') }}>
    </script>
    <script type="module"
        src={{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js?commonjs-entry') }}>
    </script>
    <script type="module" src={{ Vite::asset('resources/js/tableau.js') }}></script>

    <script type="module">
        $(function() {
            var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
            var salesChartData = {
                labels: @json($labels),
                datasets: [{
                        label: 'Projets prévu',
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
                        label: 'Projets lancés',
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
