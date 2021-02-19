<?php

	class ModeloBaseSubtema_curso extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseSubtema_curso";

		
		var $idSubTema=0;
		var $nombreSubTema='';
		var $idTema=0;
		var $horarioInicio='';
		var $horarioFin='';
		var $fechaRegistro='';
		var $idUsuarioRegistro=0;

		var $__s=array("idSubTema","nombreSubTema","idTema","horarioInicio","horarioFin","fechaRegistro","idUsuarioRegistro");
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

		
		public function setIdSubTema($idSubTema)
		{
			if($idSubTema==0||$idSubTema==""||!is_numeric($idSubTema)|| (is_string($idSubTema)&&!ctype_digit($idSubTema)))return $this->setError("Tipo de dato incorrecto para idSubTema.");
			$this->idSubTema=$idSubTema;
			$this->getDatos();
		}
		public function setNombreSubTema($nombreSubTema)
		{
			
			$this->nombreSubTema=$nombreSubTema;
		}
		public function setIdTema($idTema)
		{
			
			$this->idTema=$idTema;
		}
		public function setHorarioInicio($horarioInicio)
		{
			$this->horarioInicio=$horarioInicio;
		}
		public function setHorarioFin($horarioFin)
		{
			$this->horarioFin=$horarioFin;
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

		
		public function getIdSubTema()
		{
			return $this->idSubTema;
		}
		public function getNombreSubTema()
		{
			return $this->nombreSubTema;
		}
		public function getIdTema()
		{
			return $this->idTema;
		}
		public function getHorarioInicio()
		{
			return $this->horarioInicio;
		}
		public function getHorarioFin()
		{
			return $this->horarioFin;
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
			
			$this->idSubTema=0;
			$this->nombreSubTema='';
			$this->idTema=0;
			$this->horarioInicio='';
			$this->horarioFin='';
			$this->fechaRegistro='';
			$this->idUsuarioRegistro=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO subtema_curso(nombreSubTema,idTema,horarioInicio,horarioFin,fechaRegistro,idUsuarioRegistro)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreSubTema) . "','" . mysqli_real_escape_string($this->dbLink,$this->idTema) . "','" . mysqli_real_escape_string($this->dbLink,$this->horarioInicio) . "','" . mysqli_real_escape_string($this->dbLink,$this->horarioFin) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseSubtema_curso::Insertar]");
				
				$this->idSubTema=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE subtema_curso SET nombreSubTema='" . mysqli_real_escape_string($this->dbLink,$this->nombreSubTema) . "',idTema='" . mysqli_real_escape_string($this->dbLink,$this->idTema) . "',horarioInicio='" . mysqli_real_escape_string($this->dbLink,$this->horarioInicio) . "',horarioFin='" . mysqli_real_escape_string($this->dbLink,$this->horarioFin) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "'
					WHERE idSubTema=" . $this->idSubTema;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseSubtema_curso::Update]");
				
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
				$SQL="DELETE FROM subtema_curso
				WHERE idSubTema=" . mysqli_real_escape_string($this->dbLink,$this->idSubTema);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseSubtema_curso::Borrar]");
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
						idSubTema,nombreSubTema,idTema,horarioInicio,horarioFin,fechaRegistro,idUsuarioRegistro
					FROM subtema_curso
					WHERE idSubTema=" . mysqli_real_escape_string($this->dbLink,$this->idSubTema);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseSubtema_curso::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idSubTema==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>