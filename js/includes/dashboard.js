$(document).ready(function () {

  $('#invoices').dataTable({
    "order": [ 1, 'desc' ],
    "pageLength": 10
  });

  $('#payments').dataTable({
    "order": [ 1, 'desc' ],
    "pageLength": 10
  });

  $('#lease').dataTable({
    "order": [ 1, 'desc' ],
    "pageLength": 10
  });



});
