<?php
require_once FOLDER_MODEL_EXTEND. "model.expositor.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.login.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.expositor.inc.php";
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


error_reporting(E_ALL);

class controladorExpositor extends ModeloExpositor{
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

  public function obtenerProfesiones($pagina,$tamano)
  {
    $usuarios = $this->getProfesionesExpositor();
    return $usuarios;
  }

  public function obtenerUsuario($id)
  {
  	$usuario = $this->getUsuario($id);
    return $usuario;
  }
  
  public function obtenerInstructor($id)
  {
  	global $key;
  	$headers = getallheaders();
  	//die(var_dump($headers));
  	if(!isset($headers['X-Auth-Token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  	
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($_GET['instructor']) && !empty($_GET['instructor']) ){
  				//$cursos = $this->getCursosInstructorId($decoded->data->id);
  				$usuario = $this->getInstructor($id);
  				$m_exp = new ModeloExpositor();
  				$expositor = $m_exp->getExpositor($id);
  				return (array("status" => "ok", "message" => "Informacion recuperada con exito.", "codigo"=> "200", "data"=>$usuario, "expositor"=>$expositor));
  			}else{
  				return (array("status" => "error", "message" => "parametros faltantes.", "codigo"=> "401", "data"=>Array()));
  			}
  		}
  		// if decode fails, it means jwt is invalid
  		catch (Exception $e){
  			// set response code     //http_response_code(401);
  			// tell the user access denied  & show error message
  			//echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
  			return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400", "data"=>Array()));
  		}
  	}
  	
  	
  	//return $usuario;
  }

  public function postExpositor($datos) {
  	$d = json_decode($datos, true);
  	$headers = getallheaders();
  	if(!isset($headers['X-Auth-Token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  	
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));   // decode jwt        
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['idProfesion']) && !empty($d['idProfesion']) &&
        		isset($d['descripcion']) && !empty($d['descripcion']) &&
        		isset($d['idUsuarioExpositor']) && !empty($d['idUsuarioExpositor'])){
      		$fecha = date('Y-m-j H:i:s');
    	  	$this->setIdProfesion($d['idProfesion']);
    	  	$this->setIdUsuarioExpositor($d['idUsuarioExpositor']);
    	  	$this->setDescripcion($d['descripcion']);    	  	
    	  	$this->setFechaRegistro($fecha);
    	  	$this->setIdUsuarioRegistro($decoded->data->id);
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		return (array("status" => "error", "message" => $this->getStrError()));
    	  	}else{
    	  		return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "data"=> $this->getIdExpositor()));;
    	  	}
      	}else{
      		return (array("status" => "error", "message" => "parametros faltantes.", "codigo"=> "401"));
    	}
    }
    // if decode fails, it means jwt is invalid
catch (Exception $e){
    // set response code     //http_response_code(401);
    // tell the user access denied  & show error message
    //echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
    return json_encode(array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400"));
}
  	}
  }
  public function putUsuario($datos) {
  	//
  	$d = json_decode($datos,true);
  	global $key;
  	$headers = getallheaders();
  	//die(var_dump($headers));
  	if(!isset($headers['X-Auth-Token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  		 
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($d['idUsuario']) && !empty($d['idUsuario'])
  					&& isset($d['nombre']) && !empty($d['nombre'])
  					&& isset($d['apellidoPaterno']) && !empty($d['apellidoPaterno'])
  					&& isset($d['sexo']) && !empty($d['sexo'])
  					&& isset($d['correoElectronico']) && !empty($d['correoElectronico'])
  					//&& isset($d['nombre']) && !empty($d['apellidos'])
  					//&& isset($d['nombre']) && !empty($d['apellidos'])
  					){
  				$this->transaccionIniciar();
  				$this->setIdUsuario($d['idUsuario']);
  				$this->setNombre($d['nombre']);
  				$this->setApellidoPaterno($d['apellidoPaterno']);
  				$this->setApellidoMaterno($d['apellidoMaterno']);
  				$this->setCorreoElectronico($d['correoElectronico']);
  				$this->setSexo($d['sexo']);
  				//$this->setTelefono($d['telefono']);
  				$this->setEstatusActivo();
  				//$this->setFechaRegistro($fecha);
  				if(isset($d['avatar']) && !empty($d['avatar']) ){
  					$this->setAvatar($d['avatar']);
  				}
  				$this->Guardar();
  				if($this->getError()){
  					$this->transaccionRollback();
  					return json_encode(array("status" => "error", "message" => $this->getStrError()));
  				}else{
  					
  					$fecha = date('Y-m-j H:i:s');
  						
  					$login = new ModeloLogin();
  					$idLogin = $login->getLoginByIdUsuario($d['idUsuario']);
  					if($idLogin>0){
  						$login->setIdLogin($idLogin);
  						$login->setIdUsuario($d['idUsuario']);
  						$login->setUserName($d['correoElectronico']);
  						//$login->setIdRol(3);//alumno
  						if(isset($d['password']) && !empty($d['password'])){
  							$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
  							$passwordSalt = hash('sha512', $d['password']. $random_salt);
	  						$login->setSemilla($random_salt);
	  						$login->setPassword($passwordSalt);
  						}
  						$login->setEstatusLoginActivo();
  						$login->setFechaRegistro($fecha);
  							
  						$login->Guardar();
  						if($login->getError()){
  							$this->transaccionRollback();
  							return json_encode(array("status" => "error", "message" => $login->getStrError()));
  							return $r;
  						}
  					}
  					
  					
  					$this->transaccionCommit();
  					
  				return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>""));
  				}
  			}else{
  				return (array("status" => "error", "message" => "parametros faltantes.", "codigo"=> "401", "data"=>Array()));
  			}
  		}
  		// if decode fails, it means jwt is invalid
  		catch (Exception $e){
  			// set response code     //http_response_code(401);
  			// tell the user access denied  & show error message
  			//echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
  			return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400", "data"=>Array()));
  		}
  	}
  }
  	public function deleteUsuario($datos) {
  		//
  		$d = json_decode($datos,true);
      if(!isset($d['token'])){
    		return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
    	}else{
        try {        // decode jwt
          $decoded = JWT::decode($d['token'], $key, array('HS256'));
          // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
          if(isset($d['id'])){
      			$fecha = date('Y-m-j H:i:s');
      			$this->setFiusuario_id($d['id']);
      			$this->setFcestatusSuspendido();
      			//$this->setFdfecha_registro($fecha);
      			$this->Guardar();
      			if($this->getError()){
      				return json_encode(array("status" => "error", "message" => "ocurrio un Error."));

      			}else{
      				return json_encode(array("status" => "ok", "message" => "Informacion eliminada con exito."));;
      			}
      		}else{
      			return json_encode(array("status" => "error", "message" => "Datos enviados incompletos o con formato incorrecto."));
      		}
      }
      // if decode fails, it means jwt is invalid
      catch (Exception $e){
      // set response code     //http_response_code(401);
      // tell the user access denied  & show error message
      //echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
      return json_encode(array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400"));
      }
    	}
  }
}
?>
