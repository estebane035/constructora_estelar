function cambioTipo(tipo)
{
	if (tipo == 3)
		document.getElementById('tr-salario').style.display = "contents";
	else
	{
		document.getElementById('tr-salario').style.display = "none";
		document.getElementById('salario').value = "";
	}
}

function cambioTipoEdit(tipo)
{
	if (tipo == 3)
		document.getElementById('tr-salario').style.display = "contents";
	else
		document.getElementById('tr-salario').style.display = "none";
}