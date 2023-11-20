<div class="modal fade edit-form" id="edit-{{ $optionTtm->id }}">
    <div class="modal-dialog">
            <div class="modal-content">               
                    <div class="modal-header">
                        <h3 class="modal-title">Modification Option Ttm</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('optionsttm.update', $optionTtm->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Nom <span class="text-red">*</span></label>
                                        <input type="text" class="form-control"
                                            value="{{ $optionTtm->nom }}" name="nom">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Jalon</label>
                                        <select class="form-control form-control" id="select-multiple" name="jalons[]" multiple >
                                            @foreach ($jalons as $jalon)
                                                <option value="{{ $jalon->id }}" {{ in_array($jalon->id, $optionTtm->jalons->pluck('id')->toArray()) ? 'selected' : '' }}> {{$jalon->designation}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label>Min compléxité <span class="text-red">*</span></label>
                                        <input class="form-control" type="number" min="0"
                                            name="minComplexite"
                                            id="minComplexiteModal2_{{ $optionTtm->id }}"
                                            value="{{ $optionTtm->minComplexite }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Max complexité <span class="text-red">*</span></label>
                                        <input class="form-control" name="maxComplexite"
                                            id="maxComplexiteModal2_{{ $optionTtm->id }}" type="number"
                                            value="{{ $optionTtm->maxComplexite }}">
                                    </div>
                                </div>
                                <span id="erreurMessage2_{{ $optionTtm->id }}" class="text-red"></span>
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
</div>