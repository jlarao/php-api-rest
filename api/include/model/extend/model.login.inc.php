<?php

	require FOLDER_MODEL_BASE . "model.base.login.inc.php";

	class ModeloLogin extends ModeloBaseLogin
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseLogin";

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
		
		public function validarUsuarioPassword($infoUsuario)
	{
		
		$query = "SELECT * from login WHERE userName ='" . mysqli_real_escape_string($this->dbLink, $infoUsuario['username']) . "'  LIMIT 1";
		$result = mysqli_query($this->dbLink, $query);
		if ($result) {
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);

				$password = hash('sha512', $infoUsuario['password'] . $row['semilla']);
				
				if ($row['password'] == $password) {	

					$arrInfoUsuario =$this->obtenerDatosUsuario($row['idUsuario']);
					if (count($arrInfoUsuario) > 0) {
						if ($row['estatusLogin']=='Activo') {
						    
						    //require_once FOLDER_MODEL_EXTEND.'model.tapermiso.inc.php';
						    
						    //$permisos= new ModeloTapermiso();//obtenemos el menu
						    
						    //if (!isset($_SESSION['menus_rol'])){//obtenemos los submenus dependiendo el rol
						       // $_SESSION['menus_rol']=$permisos->getMenusByIdRol($row['idRol']);
						    //}
						    
						    
						    $arrInfoUsuario['nombre'] = $arrInfoUsuario['nombre'];
						    
							$arrInfoUsuario['userName'] = $infoUsuario['username'];
							$arrInfoUsuario['idRol'] = $row['idRol'];
							//$arrInfoUsuario['idSucursal'] = $row['fisucursal_id'];
							$arrInfoUsuario['idUsuario'] =$row['idUsuario'];
							return array(true,$arrInfoUsuario);
					
						}else{
                            //_usuario bloqueado
							return array(false,'Tu cuenta ha sido bloqueada, contacte al administador para activar su cuenta.');
						}
					}else {
                        // error al encontrar el usuario
						return array(false,'Error al cargar los datos del usuario');
					}
				} else {
                    // contrase�a incorrecta
					return array(false,'La contrase&ntilde;a ingresada es incorrecta');
				}
			} else {
                // El usuario no existe.
				return array(false,'El usuario no se encontr&oacute; en el sistema');
			}
		} else {
            // die("[" . $query . "]" . mysqli_error($mysqli));
			return array(false,"ha ocurrido un error username");
		}
	}
	
	public function obtenerDatosUsuario($idUsuario)
	{
		$query = "Select u.idUsuario, u.nombre, u.apellidoPaterno as apellidos, t.idRol, u.correoElectronico from usuario as u 
                    inner join login as l on u.idUsuario=l.idUsuario 
                    inner join rol as t on l.idRol=t.idRol where u.idUsuario=". $idUsuario;
		$arreglo = array();
		$resultado = mysqli_query($this->dbLink, $query);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			$row_inf = mysqli_fetch_assoc($resultado);
			$arreglo = $row_inf;
		}
		return $arreglo;
	}
	
	public function validarUsername($username)
	{
		$query = "SELECT * FROM login WHERE userName= '". mysqli_real_escape_string($this->dbLink, $username)."'";
		$arreglo = array();
		$resultado = mysqli_query($this->dbLink, $query);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			$row_inf = mysqli_fetch_assoc($resultado);
			$arreglo = $row_inf;
		}
		return $arreglo;
	
	}


	}

