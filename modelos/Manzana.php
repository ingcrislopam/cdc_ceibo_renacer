<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Manzana
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($id_sector, $nombre){
			$sql = "INSERT INTO manzana (id_sector, nombre, estado) VALUES ('$id_sector','$nombre','1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_manzana, $id_sector, $nombre){
			$sql = "UPDATE manzana SET id_sector='$id_sector', nombre='$nombre' WHERE id_manzana='$id_manzana'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_manzana){
			$sql = "UPDATE manzana SET estado='0' WHERE id_manzana='$id_manzana'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_manzana){
			$sql = "UPDATE manzana SET estado='1' WHERE id_manzana='$id_manzana'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_manzana){
			$sql = "SELECT * FROM manzana WHERE id_manzana='$id_manzana'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			$sql = "SELECT m.id_manzana, m.id_sector, s.nombre as sector, m.nombre, m.estado FROM manzana m INNER JOIN sector s ON m.id_sector=s.id_sector";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para listar los registros y mostrar en el select
		public function select(){
			$sql = "SELECT * FROM manzana WHERE estado=1";
			return ejecutarConsulta($sql);
		}
	}
?>