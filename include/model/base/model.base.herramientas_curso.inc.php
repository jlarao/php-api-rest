<?php

	class ModeloBaseHerramientas_curso extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseHerramientas_curso";

		
		var $idHerramientaCurso=0;
		var $nombreHerramienta='';
		var $idTipoHerramienta=0;
		var $urlHerramienta='';
		var $formatoHerramienta='';
		var $idTema=0;
		var $idUsuarioRegistro=0;
		var $fechaRegistro='';
		var $agregarVideo='';
		var $estatus='';

		var $__s=array("idHerramientaCurso","nombreHerramienta","idTipoHerramienta","urlHerramienta","formatoHerramienta","idTema","idUsuarioRegistro","fechaRegistro","agregarVideo","estatus");
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

		
		public function setIdHerramientaCurso($idHerramientaCurso)
		{
			if($idHerramientaCurso==0||$idHerramientaCurso==""||!is_numeric($idHerramientaCurso)|| (is_string($idHerramientaCurso)&&!ctype_digit($idHerramientaCurso)))return $this->setError("Tipo de dato incorrecto para idHerramientaCurso.");
			$this->idHerramientaCurso=$idHerramientaCurso;
			$this->getDatos();
		}
		public function setNombreHerramienta($nombreHerramienta)
		{
			
			$this->nombreHerramienta=$nombreHerramienta;
		}
		public function setIdTipoHerramienta($idTipoHerramienta)
		{
			
			$this->idTipoHerramienta=$idTipoHerramienta;
		}
		public function setUrlHerramienta($urlHerramienta)
		{
			$this->urlHerramienta=$urlHerramienta;
		}
		public function setFormatoHerramienta($formatoHerramienta)
		{
			
			$this->formatoHerramienta=$formatoHerramienta;
		}
		public function setIdTema($idTema)
		{
			
			$this->idTema=$idTema;
		}
		public function setIdUsuarioRegistro($idUsuarioRegistro)
		{
			
			$this->idUsuarioRegistro=$idUsuarioRegistro;
		}
		public function setFechaRegistro($fechaRegistro)
		{
			$this->fechaRegistro=$fechaRegistro;
		}
		public function setAgregarVideo($agregarVideo)
		{
			
			$this->agregarVideo=$agregarVideo;
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

		
		public function getIdHerramientaCurso()
		{
			return $this->idHerramientaCurso;
		}
		public function getNombreHerramienta()
		{
			return $this->nombreHerramienta;
		}
		public function getIdTipoHerramienta()
		{
			return $this->idTipoHerramienta;
		}
		public function getUrlHerramienta()
		{
			return $this->urlHerramienta;
		}
		public function getFormatoHerramienta()
		{
			return $this->formatoHerramienta;
		}
		public function getIdTema()
		{
			return $this->idTema;
		}
		public function getIdUsuarioRegistro()
		{
			return $this->idUsuarioRegistro;
		}
		public function getFechaRegistro()
		{
			return $this->fechaRegistro;
		}
		public function getAgregarVideo()
		{
			return $this->agregarVideo;
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
			
			$this->idHerramientaCurso=0;
			$this->nombreHerramienta='';
			$this->idTipoHerramienta=0;
			$this->urlHerramienta='';
			$this->formatoHerramienta='';
			$this->idTema=0;
			$this->idUsuarioRegistro=0;
			$this->fechaRegistro='';
			$this->agregarVideo='';
			$this->estatus='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO herramientas_curso(nombreHerramienta,idTipoHerramienta,urlHerramienta,formatoHerramienta,idTema,idUsuarioRegistro,fechaRegistro,agregarVideo,estatus)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreHerramienta) . "','" . mysqli_real_escape_string($this->dbLink,$this->idTipoHerramienta) . "','" . mysqli_real_escape_string($this->dbLink,$this->urlHerramienta) . "','" . mysqli_real_escape_string($this->dbLink,$this->formatoHerramienta) . "','" . mysqli_real_escape_string($this->dbLink,$this->idTema) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->agregarVideo) . "','" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseHerramientas_curso::Insertar]");
				
				$this->idHerramientaCurso=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE herramientas_curso SET nombreHerramienta='" . mysqli_real_escape_string($this->dbLink,$this->nombreHerramienta) . "',idTipoHerramienta='" . mysqli_real_escape_string($this->dbLink,$this->idTipoHerramienta) . "',urlHerramienta='" . mysqli_real_escape_string($this->dbLink,$this->urlHerramienta) . "',formatoHerramienta='" . mysqli_real_escape_string($this->dbLink,$this->formatoHerramienta) . "',idTema='" . mysqli_real_escape_string($this->dbLink,$this->idTema) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',agregarVideo='" . mysqli_real_escape_string($this->dbLink,$this->agregarVideo) . "',estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "'
					WHERE idHerramientaCurso=" . $this->idHerramientaCurso;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseHerramientas_curso::Update]");
				
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
				$SQL="DELETE FROM herramientas_curso
				WHERE idHerramientaCurso=" . mysqli_real_escape_string($this->dbLink,$this->idHerramientaCurso);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseHerramientas_curso::Borrar]");
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
						idHerramientaCurso,nombreHerramienta,idTipoHerramienta,urlHerramienta,formatoHerramienta,idTema,idUsuarioRegistro,fechaRegistro,agregarVideo,estatus
					FROM herramientas_curso
					WHERE idHerramientaCurso=" . mysqli_real_escape_string($this->dbLink,$this->idHerramientaCurso);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseHerramientas_curso::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idHerramientaCurso==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>