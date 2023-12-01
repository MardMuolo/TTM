@extends('layouts.app')
@section('title')
    Rapport
@endsection
@section('filsAriane')
    {{-- <li class="breadcrumb-item"><a href="#"></a></li> --}}
@endsection
@section('content')
    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> Rapports
                    <small class="float-right">{{ \Carbon\Carbon::now() }}</small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info py-4">
            <div class="col-sm-4 invoice-col">
                <label for="debut">Du</label>
                <input type="date" name="debut" id="debut">
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <label for="fin">AU</label>
                <input type="date" name="fin" id="fin">
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <input type="checkbox" name="comite" id="comite">
                <label for="comite">COMCOM</label>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-hover" id="tab_reporting">
                    <thead>
                        <th style="width: 50%">Nom</th>
                        <th style="width: 40%">Équipe</th>
                        <th class="text-center" style="width: 20%">Statut</th>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6 py-4">

            </div>
            <!-- /.col -->
            <div class="col-6 float-right">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>$250.30</td>
                        </tr>
                        <tr>
                            <th>Tax (9.3%)</th>
                            <td>$10.34</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>$5.80</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>$265.24</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="col-6 p-5">
            <p class="lead">Signature</p>
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Approuvé
            </p>
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                        class="fas fa-print"></i> Print</a>
                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                </button>
                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                </button>
            </div>
        </div>
    </div>
@endsection
@push('third_party_scripts')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
@endpush
@push('page_scripts')
    @vite('resources/css/style.css')
    @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
    @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}">
    </script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/jszip/jszip.min.js') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script type='module' src="{{ Vite::asset('node_modules/admin-lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script type='module'
        src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script type='module'>
        $(function() {
            
            var table = $("#tab_reporting").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "data": "",
                "buttons": [{
                    extend: 'csv',
                    title: 'les projects ',

                }, "excel", {
                    extend: 'pdf',
                    title: 'les projects ',

                }, {
                    extend: 'print',
                    title: 'les projects '
                }, "colvis"]
            });
            var initialData=table.data().toArray();
            $('#comite').on('click', function() {
                // alert('bonjour')
                // Vérifier si la case à cocher est cochée ou décochée
                if ($(this).is(':checked')) {
                    // Effectuer la requête AJAX lorsque la case est cochée
                    $.ajax({
                        url: '{{ route('projectReporting') . '?is_comite=1' }}',
                        type: 'Get',
                        dataType: 'json',
                        // data: {
                        //     param1: 'valeur1',
                        //     param2: 'valeur2'
                        // },
                        success: function(response) {
                            table.destroy()
                            console.log(response)
                            table=$("#tab_reporting").DataTable({
                                "responsive": true,
                                "lengthChange": true,
                                "autoWidth": true,
                                "searching": true,
                                "ordering": true,
                                "paging": true,
                                "data": {
                                    "data": response
                                },
                            });

                        },
                        error: function(xhr, status, error) {
                            // Gestion des erreurs
                        }
                    });
                } else {
                    table.clear().rows.add(initialData).draw()
                }
            });
        });
    </script>
    <script>
        function supprimer(event) {
            event.preventDefault();
            a = event.target.closest('a');

            let deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', a.getAttribute('href'));
            let textDelete = document.getElementById('textDelete');
            textDelete.innerHTML = a.getAttribute('project') + " ?";

            let titleDelete = document.getElementById('titleDelete');
            titleDelete.innerHTML = "Suppression";
        }
    </script>



    <script type="module">
        // Attacher un gestionnaire d'événements au clic sur la case à cocher
    </script>
@endpush
