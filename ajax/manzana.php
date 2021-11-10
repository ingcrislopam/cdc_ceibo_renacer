<?php
	require_once "../modelos/Manzana.php";
	$manzana = new Manzana();

	$id_manzana = isset($_POST["id_manzana"])? limpiarCadena($_POST["id_manzana"]): "";
	$id_sector = isset($_POST["id_sector"])? limpiarCadena($_POST["id_sector"]): "";
	$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): ""; 

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_manzana)){
				$rspta=$manzana->insertar($id_sector, $nombre);
				echo $rspta ? "Manzana registrada" : "Manzana no se pudo registrar";
			}
			else {
				$rspta=$manzana->editar($id_manzana, $id_sector, $nombre);
				echo $rspta ? "Manzana actualizada" : "Manzana no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $manzana->desactivar($id_manzana);
			echo $rspta ? "Manzana desactivada" : "Manzana no se puede desactivar";
		break;

		case 'activar':
			$rspta = $manzana->activar($id_manzana);
			echo $rspta ? "Manzana activada" : "Manzana no se puede activar";
		break;

		case 'mostrar':
			$rspta = $manzana->mostrar($id_manzana);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $manzana->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_manzana.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_manzana.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_manzana.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_manzana.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->sector,
					"2"=>$reg->nombre,
					"3"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

		case "selectSector":
			require_once "../modelos/Sector.php";
			$sector = new Sector();
			$rspta = $sector->select();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value=' . $reg->id_sector . '>' . $reg->nombre . '</option>';
			}
		break;
	}
?>