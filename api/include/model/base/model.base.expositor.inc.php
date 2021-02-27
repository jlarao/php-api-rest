<?php

	class ModeloBaseExpositor extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseExpositor";

		
		var $idExpositor=0;
		var $idUsuarioExpositor=0;
		var $idProfesion=0;
		var $fechaRegistro='';
		var $idUsuarioRegistro=0;
		var $descripcion='';

		var $__s=array("idExpositor","idUsuarioExpositor","idProfesion","fechaRegistro","idUsuarioRegistro","descripcion");
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

		
		public function setIdExpositor($idExpositor)
		{
			if($idExpositor==0||$idExpositor==""||!is_numeric($idExpositor)|| (is_string($idExpositor)&&!ctype_digit($idExpositor)))return $this->setError("Tipo de dato incorrecto para idExpositor.");
			$this->idExpositor=$idExpositor;
			$this->getDatos();
		}
		public function setIdUsuarioExpositor($idUsuarioExpositor)
		{
			
			$this->idUsuarioExpositor=$idUsuarioExpositor;
		}
		public function setIdProfesion($idProfesion)
		{
			
			$this->idProfesion=$idProfesion;
		}
		public function setFechaRegistro($fechaRegistro)
		{
			$this->fechaRegistro=$fechaRegistro;
		}
		public function setIdUsuarioRegistro($idUsuarioRegistro)
		{
			
			$this->idUsuarioRegistro=$idUsuarioRegistro;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdExpositor()
		{
			return $this->idExpositor;
		}
		public function getIdUsuarioExpositor()
		{
			return $this->idUsuarioExpositor;
		}
		public function getIdProfesion()
		{
			return $this->idProfesion;
		}
		public function getFechaRegistro()
		{
			return $this->fechaRegistro;
		}
		public function getIdUsuarioRegistro()
		{
			return $this->idUsuarioRegistro;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idExpositor=0;
			$this->idUsuarioExpositor=0;
			$this->idProfesion=0;
			$this->fechaRegistro='';
			$this->idUsuarioRegistro=0;
			$this->descripcion='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO expositor(idUsuarioExpositor,idProfesion,fechaRegistro,idUsuarioRegistro,descripcion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioExpositor) . "','" . mysqli_real_escape_string($this->dbLink,$this->idProfesion) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseExpositor::Insertar]");
				
				$this->idExpositor=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE expositor SET idUsuarioExpositor='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioExpositor) . "',idProfesion='" . mysqli_real_escape_string($this->dbLink,$this->idProfesion) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "',descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "'
					WHERE idExpositor=" . $this->idExpositor;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseExpositor::Update]");
				
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
				$SQL="DELETE FROM expositor
				WHERE idExpositor=" . mysqli_real_escape_string($this->dbLink,$this->idExpositor);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseExpositor::Borrar]");
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
						idExpositor,idUsuarioExpositor,idProfesion,fechaRegistro,idUsuarioRegistro,descripcion
					FROM expositor
					WHERE idExpositor=" . mysqli_real_escape_string($this->dbLink,$this->idExpositor);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseExpositor::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idExpositor==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>