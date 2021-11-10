var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	});

	//Cargamos los items al select manzana
	$.post("../ajax/vivienda.php?op=selectManzana", function(r){
		$("#id_manzana").html(r);
		$('#id_manzana').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar(){
	$("#id_vivienda").val("");
	$("#id_manzana").val("");
	$("#nombre").val("");
	$("#n_integrantes").val("");
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
					url: '../ajax/vivienda.php?op=listar',
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
		url: "../ajax/vivienda.php?op=guardaryeditar",
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
function mostrar(id_vivienda){
	$.post("../ajax/vivienda.php?op=mostrar",{id_vivienda : id_vivienda}, function(data, status){
		data = JSON.parse(data);
		mostrarform(true);

		$("#id_vivienda").val(data.id_vivienda);
		$("#id_manzana").val(data.id_manzana);
		$('#id_manzana').selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#n_integrantes").val(data.n_integrantes);
	})
}

//Función para desactivar registros
function desactivar(id_vivienda){
	bootbox.confirm("¿Está seguro de desactivar la vivienda?", function(result){
		if(result){
			$.post("../ajax/vivienda.php?op=desactivar", {id_vivienda : id_vivienda}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para activar registros
function activar(id_vivienda){
	bootbox.confirm("¿Está seguro de activar la vivienda?", function(result){
		if(result){
			$.post("../ajax/vivienda.php?op=activar", {id_vivienda : id_vivienda}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();