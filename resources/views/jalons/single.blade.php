@extends('layouts.app')
@section('title')
    {{ $jalon->designation }}
@endsection
@section('filsAriane')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a></li>
    <li class="breadcrumb-item"><a href="#">{{ $jalon->designation }}</a></li>
@endsection
@section('content')
    <section class="content">
        <!-- Vue -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            @if (empty($debutDate) && empty($echeance))
                <div class="row ml-2">
                    <div class="text-right mr-2">
                        @if (auth()->user()->name == $project->projectOwner)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="far fa-calendar-alt"></i>
                            </button>
                        @endif

                    </div>
                    <div class="mt-2">
                        <p>Veuillez planifier les dates pour ce jalon.</p>
                    </div>
                </div>
            @else
                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            @if (!empty($debutDate))
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="far fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Date Début</span>
                                        <span
                                            class="info-box-number">{{ \Carbon\Carbon::parse($debutDate)->format('d/m/Y') }}</span>
                                    </div>

                                </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            @if (!empty($echeance))
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="far fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Date Fin</span>
                                        <span
                                            class="info-box-number">{{ \Carbon\Carbon::parse($echeance)->format('d/m/Y') }}</span>
                                    </div>
                                    @if ($status == 'Finis')
                                        <span class="info-box-number"><button type="button"
                                                class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                title="Ce jalon est finis" disabled data-target="#modal-date">
                                                <i class="fas fa-edit"></i>
                                            </button></span>
                                    @else
                                        <span class="info-box-number"><button type="button"
                                                class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                data-target="#modal-date">
                                                <i class="fas fa-edit"></i>
                                            </button></span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Décider de la fin du jalon</span>
                                    <span class="info-box-number">
                                        @if ($status == 'Finis')
                                            <button type="button" class="btn btn-light btn-sm float-right"
                                                data-toggle="modal" data-target="#modal-fin-jalon"
                                                title="ce jalon est finis" disabled>
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        @else
                                            @if (auth()->user()->name == $project->projectOwner)
                                                <span class="info-box-number"><button type="button"
                                                        class="btn btn-light btn-sm float-right" data-toggle="modal"
                                                        data-target="#modal-fin-jalon">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button></span>
                                            @endif
                                        @endif
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-history"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">
                                        <div class="card-tools">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Historique des dates</button>
                                                <div class="dropdown-menu float-right text-scroll" role="menu">
                                                    @forelse ($historiques->reverse() as $historique)
                                                    <del>
                                                        <a href="#" class="dropdown-item">{{ \Carbon\Carbon::parse($historique->date_initiale)->format('d/m/Y') }}</a>
                                                    </del>
                                                @empty
                                                    <div class="ml-2">Date non repoussée pour le moment</div>
                                                @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif


        <div class="card">
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row justify-content-end text-right">
                        @if (auth()->user()->name == $project->projectOwner)
                            <div class="col-sm-12 col-md-6">
                                @if (empty($debutDate) || empty($echeance) || $status == 'Finis')
                                    @if (auth()->user()->name == $project->projectOwner)
                                        <button class="btn btn-light m-2"
                                            title="{{ $status == 'Finis' ? 'Ce jalon est fini' : 'Veuillez d\'abord définir les dates' }}"
                                            disabled>
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-light m-2" title="Ajouter une demande" data-toggle="modal"
                                        data-target="#create_modal">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending"
                                            style="">Livrable attendu</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending"
                                            style="">Asigné à</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending"
                                            style="">Date prévue</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending"
                                            style="">Date réelle</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending"
                                            style="">Retard de livraison</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                            Status
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending">Avis
                                            directeur
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($demandes as $item)
                                        <tr class="odd">

                                            <td style="" class="dtr-control" tabindex="0">
                                                <div class="row">
                                                    <div class="col">
                                                        {{$item->demande->title}}        
                                                    </div>
                                                        @php
                                                            $data = json_encode($item)
                                                        @endphp
                                                    <div class="row mr-2 data_demande_edit"  data="{{$data}}">
                                                        @if (empty($is_active))
                                                            <a class="nav-link" data-widget="control-sidebar"
                                                                data-controlsidebar-slide="true"
                                                                data-target="#edit-{{ $item->id }}"
                                                                href="#edit-{{ $item->id }}" role="button">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->name == $project->projectOwner)
                                                            @if ($status == 'Finis')
                                                                <a class="nav-link disabled" data-widget="control-sidebar"
                                                                    data-controlsidebar-slide="true"
                                                                    data-target="#edit-{{ $item->id }}-edit"
                                                                    href="#edit-{{ $item->id }}-edit"
                                                                    data-toggle="tooltip" title="Ce jalon est fini"
                                                                    role="button">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                <button type="button" class="btn btn-sm disabled"
                                                                    title="Ce jalon est Finis" data-toggle="modal"
                                                                    data-target="#deleteModal-{{ $item->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                            @php
                                                                $item->oneContributeur;
                                                                $data = json_encode($item)
                                                            @endphp
                                                                <span class="d-none"> {{$data}}  </span>
                                                                <a class="nav-link fas fa-edit" onclick="update_demande(event)" data-widget="control-sidebar"
                                                                    data-controlsidebar-slide="true"
                                                                    data-target="#edit-edit"
                                                                    href="#edit-edit" role="button">

                                                                    {{-- <i class="fas fa-edit update_demande" onclick="update_demande(event, '{{$data}}')"></i> --}}
                                                                </a>

                                                                <button type="button" class="btn btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteModal-{{ $item->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                            <td style="">
                                                {{ $item->contributeur }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->date_prevue)->format('d/m/Y') }} </td>
                                            <td>
                                                @if ($item->date_reelle)
                                                    {{ \Carbon\Carbon::parse($item->date_reelle)->format('d/m/Y') }}
                                                @else
                                                    pas de date
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->date_reelle && $item->date_reelle <= $item->date_prevue)
                                                    <small class="badge badge-success">Pas de retard observé</small>
                                                @elseif ($item->retard === null)
                                                    <small class="badge badge-success">Pas de retard observé</small>
                                                @else
                                                    @if ($item->retard === 0)
                                                        <small class="badge badge-warning">{{ $item->retard }}
                                                            jour</small>
                                                    @else
                                                        <small class="badge badge-danger">{{ $item->retard }}
                                                            jour{{ $item->retard > 1 ? 's' : '' }}</small>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status === 'Soumis')
                                                    <small class="badge badge-success">{{ $item->status }}</small>
                                                @elseif ($item->status === 'rejeté')
                                                    <small class="badge badge-danger">{{ $item->status }}</small>
                                                @elseif ($item->status === 'à corriger')
                                                    <small class="badge badge-warning">{{ $item->status }}</small>
                                                @else
                                                    <small class="badge badge-light">{{ $item->status }}</small>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="row">
                                                    <a class="nav-link" data-widget="control-sidebar"
                                                        data-controlsidebar-slide="true"
                                                        data-target="#edit-{{ $item->id }}-3"
                                                        href="#edit-{{ $item->id }}-3" role="button">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if ($status == 'Finis')
                                                        <a class="nav-link disabled" data-widget="control-sidebar"
                                                            data-controlsidebar-slide="true"
                                                            data-target="#edit-{{ $item->id }}-2"
                                                            href="#edit-{{ $item->id }}-2" role="button"
                                                            title="Ce jalon est fini">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                    @else
                                                        <a class="nav-link" data-widget="control-sidebar"
                                                            data-controlsidebar-slide="true"
                                                            data-target="#edit-{{ $item->id }}-2"
                                                            href="#edit-{{ $item->id }}-2" role="button">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="col-lg-12  text-center text-black-50 h5">
                                            <td colspan="6"> Aucune demande créée</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
            @include('jalons.create')
            @include('demande.delete')
        </div>
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Date pour le Jalons {{ $jalon->designation }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                        action="{{ route('jalons.addDate', ['jalon' => $jalon->id, 'option_ttm' => $optionTtm->id, 'project' => $project->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col">
                            <div class="col">
                                <div class="form-group">
                                    <label for="debutDate">Date Début</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" inputformat="mm/dd/yyyy"
                                            name="debutDate" id="debutDate">
                                    </div>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="echeance">Date Fin</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" inputformat="mm/dd/yyyy"
                                            name="echeance" id="echeance">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                              </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-date">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Repouser l'écheance</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST"
                        action="{{ route('repouserDate', ['jalon' => $jalon->id, 'option_ttm' => $optionTtm->id, 'project' => $project->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="col">
                            <div class="col">
                                <div class="form-group">
                                    <label for="echeance">Date Fin</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" value="{{ $echeance }}"
                                            inputformat="mm/dd/yyyy" name="echeance" id="echeance">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                              </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($totalDemandes == 0)
        <div class="modal fade" id="modal-fin-jalon" tabindex="-1" role="dialog"
            aria-labelledby="modal-fin-jalon-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-finish-jalon-label">Message d'avertissement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Veuillez ajouter des demandes.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @elseif($status == 'Finis')
        <div class="modal fade" id="modal-fin-jalon" tabindex="-1" role="dialog"
            aria-labelledby="modal-fin-jalon-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-finish-jalon-label">Message d'avertissement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Le jalon est declaré comme Finis.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="modal-fin-jalon" tabindex="-1" role="dialog"
            aria-labelledby="modal-fin-jalon-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    @if ($demandesSoumises < $totalDemandes)
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-finish-jalon-label">Message d'avertissement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Toutes les demandes doivent être soumises avant de terminer le jalon.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    @else
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-finish-jalon-label">Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('jalons.updateStatus', ['jalon' => $jalon->id, 'option_ttm' => $optionTtm->id, 'project' => $project->id]) }}" method="POST" style="display: inline" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                              <p>Voulez-vous marquer ce jalon comme étant fini ?</p>
                              <div class="form-group">
                                <label for="jalonPv">Sélectionnez un fichier :</label>
                                <input type="file" class="form-control-file" name="jalonPv" id="jalonPv" required>
                              </div>
                            </div>
                            <input type="hidden" name="status" value="Finis">
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i></button>
                              <button type="submit" class="btn btn-primary" id="submitBtn" disabled><i class="fa fa-check"></i></button>
                            </div>
                          </form>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @foreach ($demandes as $item)
        <aside class="control-sidebar control-sidebar-light" style="top: 57px; height: 568px; display: block;width: 50%;"
            id="edit-{{ $item->id }}">
            <div class="p-3 control-sidebar-content os-host os-theme-light os-host-resize-disabled  os-host-transition os-host-overflow os-host-overflow-y"
                style="height: 568px;">
                <div class="os-padding">
                    <div class="os-viewport">
                        <div style="position: absolute; top: 0; left: 0;">
                            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                                data-target="#edit-{{ $item->id }}" href="#edit-{{ $item->id }}"
                                role="button">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>

                        <div class="card card-default m-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i>
                                    Information sur la demande
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="callout callout-danger">
                                    <h5>{{ $item->title }}</h5>
                                    <p>{{ $item->description }}</p>
                                    <small>Assigné à : {{ $item->contributeur }}  dans un delais de
                                        {{ $item->deadLine }}</small>
                                </div>
                            </div>
                            <div class="card-footer ">

                                @foreach (explode(',', $item->pathTask) as $file)
                                    <div>
                                        <a href="{{ asset('storage/demandes/' . basename($file)) }}" download
                                            class="btn btn-default">
                                            <i class="fas fa-download"></i> Télécharger
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card m-3">
                                <div class="card-header d-flex p-0">
                                    <h3 class="card-title p-3 font-weight-bold">Livrable pour {{ $item->title }}</h3>
                                    <ul class="nav nav-pills ml-auto p-2">
                                        @php
                                            $m = App\Models\Livrable::where('demande_id', $item->id)->get();
                                        @endphp
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#tabOne_{{ $item->id }}"
                                                data-toggle="tab"><i class="fa fa-eye"></i></a>
                                        </li>
                                        @if ($m->count() == 0)
                                            <li class="nav-item">
                                                @if (auth()->user()->name == $item->contributeur)
                                                    @if ($status == 'Finis')
                                                        <a class="nav-link disabled" href="#tabTwo_{{ $item->id }}"
                                                            data-toggle="tab" title="Ce jalon est fini">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    @else
                                                        <a class="nav-link" href="#tabTwo_{{ $item->id }}"
                                                            data-toggle="tab">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            @if ($status == 'Finis')
                                                <a class="nav-link disabled" href="#tabTree_{{ $item->id }}"
                                                    data-toggle="tab"><i class="fa fa-edit"></i></a>
                                            @else
                                                <a class="nav-link" href="#tabTree_{{ $item->id }}"
                                                    data-toggle="tab"><i class="fa fa-edit"></i></a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tabTwo_{{ $item->id }}">
                                            @if ($m->count() == 0)
                                                <form action="{{ route('livrables.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <input hidden name="demande_id" value="{{ $item->id }}">
                                                    <input hidden name="nom" value="{{ $item->title }}">

                                                    <div class="form-group">
                                                        <label for="description">Description :</label>
                                                        <textarea name="description" id="description" class="form-control" required></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fichier">Fichier :</label>
                                                        <input type="file" name="file[]" id="fichier"
                                                            class="form-control-file" required multiple>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                                </form>
                                            @endif
                                        </div>

                                        <div class="tab-pane active" id="tabOne_{{ $item->id }}">
                                            <?php $m = App\Models\Livrable::where('demande_id', $item->id)->get(); ?>
                                            @forelse ($m as $livrable)
                                                <div class="card-body">
                                                    <div class="callout callout-danger">
                                                        <h5>{{ $item->title }}</h5>
                                                        <p>{{ $livrable->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <small>Fichiers : @foreach (explode(',', $livrable->file) as $path)
                                                            <li>
                                                                <a href="{{ asset('storage/livrable/' . basename($path)) }}"
                                                                    class="btn btn-default">
                                                                    <i class="fa fa-download"></i> {{ basename($path) }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </small>
                                                </div>

                                                <div class="box-body">
                                                    <p></p>
                                                    <ul class="livrable-list">

                                                    </ul>
                                                </div>
                                            @empty
                                                Veuillez soumettre un livrable
                                            @endforelse
                                        </div>
                                        <div class="tab-pane" id="tabTree_{{ $item->id }}">
                                            @forelse ($m as $livrable)
                                                <form action="{{ route('livrables.update', $livrable->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <input hidden name="demande_id" value="{{ $item->id }}">
                                                    <div class="form-group">
                                                        <label for="description">Description :</label>
                                                        <textarea name="description" id="description" class="form-control" required>{{ $livrable->description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fichier">Fichier :</label>
                                                        <input type="file" name="file[]" id="fichier"
                                                            class="form-control-file" multiple>
                                                        @if (is_array($livrable->file))
                                                            <span>Fichiers actuels :</span>
                                                            @foreach ($livrable->file as $filePath)
                                                                <p>{{ $filePath }}</p>
                                                            @endforeach
                                                        @elseif($livrable->file)
                                                            <span>Fichier actuel :</span>
                                                            <p>{{ $livrable->file }}</p>
                                                        @endif
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                                </form>
                                            @empty
                                                Aucun fichier pour le moment
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </aside>
    @endforeach
    @include('validation.index')
    @include('jalons.edit')
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var jalonPvInput = document.getElementById('jalonPv');
        var submitBtn = document.getElementById('submitBtn');
        
        jalonPvInput.addEventListener('change', function() {
            if (jalonPvInput.value !== '') {
            submitBtn.disabled = false;
            } else {
            submitBtn.disabled = true;
            }
        });
        });
    </script>
    <script src="dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.nav-link.disabled').on('click', function(e) {
                e.preventDefault();
            });
        });
    </script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     var categorySelect = document.getElementById('category');
    //     var demandeSelect = document.getElementById('demande');
    //     var demandeOptions = Array.from(demandeSelect.options);

    //     categorySelect.addEventListener('change', function() {
    //         var selectedCategoryId = categorySelect.value;

    //         // Réinitialiser les options de demande
    //         demandeSelect.innerHTML = '<option value="">Sélectionnez une demande</option>';

    //         // Filtrer et afficher uniquement les options de demande de la catégorie sélectionnée
    //         var filteredOptions = demandeOptions.filter(function(option) {
    //             var optionCat = option.getAttribute('data-cat');
    //             return optionCat === selectedCategoryId || selectedCategoryId === '';
    //         });

    //         // Ajouter les options filtrées à la liste de demandes
    //         filteredOptions.forEach(function(option) {
    //             demandeSelect.appendChild(option.cloneNode(true));
    //         });
    //     });
    // });
</script>
@endsection


@push('third_party_scripts')
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="module" src="{{ Vite::asset('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="module" src="{{ vite::asset('node_modules/admin-lte/dist/js/demo.js') }}"></script>    
@endpush

@push('page_css')
   @vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')
   @vite('node_modules/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')
   @vite('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')
   @vite('node_modules/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')
   @vite('node_modules/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')
@endpush
@push('page_scripts')
<script type="module">
    $(document).ready(function() {
        if (true) {
            (async () => {
    
                /* inputOptions can be an object or Promise */
                const inputOptions = new Promise((resolve) => {
                    setTimeout(() => {
                        resolve({
                            'd': 2
                        })
                    }, 800)
                })
                const {
                    value: sondage
                } = await Swal.fire({
                    icon: 'success',
                    title: '<h2 class="text-success">Création avec Succès</h2> ',
                    html: 'Le score est de <span class="text-black-50 h6">{{ $score ?? 'N/A' }}</span> et le projet est retenu en mode <span class="text-black-50 h6">{{ $options->nom ?? 'N/A' }}</span><br> Veuillez préciser les dates des jalons du projet',
                    })
    
      
    
    
            })()
        }
    
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
                            text: user.last_name + ' ' + user.first_name,
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

                    $('#manager').select2({
                        data: formattedData,
                        minimumInputLength: 1
                    });
    
    
                    // Événement de sélection d'utilisateur
                    $('#user').on('select2:select', function(e) {
                        var selectedUser = e.params.data;
    
                        // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                        // $('#user').val(selectedUser.username);
                        $('#username').val(selectedUser.username);
                        $('#inputEmail').val(selectedUser.email);
                        $('#name').val(selectedUser.text);
    
                        var fullName = selectedUser.first_name + ' ' + selectedUser
                            .last_name;
                        $('#name').val(fullName);
                    });

                    // Événement de sélection d'utilisateur
                    $('#manager').on('select2:select', function(e) {
                        var selectedUser = e.params.data;
    
                        // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                        // $('#user').val(selectedUser.username);
                        $('#username_manager').val(selectedUser.username);
                        $('#inputEmail_manager').val(selectedUser.email);
                        $('#name_manager').val(selectedUser.text);
    
                        var fullName = selectedUser.first_name + ' ' + selectedUser
                            .last_name;
                        $('#name').val(fullName);
                    });

                    /****************************************************************************************/
                    // $('.user_edit').select2({
                    //     data: formattedData,
                    //     minimumInputLength: 1
                    // });

                    // $('.manager_edit').select2({
                    //     data: formattedData,
                    //     minimumInputLength: 1
                    // });
    
    
                    // Événement de sélection d'utilisateur
                    // $('.user_edit').on('select2:select', function(e) {
                    //     var selectedUser = e.params.data;
    
                    //     // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                    //     // $('#user').val(selectedUser.username);
                    //     $('#username').val(selectedUser.username);
                    //     $('#inputEmail').val(selectedUser.email);
                    //     $('#name').val(selectedUser.text);
    
                    //     var fullName = selectedUser.first_name + ' ' + selectedUser
                    //         .last_name;
                    //     $('#name').val(fullName);
                    // });

                    // // Événement de sélection d'utilisateur
                    // $('.manager_edit').on('select2:select', function(e) {
                    //     var selectedUser = e.params.data;
    
                    //     // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                    //     // $('#user').val(selectedUser.username);
                    //     $('#username_manager').val(selectedUser.username);
                    //     $('#inputEmail_manager').val(selectedUser.email);
                    //     $('#name_manager').val(selectedUser.text);
    
                    //     var fullName = selectedUser.first_name + ' ' + selectedUser
                    //         .last_name;
                    //     $('#name').val(fullName);
                    // });
                } else {
                    console.log('Erreur: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Erreur AJAX: ' + error);
            }
        });

        
        // $.ajax({
        //     url: '/directions.index/?direction_id='+directionId,
        //     dataType: 'json',
        //     success: function(response) {
    
        //         if (response.success) {
        //             var data = response.users;
    
        //             var formattedData = data.map(function(user) {
        //                 return {
        //                     id: directiion.id,
        //                     name: direction.name,
    
        //                 };
        //             });
    
        //             // Initialiser le champ de sélection avec les options
        //             $('#direction').select2({
        //                 data: formattedData,
        //                 minimumInputLength: 1
        //             });
    
        //             // Événement de sélection d'utilisateur
        //             $('#direction').on('select2:select', function(e) {
        //                 var selectedUser = e.params.data;
    
        //                 // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
        //                 // $('#user').val(selectedUser.username);
        //                 $('#directionName').val(selectedUser.name);
        //                 $('#directionId').val(selectedUser.id);
        //             });
        //         } else {
        //             console.log('Erreur: ' + response.message);
        //         }
        //     },
        //     error: function(xhr, status, error) {
        //         console.log('Erreur AJAX: ' + error);
        //     }
         });
       
    function supprimer(event) {
        event.preventDefault();
        a = event.target.closest('a');
    
        let deleteForm = document.getElementById('deleteForm');
        deleteForm.setAttribute('action', a.getAttribute('href'));
    
        let textDelete = document.getElementById('textDelete');
        textDelete.innerHTML = a.getAttribute('item') + " ?";
    
        let titleDelete = document.getElementById('titleDelete');
        titleDelete.innerHTML = "Suppression";
    
    
    
    }

    
  </script>

  <script>
    function update_demande(event) {
            var td = event.target.previousElementSibling;
            var data = JSON.parse(td.textContent);
            console.log(data);
            description_edit.value = data.description;
            demande_file.textContent = data.pathTask;
            var tb = data.deadLine.split(' ');
            form_edit.deadLine.value = tb[0];
            form_edit.deadline_unit.value = tb[1];
            form_edit.category_edit.value = data.demande.category_demande_id;
            form_edit.demande_edit.value = data.demande.id;
            
            form_edit.contributeur.value = data.one_contributeur.id;
            $("#user_edit").select2();

            }
  </script>
@endpush
