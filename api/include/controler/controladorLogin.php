<?php
require_once FOLDER_MODEL_EXTEND. "model.usuario.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.login.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.expositor.inc.php";
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


error_reporting(E_ALL);

class controladorLogin extends ModeloLogin{
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

  public function obtenerUsuarios($pagina,$tamano)
  {
    $usuarios = $this->getUsuarios($pagina,$tamano);
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
  			if(isset($_GET['instructor']) && isset($_GET['instructor']) ){
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
  public function obtenerUsuariosRol()
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
  			//if(isset($_GET['instructor']) && isset($_GET['instructor']) ){
  				//$cursos = $this->getCursosInstructorId($decoded->data->id);
  				$usuario = $this->getUsuariosRol();
  				
  				return (array("status" => "ok", "message" => "Informacion recuperada con exito.", "codigo"=> "200", "data"=>$usuario));
  			/*}else{
  				return (array("status" => "error", "message" => "parametros faltantes.", "codigo"=> "401", "data"=>Array()));
  			}*/
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

  public function postUsuario($datos) {
  	$d = json_decode($datos, true);
  	if(!isset($d['token'])){
  		return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  	}else{
      try {        // decode jwt
        global $key;
        $decoded = JWT::decode($d['token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['nombre']) && isset($d['apellidos'])){
      		$fecha = date('Y-m-j H:i:s');
    	  	$this->setFcnombre($d['nombre']);
    	  	$this->setFcapellidos($d['apellidos']);
    	  	$this->setFccorreo($d['correo']);
    	  	$this->setFctelefono($d['telefono']);
    	  	$this->setFcestatusActivo();
    	  	$this->setFdfecha_registro($fecha);
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		return json_encode(array("status" => "error", "message" => $this->getStrError()));
    	  	}else{
    	  		return json_encode(array("status" => "ok", "message" => "Informacion almacenada con exito."));;
    	  	}
      	}else{
      		return json_encode(array("status" => "error", "message" => "parametros faltantes.", "codigo"=> "401"));
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
  			if(isset($d['idLogin']) && !empty($d['idLogin'])  					
  					){
  				
  				$this->setIdLogin($d['idLogin']);  				
  				$this->setEstatusLoginActivo();  				
  				$this->Guardar();
  				if($this->getError()){  					
  					return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));
  				}  					
  				return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>""));
  				
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
  	public function deleteLogin() {
  		//
  		$headers = getallheaders();
  	//die(var_dump($headers));
  	if(!isset($headers['X-Auth-Token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  		 
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
          // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
          if(isset($_GET['idLogin']) && !empty($_GET['idLogin'])){
      			$fecha = date('Y-m-j H:i:s');
      			$this->setIdLogin($_GET['idLogin']);
      			$this->setEstatusLoginSuspendido();
      			//$this->setFdfecha_registro($fecha);
      			$this->Guardar();
      			if($this->getError()){
      				return (array("status" => "error", "message" => "ocurrio un Error.", "codigo"=> "401"));

      			}else{
      				return (array("status" => "ok", "message" => "Informacion eliminada con exito.", "codigo"=> "200"));;
      			}
      		}else{
      			return (array("status" => "error", "message" => "Datos enviados incompletos o con formato incorrecto.", "codigo"=> "401"));
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
