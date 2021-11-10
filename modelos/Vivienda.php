<?php
	//Incluimos inicialmente la conexión a la base de datos
	require "../config/Conexion.php";

	class Vivienda
	{
		//Implementamos nuestro constructor
		public function __construct()
		{
			
		}

		//Implementamos un método para insertar registros
		public function insertar($id_manzana, $nombre, $n_integrantes){
			$sql = "INSERT INTO vivienda (id_manzana, nombre, n_integrantes, i_registrados, estado) VALUES ('$id_manzana','$nombre', '$n_integrantes', '0', '1')";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para editar registros
		public function editar($id_vivienda, $id_manzana, $nombre, $n_integrantes){
			$sql = "UPDATE vivienda SET id_manzana='$id_manzana', nombre='$nombre', n_integrantes='$n_integrantes' WHERE id_vivienda='$id_vivienda'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para desactivar registros
		public function desactivar($id_vivienda){
			$sql = "UPDATE vivienda SET estado='0' WHERE id_vivienda='$id_vivienda'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para activar registros
		public function activar($id_vivienda){
			$sql = "UPDATE vivienda SET estado='1' WHERE id_vivienda='$id_vivienda'";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para mostrar los datos de un registro a modificar
		public function mostrar($id_vivienda){
			$sql = "SELECT * FROM vivienda WHERE id_vivienda='$id_vivienda'";
			return ejecutarConsultaSimpleFila($sql);
		}

		//Implementamos un método para listar los registros
		public function listar(){
			$sql = "SELECT v.id_vivienda, v.id_manzana, m.nombre as manzana, v.nombre, v.n_integrantes, v.i_registrados, v.estado FROM vivienda v INNER JOIN manzana m ON v.id_manzana=m.id_manzana";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para listar los registros y mostrar en el select
		public function select(){
			$sql = "SELECT * FROM vivienda WHERE estado=1";
			return ejecutarConsulta($sql);
		}

		//Implementamos un método para listar los registros y mostrar en el select manzana - vivienda
		public function selectmv(){
			$sql = "SELECT id_vivienda, CONCAT(m.nombre, ' - ', v.nombre) as vivienda FROM vivienda v INNER JOIN manzana m on v.id_manzana=m.id_manzana WHERE v.estado = 1 and m.estado = 1";
			//$sql = "SELECT id_vivienda, CONCAT(m.nombre, ' - ', v.nombre) as vivienda FROM vivienda v INNER JOIN manzana m on v.id_manzana=m.id_manzana WHERE v.estado = 1 and m.estado = 1 and v.n_integrantes != v.i_registrados";
			return ejecutarConsulta($sql);
		}
	}
?>