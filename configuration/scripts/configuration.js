// JavaScript Document
//new_contratis.php
var cf=1;
/*
function agregar_contacto()
{
	tabla = document.getElementById('table_contacts'); 
	tr = tabla.insertRow(tabla.rows.length);  //agrega la fila
	td = tr.insertCell(tr.cells.length);   //agrega la columna
		td.innerHTML = "<input type='text' name='name[]'>"; //agrega valor a la columna
	td = tr.insertCell(tr.cells.length); 
		td.innerHTML = "<input type='text' name='email[]'>"; 
	td = tr.insertCell(tr.cells.length);
		td.innerHTML = "<input type='text' name='position[]'>";
		td = tr.insertCell(tr.cells.length);
		td.innerHTML = "<input type='text' name='telefono[]'>";

}*/
//new_contratist
function agregar_contratista(valor)
{  if(valor.value=="n")
	{ document.getElementById('new_contractor').innerHTML="<td>New Contractot</td><td><input type='text' name='contractor_new' id='contractor_new'></td>";}
	else
	{ document.getElementById('new_contractor').innerHTML="";}
}


//edit_constructor.php
function edit_new_constructor()
{ c=0;
	if(!document.getElementById('name').value){c++;}
	if(!document.getElementById('name2').value){c++;}
	if(!document.getElementById('telephone').value){c++;}
	if(!document.getElementById('email').value){c++;} 
	if(c==0)
		{ document.edit_constructor_form.submit();	}
	else
		{alert('Please complete all fields');}	
}

//body_notification.php
function guardar_cuerpo_notificacion()
{ c=0;
	if(!document.getElementById('body').value)
		{c++;}
	if(!document.getElementById('important').value)
		{c++;}
	if(c==0)	
	{document.body_notification.submit();	}
	else
	{alert("Please complete all fields");}
}
//points_notificaction.php
function guardar_punto_notificacion()
{
	if(document.getElementById('point').value)
	{ point_notification.submit();}
	else
	{alert("Please complete field New point");}		
}
//cat_notifications.php
function muestra_notificaciones(valor)
{
	if(navigator.appName.indexOf("Microsoft")>-1){var visible='block';}
	else{var visible='table-row';}
	
	if(valor.value==2)
	{ document.getElementById('filanotificaciones').style.display=visible;
	}
	else
	{ document.getElementById('filanotificaciones').style.display="none";}
}
//body_notificaction.php
function save_new_notification()
{
	c=0;
	if(!document.getElementById('notification').value){c++;}
	if(document.getElementById('tipo').selectedIndex==0){c++}
	if(c==0)
	{ document.cat_notifications.submit();	}
	else
	{ alert("Please complete all fields");}
}


//new_contratist.php
function save_new_contratist()
{ /*text=document.forms[0].elements;
	c=0;
//	alert(text.length);
	for(var i=0;i<text.length;i++)
	{  var elemento=document.forms[0].elements[i];
		if(elemento.type=="text")
		{  if(!elemento.value)
			{c++}
		}
	}
	if(c==0)
	{document.new_contratist_form.submit();
	}
	else
	{alert('Please complete all fields');}*/
	c=0; 
	if(document.getElementById('name_contractor').selectedIndex==0){c++;}
		else
			{if(document.getElementById('name_contractor').value=="n")
				{if(!document.getElementById('contractor_new').value){c++;}
				}
			} 
	if(!document.getElementById('name').value){c++;}
	if(!document.getElementById('email').value){c++;}
	if(!document.getElementById('position').value){c++;}
	if(!document.getElementById('telefono').value){c++;}	
	if(c==0)
	{document.new_contratist_form.submit();
	}
	else
	{alert('Please complete all fields');}
}
//new_constructor.php
function save_new_constructor()
{ c=0;
	if(!document.getElementById('name').value){c++;}
	if(!document.getElementById('name2').value){c++;}
	if(!document.getElementById('telephone').value){c++;}
	if(!document.getElementById('email').value){c++;} 
	if(c==0)
		{ document.new_constructor_form.submit();}
		else
		{alert('Please complete all fields');	}	
}
//edit_contractor.php
function save_update_contratist()
{ c=0;
  if(!document.getElementById('namec').value){c++;}
  if(!document.getElementById('emailc').value){c++;}
  if(!document.getElementById('positionc').value){c++;}
  if(!document.getElementById('telefonoc').value){c++;}
  if(c==0)
	{document.update_contratist_form.submit();
	}
	else
	{ alert('Please complete all fields');}		
}

//user_new.php
function save_new_user()
{ 	c=0;
	if(!document.getElementById('name').value){c++;}
	if(!document.getElementById('user').value){c++;}
	if(!document.getElementById('password').value){c++;}
	if(document.getElementById('type').selectedIndex==0){c++;}
	
	if(c==0)
		{ document.new_user_form.submit(); }
	else
		{ alert('Please complte all fields');}
}
//user_edir.php
function save_edit_user()
{ 	c=0;
	if(!document.getElementById('name').value){c++;}
	if(!document.getElementById('user').value){c++;}
	if(!document.getElementById('password').value){c++;}
	if(document.getElementById('type').selectedIndex==0){c++;}
	if(document.getElementById('active').selectedIndex==0){c++;}
	
	if(c==0)
		{ document.edit_user_form.submit(); }
	else
		{ alert('Please complte all fields');}
}

//new_work.php
function save_new_work()
{ if(document.getElementById('name_work').value)
	{document.new_work_form.submit();
	}
	else
	{alert('Please complete all fields');}
}
//workers_contact_edit.php
function worker_contact_edit()
{ c=0; 
	if(!document.getElementById('telephone').value){c++;} 
	if(!document.getElementById('email').value){c++;}
	if(document.getElementById('active').selectedIndex==0){c++;} //alert(1);
	if(c==0)
		{document.contact_user.submit();}
		else
		{alert('Please complete all fields')}
}