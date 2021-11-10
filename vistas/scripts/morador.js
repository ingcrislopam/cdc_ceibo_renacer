var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e){
		guardaryeditar(e);
	});

	//Cargamos los items al select vivienda
	$.post("../ajax/morador.php?op=selectVivienda", function(r){
		$("#id_vivienda").html(r);
		$('#id_vivienda').selectpicker('refresh');
	});

	//Cargamos los items al select parentesco
	$.post("../ajax/morador.php?op=selectParentesco", function(r){
		$("#id_parentesco").html(r);
		$('#id_parentesco').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar(){
	$("#id_morador").val("");
	$("#id_vivienda").val("");
	$("#id_parentesco").val("");
	$("#cedula").val("");
	$("#nombres").val("");
	$("#apellidos").val("");
	$("#fecha_nacimiento").val("");
	$("#celular").val("");
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
					url: '../ajax/morador.php?op=listar',
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
		url: "../ajax/morador.php?op=guardaryeditar",
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
function mostrar(id_morador){
	$.post("../ajax/morador.php?op=mostrar",{id_morador : id_morador}, function(data, status){
		data = JSON.parse(data);
		mostrarform(true);

		$("#id_morador").val(data.id_morador);
		$("#id_vivienda").val(data.id_vivienda);
		$('#id_vivienda').selectpicker('refresh');
		$("#id_parentesco").val(data.id_parentesco);
		$('#id_parentesco').selectpicker('refresh');
		$("#cedula").val(data.cedula);
		$("#nombres").val(data.nombres);
		$("#apellidos").val(data.apellidos);
		$("#fecha_nacimiento").val(data.fecha_nacimiento);
		$("#celular").val(data.celular);
	})
}

//Función para desactivar registros
function desactivar(id_morador){
	bootbox.confirm("¿Está seguro de desactivar el morador?", function(result){
		if(result){
			$.post("../ajax/morador.php?op=desactivar", {id_morador : id_morador}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para activar registros
function activar(id_morador){
	bootbox.confirm("¿Está seguro de activar el morador?", function(result){
		if(result){
			$.post("../ajax/morador.php?op=activar", {id_morador : id_morador}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();