<?php

	class ModeloBaseUsuario extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseUsuario";

		
		var $idUsuario=0;
		var $nombre='';
		var $apellidoPaterno='';
		var $apellidoMaterno='';
		var $sexo='masculino';
		var $edad=0;
		var $correoElectronico='';
		var $telefono='';
		var $estatus='Activo';
		var $fechaRegistro='';

		var $__s=array("idUsuario","nombre","apellidoPaterno","apellidoMaterno","sexo","edad","correoElectronico","telefono","estatus","fechaRegistro");
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

		
		public function setIdUsuario($idUsuario)
		{
			if($idUsuario==0||$idUsuario==""||!is_numeric($idUsuario)|| (is_string($idUsuario)&&!ctype_digit($idUsuario)))return $this->setError("Tipo de dato incorrecto para idUsuario.");
			$this->idUsuario=$idUsuario;
			$this->getDatos();
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setApellidoPaterno($apellidoPaterno)
		{
			
			$this->apellidoPaterno=$apellidoPaterno;
		}
		public function setApellidoMaterno($apellidoMaterno)
		{
			
			$this->apellidoMaterno=$apellidoMaterno;
		}
		public function setSexo($sexo)
		{
			
			$this->sexo=$sexo;
		}
		public function setSexoMasculino()
		{
			$this->sexo='masculino';
		}
		public function setSexoFemenino()
		{
			$this->sexo='femenino';
		}
		public function setEdad($edad)
		{
			
			$this->edad=$edad;
		}
		public function setCorreoElectronico($correoElectronico)
		{
			
			$this->correoElectronico=$correoElectronico;
		}
		public function setTelefono($telefono)
		{
			$this->telefono=$telefono;
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
		public function setFechaRegistro($fechaRegistro)
		{
			$this->fechaRegistro=$fechaRegistro;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getApellidoPaterno()
		{
			return $this->apellidoPaterno;
		}
		public function getApellidoMaterno()
		{
			return $this->apellidoMaterno;
		}
		public function getSexo()
		{
			return $this->sexo;
		}
		public function getEdad()
		{
			return $this->edad;
		}
		public function getCorreoElectronico()
		{
			return $this->correoElectronico;
		}
		public function getTelefono()
		{
			return $this->telefono;
		}
		public function getEstatus()
		{
			return $this->estatus;
		}
		public function getFechaRegistro()
		{
			return $this->fechaRegistro;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idUsuario=0;
			$this->nombre='';
			$this->apellidoPaterno='';
			$this->apellidoMaterno='';
			$this->sexo='masculino';
			$this->edad=0;
			$this->correoElectronico='';
			$this->telefono='';
			$this->estatus='Activo';
			$this->fechaRegistro='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO usuario(nombre,apellidoPaterno,apellidoMaterno,sexo,edad,correoElectronico,telefono,estatus,fechaRegistro)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "','" . mysqli_real_escape_string($this->dbLink,$this->apellidoPaterno) . "','" . mysqli_real_escape_string($this->dbLink,$this->apellidoMaterno) . "','" . mysqli_real_escape_string($this->dbLink,$this->sexo) . "','" . mysqli_real_escape_string($this->dbLink,$this->edad) . "','" . mysqli_real_escape_string($this->dbLink,$this->correoElectronico) . "','" . mysqli_real_escape_string($this->dbLink,$this->telefono) . "','" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuario::Insertar]");
				
				$this->idUsuario=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE usuario SET nombre='" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',apellidoPaterno='" . mysqli_real_escape_string($this->dbLink,$this->apellidoPaterno) . "',apellidoMaterno='" . mysqli_real_escape_string($this->dbLink,$this->apellidoMaterno) . "',sexo='" . mysqli_real_escape_string($this->dbLink,$this->sexo) . "',edad='" . mysqli_real_escape_string($this->dbLink,$this->edad) . "',correoElectronico='" . mysqli_real_escape_string($this->dbLink,$this->correoElectronico) . "',telefono='" . mysqli_real_escape_string($this->dbLink,$this->telefono) . "',estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',fechaRegistro='" . mysqli_real_escape_string($this->dbLink,$this->fechaRegistro) . "'
					WHERE idUsuario=" . $this->idUsuario;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseUsuario::Update]");
				
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
				$SQL="DELETE FROM usuario
				WHERE idUsuario=" . mysqli_real_escape_string($this->dbLink,$this->idUsuario);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseUsuario::Borrar]");
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
						idUsuario,nombre,apellidoPaterno,apellidoMaterno,sexo,edad,correoElectronico,telefono,estatus,fechaRegistro
					FROM usuario
					WHERE idUsuario=" . mysqli_real_escape_string($this->dbLink,$this->idUsuario);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseUsuario::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idUsuario==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>