<?php

	class ModeloBaseCategoria_curso extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCategoria_curso";

		
		var $idCategoria=0;
		var $nombreCategoria='';
		var $nivel=0;
		var $fechaRegistro='';
		var $idUsuarioRegistro=0;
		var $estatus='';

		var $__s=array("idCategoria","nombreCategoria","nivel","fechaRegistro","idUsuarioRegistro","estatus");
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

		
		public function setIdCategoria($idCategoria)
		{
			if($idCategoria==0||$idCategoria==""||!is_numeric($idCategoria)|| (is_string($idCategoria)&&!ctype_digit($idCategoria)))return $this->setError("Tipo de dato incorrecto para idCategoria.");
			$this->idCategoria=$idCategoria;
			$this->getDatos();
		}
		public function setNombreCategoria($nombreCategoria)
		{
			
			$this->nombreCategoria=$nombreCategoria;
		}
		public function setNivel($nivel)
		{
			
			$this->nivel=$nivel;
		}
		public function setFechaRegistro($fechaRegistro)
		{
			$this->fechaRegistro=$fechaRegistro;
		}
		public function setIdUsuarioRegistro($idUsuarioRegistro)
		{
			
			$this->idUsuarioRegistro=$idUsuarioRegistro;
		}
		public function setEstatus($estatus)
		{
			
			$this->estatus=$estatus;
		}
		public function setEstatusActivo()
		{
			$this->estatus='Activo';
		}
		public function setEstatusSuspendido()
		{
			$this->estatus='Suspendido';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCategoria()
		{
			return $this->idCategoria;
		}
		public function getNombreCategoria()
		{
			return $this->nombreCategoria;
		}
		public function getNivel()
		{
			return $this->nivel;
		}
		public function getFechaRegistro()
		{
			return $this->fechaRegistro;
		}
		public function getIdUsuarioRegistro()
		{
			return $this->idUsuarioRegistro;
		}
		public function getEstatus()
		{
			return $this->estatus;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCategoria=0;
			$this->nombreCategoria='';
			$this->nivel=0;
			$this->fechaRegistro='';
			$this->idUsuarioRegistro=0;
			$this->estatus='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO categoria_curso(nombreCategoria,nivel,fechaRegistro,idUsuarioRegistro,estatus)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreCategoria) . "','" . mysqli_real_escape_string($this->dbLink,$this->nivel) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCategoria_curso::Insertar]");
				
				$this->idCategoria=mysqli_insert_id($this->dbLink);
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		protected function Actualizar()
		{
			try
			{
				$SQL="UPDATE categoria_curso SET nombreCategoria='" . mysqli_real_escape_string($this->dbLink,$this->nombreCategoria) . "',nivel='" . mysqli_real_escape_string($this->dbLink,$this->nivel) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "',estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "'
					WHERE idCategoria=" . $this->idCategoria;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseCategoria_curso::Update]");
				
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function Borrar()
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="DELETE FROM categoria_curso
				WHERE idCategoria=" . mysqli_real_escape_string($this->dbLink,$this->idCategoria);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseCategoria_curso::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function getDatos()
		{
			try
			{
				$SQL="SELECT
						idCategoria,nombreCategoria,nivel,fechaRegistro,idUsuarioRegistro,estatus
					FROM categoria_curso
					WHERE idCategoria=" . mysqli_real_escape_string($this->dbLink,$this->idCategoria);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCategoria_curso::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

				if(mysqli_num_rows($result)==0)
				{
					$this->limpiarPropiedades();
				}
				else
				{
					$datos=mysqli_fetch_assoc($result);
					foreach($datos as $k=>$v)
					{
						$campo="" . $k;
						$this->$campo=$v;
					}
				}
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function Guardar()
		{
			if(!$this->validarDatos())
				return false;
			if($this->getError())
				return false;
			if($this->idCategoria==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>