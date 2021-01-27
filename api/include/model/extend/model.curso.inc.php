<?php

	require FOLDER_MODEL_BASE . "model.base.curso.inc.php";

	class ModeloCurso extends ModeloBaseCurso
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseCurso";

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

		public function getCurso($id)
		{
				
			$query = "SELECT idCurso, nombreCurso,  duracion , fechaInicio, fechaFin, c.fechaRegistro, poster, idUsuario, nombre, apellidoPaterno, apellidoMaterno, avatar  
			FROM curso c left join usuario u on u.idUsuario = c.idUsuarioRegistro
					where idCurso = '" . mysqli_real_escape_string($this->dbLink, $id) . "'
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
		
		public function getCursos($pagina,$tamano)
		{
			$inicial = (($pagina) * $tamano);
			$query = "SELECT idCurso, nombreCurso,  duracion , fechaInicio, fechaFin, c.fechaRegistro, poster, idUsuario, nombre, apellidoPaterno, apellidoMaterno  , avatar
			FROM curso c left join usuario u on u.idUsuario = c.idUsuarioRegistro
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

	}

