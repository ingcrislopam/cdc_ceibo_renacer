var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	});

	//Cargamos los items al select sector
	$.post("../ajax/manzana.php?op=selectSector", function(r){
		$("#id_sector").html(r);
		$('#id_sector').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar(){
	$("#id_manzana").val("");
	$("#id_sector").val("");
	$("#nombre").val("");
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función Cancelar Form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función listar
function listar(){
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/manzana.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/manzana.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos){
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}
	});
	limpiar();
}

//Función para mostrar registros por el id seleccionado
function mostrar(id_manzana){
	$.post("../ajax/manzana.php?op=mostrar",{id_manzana : id_manzana}, function(data, status){
		data = JSON.parse(data);
		mostrarform(true);

		$("#id_manzana").val(data.id_manzana);
		$("#id_sector").val(data.id_sector);
		$('#id_sector').selectpicker('refresh');
		$("#nombre").val(data.nombre);
	})
}

//Función para desactivar registros
function desactivar(id_manzana){
	bootbox.confirm("¿Está seguro de desactivar la manzana?", function(result){
		if(result){
			$.post("../ajax/manzana.php?op=desactivar", {id_manzana : id_manzana}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para activar registros
function activar(id_manzana){
	bootbox.confirm("¿Está seguro de activar la manzana?", function(result){
		if(result){
			$.post("../ajax/manzana.php?op=activar", {id_manzana : id_manzana}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();