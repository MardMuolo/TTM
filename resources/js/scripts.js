
function supprimer(event){
    event.preventDefault();
    a = event.target.closest('a');

    let deleteForm = document.getElementById('deleteForm');
    deleteForm.setAttribute('action', a.getAttribute('href'));

    let textDelete = document.getElementById('textDelete');
    textDelete.innerHTML = a.getAttribute('item') + " ?";

    let titleDelete = document.getElementById('titleDelete');
    titleDelete.innerHTML = "Suppression";

    
    
}

function edit(event){
    event.preventDefault();
    a = event.target.closest('a');

    let editForm = document.getElementById('editForm');
    editForm.setAttribute('action', a.getAttribute('href'));

    let a_tag = event.target.closest('a');

    let titleEdit = document.getElementById('titleEdit');
    titleEdit.innerHTML = "Modification de l'élement "+ a_tag.getAttribute('item');

    document.getElementById('libelle').value = a_tag.getAttribute('item');
    document.getElementById('description').innerHTML = ""+a_tag.getAttribute('description');
    
}

function edit_target(event){
    event.preventDefault();

    let editForm = document.getElementById('editTargetForm');
    a = event.target.closest('a');

    editForm.setAttribute('action', a.getAttribute('href'));

    let titleEditTarget = document.getElementById('titleEditTarget');
    titleEditTarget.innerHTML = "Modification du target";

    document.getElementById('target').value = a.getAttribute('item');
    document.getElementById('score').value = a.getAttribute('score');
}


