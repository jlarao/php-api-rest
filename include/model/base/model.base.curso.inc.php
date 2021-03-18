<?php

	class ModeloBaseCurso extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCurso";

		
		var $idCurso=0;
		var $nombreCurso='';
		var $idCategoria=0;
		var $duracion='';
		var $numeroTemas=0;
		var $fechaInicio='';
		var $fechaFin='';
		var $fechaRegistro='';
		var $idUsuarioRegistro=0;
		var $poster='';
		var $descripcion='';
		var $requisitos='';
		var $que_aprenderas='';
		var $precio='';
		var $estatus='';

		var $__s=array("idCurso","nombreCurso","idCategoria","duracion","numeroTemas","fechaInicio","fechaFin","fechaRegistro","idUsuarioRegistro","poster","descripcion","requisitos","que_aprenderas","precio","estatus");
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

		
		public function setIdCurso($idCurso)
		{
			if($idCurso==0||$idCurso==""||!is_numeric($idCurso)|| (is_string($idCurso)&&!ctype_digit($idCurso)))return $this->setError("Tipo de dato incorrecto para idCurso.");
			$this->idCurso=$idCurso;
			$this->getDatos();
		}
		public function setNombreCurso($nombreCurso)
		{
			
			$this->nombreCurso=$nombreCurso;
		}
		public function setIdCategoria($idCategoria)
		{
			
			$this->idCategoria=$idCategoria;
		}
		public function setDuracion($duracion)
		{
			$this->duracion=$duracion;
		}
		public function setNumeroTemas($numeroTemas)
		{
			
			$this->numeroTemas=$numeroTemas;
		}
		public function setFechaInicio($fechaInicio)
		{
			$this->fechaInicio=$fechaInicio;
		}
		public function setFechaFin($fechaFin)
		{
			$this->fechaFin=$fechaFin;
		}
		public function setFechaRegistro($fechaRegistro)
		{
			$this->fechaRegistro=$fechaRegistro;
		}
		public function setIdUsuarioRegistro($idUsuarioRegistro)
		{
			
			$this->idUsuarioRegistro=$idUsuarioRegistro;
		}
		public function setPoster($poster)
		{
			
			$this->poster=$poster;
		}
		public function setDescripcion($descripcion)
		{
			$this->descripcion=$descripcion;
		}
		public function setRequisitos($requisitos)
		{
			$this->requisitos=$requisitos;
		}
		public function setQue_aprenderas($que_aprenderas)
		{
			$this->que_aprenderas=$que_aprenderas;
		}
		public function setPrecio($precio)
		{
			$this->precio=$precio;
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

		
		public function getIdCurso()
		{
			return $this->idCurso;
		}
		public function getNombreCurso()
		{
			return $this->nombreCurso;
		}
		public function getIdCategoria()
		{
			return $this->idCategoria;
		}
		public function getDuracion()
		{
			return $this->duracion;
		}
		public function getNumeroTemas()
		{
			return $this->numeroTemas;
		}
		public function getFechaInicio()
		{
			return $this->fechaInicio;
		}
		public function getFechaFin()
		{
			return $this->fechaFin;
		}
		public function getFechaRegistro()
		{
			return $this->fechaRegistro;
		}
		public function getIdUsuarioRegistro()
		{
			return $this->idUsuarioRegistro;
		}
		public function getPoster()
		{
			return $this->poster;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getRequisitos()
		{
			return $this->requisitos;
		}
		public function getQue_aprenderas()
		{
			return $this->que_aprenderas;
		}
		public function getPrecio()
		{
			return $this->precio;
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
			
			$this->idCurso=0;
			$this->nombreCurso='';
			$this->idCategoria=0;
			$this->duracion='';
			$this->numeroTemas=0;
			$this->fechaInicio='';
			$this->fechaFin='';
			$this->fechaRegistro='';
			$this->idUsuarioRegistro=0;
			$this->poster='';
			$this->descripcion='';
			$this->requisitos='';
			$this->que_aprenderas='';
			$this->precio='';
			$this->estatus='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO curso(nombreCurso,idCategoria,duracion,numeroTemas,fechaInicio,fechaFin,fechaRegistro,idUsuarioRegistro,poster,descripcion,requisitos,que_aprenderas,precio,estatus)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreCurso) . "','" . mysqli_real_escape_string($this->dbLink,$this->idCategoria) . "','" . mysqli_real_escape_string($this->dbLink,$this->duracion) . "','" . mysqli_real_escape_string($this->dbLink,$this->numeroTemas) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaInicio) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaFin) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "','" . mysqli_real_escape_string($this->dbLink,$this->poster) . "','" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "','" . mysqli_real_escape_string($this->dbLink,$this->requisitos) . "','" . mysqli_real_escape_string($this->dbLink,$this->que_aprenderas) . "','" . mysqli_real_escape_string($this->dbLink,$this->precio) . "','" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCurso::Insertar]");
				
				$this->idCurso=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE curso SET nombreCurso='" . mysqli_real_escape_string($this->dbLink,$this->nombreCurso) . "',idCategoria='" . mysqli_real_escape_string($this->dbLink,$this->idCategoria) . "',duracion='" . mysqli_real_escape_string($this->dbLink,$this->duracion) . "',numeroTemas='" . mysqli_real_escape_string($this->dbLink,$this->numeroTemas) . "',fechaInicio='" . mysqli_real_escape_string($this->dbLink,$this->fechaInicio) . "',fechaFin='" . mysqli_real_escape_string($this->dbLink,$this->fechaFin) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "',idUsuarioRegistro='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioRegistro) . "',poster='" . mysqli_real_escape_string($this->dbLink,$this->poster) . "',descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',requisitos='" . mysqli_real_escape_string($this->dbLink,$this->requisitos) . "',que_aprenderas='" . mysqli_real_escape_string($this->dbLink,$this->que_aprenderas) . "',precio='" . mysqli_real_escape_string($this->dbLink,$this->precio) . "',estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "'
					WHERE idCurso=" . $this->idCurso;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseCurso::Update]");
				
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
				$SQL="DELETE FROM curso
				WHERE idCurso=" . mysqli_real_escape_string($this->dbLink,$this->idCurso);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseCurso::Borrar]");
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
						idCurso,nombreCurso,idCategoria,duracion,numeroTemas,fechaInicio,fechaFin,fechaRegistro,idUsuarioRegistro,poster,descripcion,requisitos,que_aprenderas,precio,estatus
					FROM curso
					WHERE idCurso=" . mysqli_real_escape_string($this->dbLink,$this->idCurso);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCurso::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCurso==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>