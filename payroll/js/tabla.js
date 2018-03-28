var table;
var reloaded = false;
$(document).ready( function () {
    $('#title').html(changeDays($('#fecha_actual').val()));
    table = $('#table_payroll').DataTable({
      ajax: {
        url : 'load_table.php',
        type : 'POST',
        dataSrc : '',
        data : function ( d ) {
          return $.extend( {}, d, {
            from : $('#from').val(),
            to : $('#to').val()
          });
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
  $('#title').html(changeDays(fecha));
  //alert(fecha);
  //changeDays(fecha);
}

function changeDays(fecha){
  var now = new Date(fecha);
  var day = now.getDate();
  var date;
  var array = "Payroll ";
  var string_to = "";
  var j = 1;
  if(day <= 15){
    $('#from').val(now.getFullYear() + "-" + (now.getMonth() + 1) + "-01 00:00:00");
    date = new Date(now.getFullYear(), now.getMonth(), 1);
    array += getWeekDay(date.getDay()) + " " + 1;
    for(var i = 2; i <= 15; i++, j++){
      var date = new Date(now.getFullYear(), now.getMonth(), i);
      if(isValidDay(i + "/" + now.getMonth() + "/" + now.getFullYear())){
        string_to = getWeekDay(date.getDay()) + " " + i + "\n";
        $('#to').val(now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + i + " 23:59:59");
      }
    }
    array += " to " + string_to;
  }
  else{
    $('#from').val(now.getFullYear() + "-" + (now.getMonth() + 1) + "-16 00:00:00");
    date = new Date(now.getFullYear(), now.getMonth(), 16);
    array += getWeekDay(date.getDay()) + " " + 16;
    for(var i = 17; i <= 31; i++, j++){
      var date = new Date(now.getFullYear(), now.getMonth(), i);
      if(isValidDay(i + "/" + now.getMonth() + "/" + now.getFullYear())){
        string_to = getWeekDay(date.getDay()) + " " + i + "\n";
        $('#to').val(now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + i + " 23:59:59");
      }
    }
    array += " to " + string_to;
  }
  if(!reloaded)
    reloaded = true;
  else
    table.ajax.reload();
  return array;
}

function getWeekDay(weekDay){
  var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  return week[weekDay];
}

function isValidDay(date){
  var bits = date.split('/');
  var y = bits[2], m = bits[1], d = bits[0];
  var daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  if ((!(y % 4) && y % 100) || !(y % 400)) {
    daysInMonth[1] = 29;
  }
  return !(/\D/.test(String(d))) && d > 0 && d <= daysInMonth[m]
}
