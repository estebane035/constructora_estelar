$(document).ready( function () {
    var from = "2018-03-16 00:00:00";
    var to = "2018-03-31 23:59:59";
    var table = $('#table_payroll').DataTable({
      ajax: {
        url : 'load_table.php',
        type : 'POST',
        dataSrc : '',
        data : {
          from : from,
          to : to
        }
      },
      columns: [
        { data : 'id' },
        { data : 'nombre_proyecto' },
        { data : 'nombre_trabajador' },
        { data : 'check_in' },
        { data : 'check_out' },
        { data : 'total_horas' }
      ],
      columnDefs: [
        {
            className: "id",
            targets:[0],
            visible: false,
            searchable:false
        },
        {
          className: "dt-center", "targets": "_all"
        }
      ],
      scrollCollapse : true,
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
      language: {
          lengthMenu: "Mostrar _MENU_ registros por pagina",
          zeroRecords: "No se encontraron registros",
          info: "P&aacutegina _PAGE_ of _PAGES_",
          infoEmpty: "No hay registros",
          sSearch: "Buscar:",
      },
       "order": [[ 3, "desc" ]]
    });
});
