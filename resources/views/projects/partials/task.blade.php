<div class="col-12">
    <div class="">

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10%">#</th>
                        <th style="width: 30%">Titre</th>
                        <th style="width: 30%">assigné à</th>
                        <th style="width: 30%">action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demandes as $demande)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <p> {{ $demande->title }}</p>
                                <p>{{ $demande->description }}</p>
                            </td>
                            <td>{{ $demande->contributeur }}</td>
                        </tr>
                    @empty
                        <tr class="text-center h6 text-black-50">
                            <td colspan="12"> Aucune demande pour le moment</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
        <!-- /.card-body -->

    </div>

    <!-- /.card -->
</div>
