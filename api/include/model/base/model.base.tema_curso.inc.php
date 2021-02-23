<?php

	class ModeloBaseTema_curso extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTema_curso";

		
		var $idTema=0;
		var $nombreTema='';
		var $idCurso=0;
		var $horarioInicio='';
		var $horarioFin='';
		var $fechaRegistro='';
		var $idUsuarioRegistro=0;
		var $estatus='';

		var $__s=array("idTema","nombreTema","idCurso","horarioInicio","horarioFin","fechaRegistro","idUsuarioRegistro","estatus");
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

		
		public function setIdTema($idTema)
		{
			if($idTema==0||$idTema==""||!is_numeric($idTema)|| (is_string($idTema)&&!ctype_digit($idTema)))return $this->setError("Tipo de dato incorrecto para idTema.");
			$this->idTema=$idTema;
			$this->getDatos();
		}
		public function setNombreTema($nombreTema)
		{
			
			$this->nombreTema=$nombreTema;
		}
		public function setIdCurso($idCurso)
		{
			
			$this->idCurso=$idCurso;
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

		
		public function getIdTema()
		{
			return $this->idTema;
		}
		public function getNombreTema()
		{
			return $this->nombreTema;
		}
		public function getIdCurso()
		{
			return $this->idCurso;
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
			
			$this->idTema=0;
			$this->nombreTema='';
			$this->idCurso=0;
			$this->horarioInicio='';
			$this->horarioFin='';
			$this->fechaRegistro='';
			$this->idUsuarioRegistro=0;
			$this->estatus='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO tema_curso(nombreTema,idCurso,horarioInicio,horarioFin,fechaRegistro,idUsuarioRegistro,estatus)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreTema) . "','" . mysqli_real_escape_string($this->dbLink,$this->idCurso) . "','" . mysqli_real_escape_string($this->dbLink,$this->horarioInicio) . "','" . mysqli_real_escape_string($this->dbLink,$this->horarioFin) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTema_curso::Insertar]");
				
				$this->idTema=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE tema_curso SET nombreTema='" . mysqli_real_escape_string($this->dbLink,$this->nombreTema) . "',idCurso='" . mysqli_real_escape_string($this->dbLink,$this->idCurso) . "',horarioInicio='" . mysqli_real_escape_string($this->dbLink,$this->horarioInicio) . "',horarioFin='" . mysqli_real_escape_string($this->dbLink,$this->horarioFin) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "',estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "'
					WHERE idTema=" . $this->idTema;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseTema_curso::Update]");
				
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
				$SQL="DELETE FROM tema_curso
				WHERE idTema=" . mysqli_real_escape_string($this->dbLink,$this->idTema);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseTema_curso::Borrar]");
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
						idTema,nombreTema,idCurso,horarioInicio,horarioFin,fechaRegistro,idUsuarioRegistro,estatus
					FROM tema_curso
					WHERE idTema=" . mysqli_real_escape_string($this->dbLink,$this->idTema);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTema_curso::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTema==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>