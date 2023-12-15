<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titleEdit"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="POST" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="name">Nom de la direction</label>
                                <input type="text" name="name" class="form-control" placeholder="Nom  de la direction" required id="direction">
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="directeur">Directeur</label>
                                <select name="directeur" style="width:75%" class="form-control" id="user2">
                                    <option value="" id="directeur_edit"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xm-6">
                            <div class="form-group">
                                <label for="inputEmail"></label>
                                <input type="hidden" class="form-control" id="inputEmail2" placeholder="email" name="email">
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

<script src="{{ Vite::asset('node_modules/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ Vite::asset('resources/js/scripts.js') }}"></script>
<script src="{{ Vite::asset('node_modules/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
@vite('node_modules/admin-lte/plugins/select2/css/select2.min.css')

<script>
    $(document).ready(function() {

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
                            text: user.last_name+" "+user.first_name,
                            email: user.email,
                            phone: user.phone,
                            first_name: user.first_name,
                            last_name: user.last_name,
                        };
                    });

                    // Initialiser le champ de sélection avec les options
                    $('#user2').select2({
                        data: formattedData,
                        minimumInputLength: 1
                    });

                    // Événement de sélection d'utilisateur
                    $('#user2').on('select2:select', function(e) {
                        var selectedUser = e.params.data;

                        // Mettre à jour la valeur de l'input "Email" avec l'e-mail de l'utilisateur sélectionné
                        $('#user2').val(selectedUser.email);
                        // $('#username').val(selectedUser.username);
                        $('#inputEmail2').val(selectedUser.email);
                        // $('#inputTel').val(selectedUser.phone);
                        
                        // var fullName = selectedUser.first_name + ' ' + selectedUser
                        //     .last_name;
                        // $('#name').val(fullName);
                    });
                } else {
                    console.log('Erreur: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Erreur AJAX: ' + error);
            }
        });
    });
</script>