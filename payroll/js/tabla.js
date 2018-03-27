$(document).ready( function () {
    var table = $('#table_payroll').DataTable({
      ajax: {
        url : 'load_table.php',
        dataSrc : ''
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
      }
    });
});
