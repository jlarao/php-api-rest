<?php

	require FOLDER_MODEL_BASE . "model.base.subtema_curso.inc.php";

	class ModeloSubtema_curso extends ModeloBaseSubtema_curso
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseSubtema_curso";

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

		
		
		public function getByTemaCursoId($id)
		{
		
			$query = " select idSubTema, nombreSubTema  FROM subtema_curso WHERE idTema
					= '" . mysqli_real_escape_string($this->dbLink, $id) . "'
					";
			//return $query;
			$arreglo = array();
			$resultado = mysqli_query($this->dbLink, $query);
			if ($resultado && mysqli_num_rows($resultado) > 0) {
				while ($row_inf = mysqli_fetch_assoc($resultado)){
					$arreglo[] = $row_inf;
				}
			}
			return $arreglo;
		}

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


	}

