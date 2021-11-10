<?php
	require_once "../modelos/Morador.php";
	$morador = new Morador();

	$id_morador = isset($_POST["id_morador"])? limpiarCadena($_POST["id_morador"]): "";
	$id_vivienda = isset($_POST["id_vivienda"])? limpiarCadena($_POST["id_vivienda"]): "";
	$id_parentesco = isset($_POST["id_parentesco"])? limpiarCadena($_POST["id_parentesco"]): "";
	$cedula = isset($_POST["cedula"])? limpiarCadena($_POST["cedula"]): "";
	$nombres = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]): "";
	$apellidos = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]): "";
	$fecha_nacimiento = isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]): "";
	$celular = isset($_POST["celular"])? limpiarCadena($_POST["celular"]): "";

	switch ($_GET["op"]){
		case 'guardaryeditar':
			if (empty($id_morador)){
				$rspta=$morador->insertar($id_vivienda, $id_parentesco, $cedula, $nombres, $apellidos, $fecha_nacimiento, $celular);
				echo $rspta ? "Morador registrado" : "Morador no se pudo registrar";
			}
			else {
				$rspta=$morador->editar($id_morador ,$id_vivienda, $id_parentesco, $cedula, $nombres, $apellidos, $fecha_nacimiento, $celular);
				echo $rspta ? "Morador actualizado" : "Morador no se pudo actualizar";
			}
		break;

		case 'desactivar':
			$rspta = $morador->desactivar($id_morador);
			echo $rspta ? "Morador desactivado" : "Morador no se puede desactivar";
		break;

		case 'activar':
			$rspta = $morador->activar($id_morador);
			echo $rspta ? "Morador activado" : "Morador no se puede activar";
		break;

		case 'mostrar':
			$rspta = $morador->mostrar($id_morador);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;

		case 'listar':
			$rspta = $morador->listar();
			//Vamos a declarar un array
			$data = Array();
			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_morador.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_morador.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->id_morador.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-primary" onclick="activar('.$reg->id_morador.')"><i class="fa fa-check"></i></button>',
					"1"=>$reg->vivienda,
					"2"=>$reg->parentesco,
					"3"=>$reg->cedula,
					"4"=>$reg->nombres,
					"5"=>$reg->apellidos,
					"6"=>$reg->fecha_nacimiento,
					"7"=>$reg->edad,
					"8"=>$reg->celular,
					"9"=>($reg->estado)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

		case "selectVivienda":
			require_once "../modelos/Vivienda.php";
			$vivienda = new Vivienda();
			$rspta = $vivienda->selectmv();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value=' . $reg->id_vivienda . '>' . $reg->vivienda . '</option>';
			}
		break;

		case "selectParentesco":
			require_once "../modelos/Parentesco.php";
			$parentesco = new Parentesco();
			$rspta = $parentesco->select();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value=' . $reg->id_parentesco . '>' . $reg->nombre . '</option>';
			}
		break;
	}
?>