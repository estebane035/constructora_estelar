// JavaScript Document
//notifications.php
function cambia_select(url)
{ //alert(1);
    location.href=url.value;
}

//index.php
function guardar_proyecto()
{ //alert(1);
	var c=0;
	if(!document.getElementById('nombreproyecto').value){c++;};
	if(!document.getElementById('descripcionroyecto').value){c++};
	if(document.getElementById('constructoras').selectedIndex==0){c++;}
	if(!document.getElementById('fechainicio').value){c++;}
	if(!document.getElementById('fechatermino').value){c++;}
	if(!document.getElementById('lat').value){c++;}
	if(!document.getElementById('lng').value){c++;}
	
	if(c==0)
	{ document.newprojectform.submit();	}
	else
	{ alert('Please Complete all fields');}
}

