//JavaScript Document
//show_works_description.php
/*
function agrandar_notificacion(idnotificacion)
{
	if(navigator.appName.indexOf("Microsoft")>-1){var visible='block';}
	else{var visible='table-row';}
	
	var table=document.getElementById('table_notificacions');
	for(var c=0; c<table.rows.length; c++)
	{ table.rows[c].style.display="none";}
	
	document.getElementById('fila'+idnotificacion).style.display=visible;
	document.getElementById('fila'+idnotificacion).style.fontSize="24px";
	document.getElementById('muestra_tabla').style.display=visible;
}
*/
//show_works_description.php
/*function muestra_notificaciones()
{  	if(navigator.appName.indexOf("Microsoft")>-1){var visible='block';}
	else{var visible='table-row';}
	
	var table=document.getElementById('table_notificacions');
	for(var c=0; c<table.rows.length; c++)
	{ table.rows[c].style.display=visible;
	  table.rows[c].style.fontSize="12px";
	}
	document.getElementById('muestra_tabla').style.display="none";
}*/

//show_works_descripction.php
function save_activity()
{//alert(1);
	var elementos=document.forms[0].elements;	
	c=0;									     
//	alert(valores.length);
	for(i=0;i<document.forms[0].elements.length;i++)
	{ //alert(trabajadores.item(i).value);
		elemento = document.forms[0].elements[i];
		if(elemento.type=="text")
		{ //alert(trabajadores.item(i).value);
			if(!elemento.value)
			{c++;}
		}
	}
	if(c==0)
	{  document.save_works.submit();
	}
	else
	{alert('Please Complete all fields');}	
} 
