<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Parentesco
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($nombre){
			$sql = "INSERT INTO parentesco (nombre, estado) VALUES ('$nombre','1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_parentesco, $nombre){
			$sql = "UPDATE parentesco SET nombre='$nombre' WHERE id_parentesco='$id_parentesco'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_parentesco){
			$sql = "UPDATE parentesco SET estado='0' WHERE id_parentesco='$id_parentesco'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_parentesco){
			$sql = "UPDATE parentesco SET estado='1' WHERE id_parentesco='$id_parentesco'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_parentesco){
			$sql = "SELECT * FROM parentesco WHERE id_parentesco='$id_parentesco'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			$sql = "SELECT * FROM parentesco";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para listar los registros y mostrar en el select
		public function select(){
			$sql = "SELECT * FROM parentesco WHERE estado=1";
			return ejecutarConsulta($sql);
		}
	}
?>