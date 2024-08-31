<?php
require_once FOLDER_MODEL_EXTEND. "model.inscritos.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.tema_curso.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.subtema_curso.inc.php";
require_once FOLDER_MODEL_EXTEND. 'model.herramientas_curso.inc.php';
require_once FOLDER_MODEL_EXTEND. "model.curso.inc.php";
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


error_reporting(E_ALL);

class controladorInscritos extends ModeloInscritos{
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

  
  public function obtenerCursosAlumno($al)
  {
  	global $key;
  	$headers = getallheaders();
  	if(!isset($headers['X-Auth-Token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($_GET['al']) && isset($_GET['al']) ){
  				$cursos = $this->getCursosAlumnoId($decoded->data->id);
  				return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>$cursos));
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
  public function postCursos($datos) {
  	$d = json_decode($datos, true);
  	
  	global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);  	
  	}else{
      try {        // decode jwt
        global $key;
        $decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['idCurso']) && !empty($d['idCurso']) &&
        		isset($d['idUsuario']) && !empty($d['idUsuario']) 
        		){
      		$fecha = date('Y-m-j H:i:s'); 
 			$this->setIdCurso($d['idCurso']);
 			$this->setIdUsuario($d['idUsuario']);
 			$this->setEstatusActivo();
 			$this->setFecha($fecha);
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		return (array("status" => "error", "message" => $this->getStrError()));
    	  	}else{
    	  		$curso = new ModeloCurso();
    	  		$cursos = $curso->getCursosByIdUsuario($d['idUsuario']);
    	  		return (array("status" => "ok", "message" => "Informacion almacenada con exito.",  "cursos" => $cursos, "codigo"=> "200"));
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
    return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400"));
}
  	}
  }
  public function putCurso($datos) {
  	//
  	$d = json_decode($datos,true);
  	global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		  	
  	}else{
      try {        // decode jwt
        $decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['idInscripcion']) && !empty($d['idInscripcion'])
        		&& isset($d['estatus']) && !empty($d['estatus'])
        		){ 
      		$fecha = date('Y-m-j H:i:s');
      		$this->setIdInscrito($d['idInscripcion']);
      		//$this->setEstatusActivo();      
      		$this->setEstatus($d['estatus']);
      		$this->Guardar();
      		if($this->getError()){
      			return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));

      		}else{
      			return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200"));;
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
    return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400"));
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
