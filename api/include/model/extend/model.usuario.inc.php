<?php

	require FOLDER_MODEL_BASE . "model.base.usuario.inc.php";

	class ModeloUsuario extends ModeloBaseUsuario
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseUsuario";

		var $__ss=array();

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function validarDatos()
		{
			return true;
		}
		
		public function getUsuario($id)
		{
			
			$query = "select idUsuario,nombre,apellidoPaterno,correoElectronico,telefono,estatus,fechaRegistro , avatar
					FROM usuario 
					where idUsuario = '" . mysqli_real_escape_string($this->dbLink, $id) . "'
					";
			$arreglo = array();
			$resultado = mysqli_query($this->dbLink, $query);
			if ($resultado && mysqli_num_rows($resultado) > 0) {
				while ($row_inf = mysqli_fetch_assoc($resultado)){
					$arreglo[] = $row_inf;
				}
			}
			return $arreglo;
		}
		
		public function getInstructor($id)
		{
				
			$query = "select idUsuario,nombre,apellidoPaterno,apellidoMaterno, correoElectronico,telefono,estatus,fechaRegistro , avatar, sexo
					FROM usuario
					where idUsuario = '" . mysqli_real_escape_string($this->dbLink, $id) . "'
					";
			$arreglo = array();
			$resultado = mysqli_query($this->dbLink, $query);
			if ($resultado && mysqli_num_rows($resultado) > 0) {
				while ($row_inf = mysqli_fetch_assoc($resultado)){
					$arreglo = $row_inf;
				}
			}
			return $arreglo;
		}
		
		public function getUsuarios($pagina,$tamano)
		{	
			$inicial = (($pagina) * $tamano);
			$query = "select idUsuario,nombre,apellidoPaterno,correoElectronico,telefono,estatus,fechaRegistro, avatar
					FROM usuario
					LIMIT $inicial, $tamano
					";
			$arreglo = array();
			$resultado = mysqli_query($this->dbLink, $query);
			if ($resultado && mysqli_num_rows($resultado) > 0) {
				while ($row_inf = mysqli_fetch_assoc($resultado)){
					$arreglo[] = $row_inf;
				}
			}
			return $arreglo;
		}
		
		public function getUsuariosRol()
		{
			//$inicial = (($pagina) * $tamano);
			$query = "select u.idUsuario,nombre,apellidoPaterno, l.idRol, `nombreRol`, estatusLogin, idLogin
			FROM usuario u            
			join `login` l on l.`idUsuario` =u.`idUsuario`
			left join rol r on r.`idRol` = l.`idRol` 	";
			$arreglo = array();
			$resultado = mysqli_query($this->dbLink, $query);
			if ($resultado && mysqli_num_rows($resultado) > 0) {
				while ($row_inf = mysqli_fetch_assoc($resultado)){
					$arreglo[] = $row_inf;
				}
			}
			return $arreglo;
		}


	}

