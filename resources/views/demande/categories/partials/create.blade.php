<!-- create.blade.php -->

<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="create_modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer une nouvelle demande de catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for creating a new category demande -->
                <form action="{{ route('categoryDemandes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" required>
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