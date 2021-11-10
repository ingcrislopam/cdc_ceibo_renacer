<?php
	require_once "../modelos/Sector.php";
	$sector = new Sector();

	$id_sector = isset($_POST["id_sector"])? limpiarCadena($_POST["id_sector"]): "";
	$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): ""; 

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_sector)){
				$rspta=$sector->insertar($nombre);
				echo $rspta ? "Sector registrado" : "Sector no se pudo registrar";
			}
			else {
				$rspta=$sector->editar($id_sector,$nombre);
				echo $rspta ? "Sector actualizado" : "Sector no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $sector->desactivar($id_sector);
			echo $rspta ? "Sector desactivado" : "Sector no se puede desactivar";
		break;

		case 'activar':
			$rspta = $sector->activar($id_sector);
			echo $rspta ? "Sector activado" : "Sector no se puede activar";
		break;

		case 'mostrar':
			$rspta = $sector->mostrar($id_sector);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $sector->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_sector.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_sector.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_sector.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_sector.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->nombre,
					"2"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
				);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //Enviamos el total de registros al datatable
				"iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
				"aaData"=>$data
			);
			echo json_encode($results);
		break;
	}
?>