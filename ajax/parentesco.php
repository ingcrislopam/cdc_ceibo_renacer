<?php
	require_once "../modelos/Parentesco.php";
	$parentesco = new Parentesco();

	$id_parentesco = isset($_POST["id_parentesco"])? limpiarCadena($_POST["id_parentesco"]): "";
	$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): ""; 

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_parentesco)){
				$rspta=$parentesco->insertar($nombre);
				echo $rspta ? "Parentesco registrado" : "Parentesco no se pudo registrar";
			}
			else {
				$rspta=$parentesco->editar($id_parentesco,$nombre);
				echo $rspta ? "Parentesco actualizado" : "Parentesco no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $parentesco->desactivar($id_parentesco);
			echo $rspta ? "Parentesco desactivado" : "Parentesco no se puede desactivar";
		break;

		case 'activar':
			$rspta = $parentesco->activar($id_parentesco);
			echo $rspta ? "Parentesco activado" : "Parentesco no se puede activar";
		break;

		case 'mostrar':
			$rspta = $parentesco->mostrar($id_parentesco);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $parentesco->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_parentesco.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_parentesco.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_parentesco.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_parentesco.')"><i class="fa fa-check"></i></button>',
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