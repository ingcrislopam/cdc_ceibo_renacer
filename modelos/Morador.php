<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Morador
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($id_vivienda, $id_parentesco, $cedula, $nombres, $apellidos, $fecha_nacimiento, $celular){
			$sql = "INSERT INTO morador (id_vivienda, id_parentesco, cedula, nombres, apellidos, fecha_nacimiento, celular, estado) VALUES ('$id_vivienda','$id_parentesco','$cedula','$nombres','$apellidos','$fecha_nacimiento','$celular','1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_morador ,$id_vivienda, $id_parentesco, $cedula, $nombres, $apellidos, $fecha_nacimiento, $celular){
			$sql = "UPDATE morador SET id_vivienda='$id_vivienda', id_parentesco='$id_parentesco', cedula='$cedula', nombres='$nombres', apellidos='$apellidos', fecha_nacimiento='$fecha_nacimiento', celular='$celular' WHERE id_morador='$id_morador'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_morador){
			$sql = "UPDATE morador SET estado='0' WHERE id_morador='$id_morador'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_morador){
			$sql = "UPDATE morador SET estado='1' WHERE id_morador='$id_morador'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_morador){
			$sql = "SELECT * FROM morador WHERE id_morador='$id_morador'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			//$sql = "SELECT m.id_morador, m.id_vivienda, v.nombre as vivienda, m.id_parentesco, p.nombre as parentesco, m.cedula, m.nombres, m.apellidos, m.fecha_nacimiento, m.celular, m.estado FROM morador m INNER JOIN vivienda v ON m.id_vivienda=v.id_vivienda INNER JOIN parentesco p ON m.id_parentesco=p.id_parentesco";
			$sql = "SELECT m.id_morador, m.id_vivienda, CONCAT(mz.nombre, ' - ', v.nombre) as vivienda, m.id_parentesco, p.nombre as parentesco, m.cedula, m.nombres, m.apellidos, m.fecha_nacimiento, TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) AS edad, m.celular, m.estado FROM morador m INNER JOIN vivienda v ON m.id_vivienda=v.id_vivienda INNER JOIN parentesco p ON m.id_parentesco=p.id_parentesco INNER JOIN manzana mz ON v.id_manzana=mz.id_manzana";
			return ejecutarConsulta($sql);
		}
	}
?>