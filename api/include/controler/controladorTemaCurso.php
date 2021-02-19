<?php
require_once FOLDER_MODEL_EXTEND. "model.tema_curso.inc.php";
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;




class controladorTema_Curso extends ModeloTema_curso{
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

  public function obtenerCursos($pagina,$tamano)
  {
    $cursos = $this->getCursos($pagina,$tamano);
    return $cursos;
  }

  public function obtenerCurso($id)
  {
  	$curso = $this->getCurso($id);
    return $curso;
  } 
  
  public function obtenerByCourseId($id)
  {	$headers = getallheaders();
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
		  	$curso = $this->getByCourseId($id);
		  	return (array("status" => "ok", "message" => "Informacion recuperada con exito.",  "data" => $curso, "codigo"=> "200"));
		  	//return $curso;
		  	}
		  	// if decode fails, it means jwt is invalid
		catch (Exception $e){		  		
		  		return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "401"));
		  	}
		  	
  }
  }
  public function postTemaCurso($datos) {
  	$d = json_decode($datos, true);
  	//if(!isset($d['token'])){
  		//return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  	global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);  	
  	}else{
      try {        // decode jwt
        global $key;
        $decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['seccion']) && isset($d['id'])){
      		$fecha = date('Y-m-j H:i:s');
    	  	$this->setNombreTema($d['seccion']);
    	  	$this->setIdCurso($d['id']);
    	  	$this->setIdUsuarioRegistro($decoded->data->id);
    	  	$this->setFechaRegistro($fecha);    	  	
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));
    	  	}else{
    	  		$categ = $this->getCategoriasPorCurso($d['id']);
    	  		return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>$categ));
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
    return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "401"));
}
  	}
  }
  public function putUsuario($datos) {
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
      		$this->setFcnombre($d['nombre']);
      		$this->setFcapellidos($d['apellidos']);
      		$this->setFccorreo($d['correo']);
      		$this->setFctelefono($d['telefono']);
      		$this->setFcestatusActivo();
      		//$this->setFdfecha_registro($fecha);
      		$this->Guardar();
      		if($this->getError()){
      			return json_encode(array("status" => "error", "message" => $this->getStrError()));

      		}else{
      			return json_encode(array("status" => "ok", "message" => "Informacion almacenada con exito."));;
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
