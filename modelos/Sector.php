<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Sector
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($nombre){
			$sql = "INSERT INTO sector (nombre, estado) VALUES ('$nombre','1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_sector, $nombre){
			$sql = "UPDATE sector SET nombre='$nombre' WHERE id_sector='$id_sector'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_sector){
			$sql = "UPDATE sector SET estado='0' WHERE id_sector='$id_sector'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_sector){
			$sql = "UPDATE sector SET estado='1' WHERE id_sector='$id_sector'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_sector){
			$sql = "SELECT * FROM sector WHERE id_sector='$id_sector'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			$sql = "SELECT * FROM sector";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para listar los registros y mostrar en el select
		public function select(){
			$sql = "SELECT * FROM sector WHERE estado=1";
			return ejecutarConsulta($sql);
		}
	}
?>