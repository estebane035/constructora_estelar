var table;
var from = "2018-03-16 00:00:00";
var to = "2018-03-31 23:59:59";
$(document).ready( function () {
    table = $('#table_payroll').DataTable({
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
        { data : 'total_horas' },
        { data : 'actions'}
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

function eliminar(id)
{
  document.getElementById("delete").classList.remove("hidden");
  document.getElementById("btn-delete").onclick = function(){
     $.ajax({
      url: "acciones_ajax/delete_check.php",
      type: "POST",
      data: { id: id},
      success: function(datos)
      {
        if (datos == "1")
        {
          document.getElementById("delete").classList.add("hidden");
          document.getElementById("btn-delete").onclick = function(){};
          table.ajax.reload();
        }
        else
        {
          alert(datos);
        }
      }
    });
  };
}

function cambiarQuincena(fecha)
{
  alert(fecha);
}
