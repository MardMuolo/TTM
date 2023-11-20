<!-- edit.blade.php -->

<div class="modal fade" id="edit-{{ $categoryDemande->id }}" tabindex="-1" role="dialog"
    aria-labelledby="edit-{{ $categoryDemande->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la demande de catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing the category demande -->
                <form action="{{ route('categoryDemandes.update', $categoryDemande->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $categoryDemande->title }}" required>
                    </div>
                    <button type="submit" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                      </button>
                </form>
            </div>
        </div>
    </div>
</div>