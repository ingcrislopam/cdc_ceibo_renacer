<?php
	require_once "../modelos/Vivienda.php";
	$vivienda = new Vivienda();

	$id_vivienda = isset($_POST["id_vivienda"])? limpiarCadena($_POST["id_vivienda"]): "";
	$id_manzana = isset($_POST["id_manzana"])? limpiarCadena($_POST["id_manzana"]): "";
	$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): "";
	$n_integrantes = isset($_POST["n_integrantes"])? limpiarCadena($_POST["n_integrantes"]): "";  

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_vivienda)){
				$rspta=$vivienda->insertar($id_manzana, $nombre, $n_integrantes);
				echo $rspta ? "Vivienda registrada" : "Vivienda no se pudo registrar";
			}
			else {
				$rspta=$vivienda->editar($id_vivienda, $id_manzana, $nombre, $n_integrantes);
				echo $rspta ? "Vivienda actualizada" : "Vivienda no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $vivienda->desactivar($id_vivienda);
			echo $rspta ? "Vivienda desactivada" : "Vivienda no se puede desactivar";
		break;

		case 'activar':
			$rspta = $vivienda->activar($id_vivienda);
			echo $rspta ? "Vivienda activada" : "Vivienda no se puede activar";
		break;

		case 'mostrar':
			$rspta = $vivienda->mostrar($id_vivienda);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $vivienda->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_vivienda.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_vivienda.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_vivienda.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_vivienda.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->manzana,
					"2"=>$reg->nombre,
					"3"=>$reg->n_integrantes,
					//"4"=>$reg->i_registrados,
					"4"=>($reg->n_integrantes==$reg->i_registrados)?'<span class="label bg-green">Completo</span>':'<span class="label bg-red">Incompleto</span>',
					"5"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

		case "selectManzana":
			require_once "../modelos/Manzana.php";
			$manzana = new Manzana();
			$rspta = $manzana->select();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value=' . $reg->id_manzana . '>' . $reg->nombre . '</option>';
			}
		break;
	}
?>