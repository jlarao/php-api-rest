<?php

	class ModeloBaseProfesion_expositor extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseProfesion_expositor";

		
		var $idProfesion=0;
		var $nombreProfesion='';
		var $fechaRegistro='';
		var $idUsuarioRegistro=0;

		var $__s=array("idProfesion","nombreProfesion","fechaRegistro","idUsuarioRegistro");
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

		
		public function setIdProfesion($idProfesion)
		{
			if($idProfesion==0||$idProfesion==""||!is_numeric($idProfesion)|| (is_string($idProfesion)&&!ctype_digit($idProfesion)))return $this->setError("Tipo de dato incorrecto para idProfesion.");
			$this->idProfesion=$idProfesion;
			$this->getDatos();
		}
		public function setNombreProfesion($nombreProfesion)
		{
			
			$this->nombreProfesion=$nombreProfesion;
		}
		public function setFechaRegistro($fechaRegistro)
		{
			$this->fechaRegistro=$fechaRegistro;
		}
		public function setIdUsuarioRegistro($idUsuarioRegistro)
		{
			
			$this->idUsuarioRegistro=$idUsuarioRegistro;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdProfesion()
		{
			return $this->idProfesion;
		}
		public function getNombreProfesion()
		{
			return $this->nombreProfesion;
		}
		public function getFechaRegistro()
		{
			return $this->fechaRegistro;
		}
		public function getIdUsuarioRegistro()
		{
			return $this->idUsuarioRegistro;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idProfesion=0;
			$this->nombreProfesion='';
			$this->fechaRegistro='';
			$this->idUsuarioRegistro=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO profesion_expositor(nombreProfesion,fechaRegistro,idUsuarioRegistro)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreProfesion) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseProfesion_expositor::Insertar]");
				
				$this->idProfesion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE profesion_expositor SET nombreProfesion='" . mysqli_real_escape_string($this->dbLink,$this->nombreProfesion) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "'
					WHERE idProfesion=" . $this->idProfesion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseProfesion_expositor::Update]");
				
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
				$SQL="DELETE FROM profesion_expositor
				WHERE idProfesion=" . mysqli_real_escape_string($this->dbLink,$this->idProfesion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseProfesion_expositor::Borrar]");
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
						idProfesion,nombreProfesion,fechaRegistro,idUsuarioRegistro
					FROM profesion_expositor
					WHERE idProfesion=" . mysqli_real_escape_string($this->dbLink,$this->idProfesion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseProfesion_expositor::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idProfesion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>