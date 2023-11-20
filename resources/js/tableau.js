$(function () {
    $("#tableProjet").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv",  "pdf", "print",] 
    }).buttons().container().appendTo('#tableProjet_wrapper .col-md-6:eq(0)');

    $("#tableRapport").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "pdf", "print",] 
    }).buttons().container().appendTo('#tableProjet_wrapper .col-md-6:eq(0)');
   
  });

