<?php
require_once FOLDER_MODEL_EXTEND. "model.curso.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.tema_curso.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.subtema_curso.inc.php";
require_once FOLDER_MODEL_EXTEND. 'model.herramientas_curso.inc.php';
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


error_reporting(E_ALL);

class controladorCursos extends ModeloCurso{
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
  public function obtenerCursosInstructor($instruc)
  {
  	//$curso = $this->getCurso($id);
  	//return $curso;
  	global $key;
  	$headers = getallheaders();
  	 //die(var_dump($headers));
  	if(!isset($headers['x-auth-token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  		
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($_GET['instruc']) && isset($_GET['instruc']) ){
  				$cursos = $this->getCursosInstructorId($decoded->data->id);
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
  
  public function obtenerCursosRepro($id)
  {
  	//$curso = $this->getCurso($id);
  	//return $curso;
  	global $key;
  	$headers = getallheaders();
  	//die(var_dump($headers));
  	if(!isset($headers['x-auth-token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($_GET['idRep']) && isset($_GET['idRep']) ){
  				//curso
  				$cursos = $this->getCurso($id);
  				//tema curso by course id
  				$temaCurso = new ModeloTema_curso();
  				$temas = $temaCurso->getByCourseId($id);//id curso
  				//sub temas
  				
  				$curso= new ModeloTema_curso();
  				$arrTemCurso = $curso->getIdsByCourseId($id);//id curso
  				//die(print_r($arrTemCurso));
  				$data= array();
  				for($j=0; $j<count($arrTemCurso); $j++){
  					$subTemaCursoM = new ModeloSubtema_curso();
  					$subTemaCurso = $subTemaCursoM->getByTemaCursoId($arrTemCurso[$j]['idTema']);
  					//die(print_r($subTemaCurso));
  					$herramientasubTema=array();
  				
  					if(count($subTemaCurso)>0){
  						for($i=0; $i<count($subTemaCurso); $i++){
  							$her_cur = new ModeloHerramientas_curso();
  							$herramientasubTema = $her_cur->getBySubTemaId($subTemaCurso[$i]['idSubTema']);
  							$subtemas[] = array(
  									"subTemaCurso" => $subTemaCurso[$i],
  									"herramientasubTema" => $herramientasubTema
  							);
  						}
  					}
  				}
  				$curso = array(
  						"curso" => $cursos,
  						"Temas" => $temas,
  						"subTemas" => $subtemas
  				);
  				//
  				return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>$curso));
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
  public function obtenerCursosVenta($id)
  {
  	
  	global $key;
  	$headers = getallheaders();
  	
  /*	if(!isset($headers['x-auth-token']) ){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401", "data"=>Array()));
  
  	}else{
  		try {       
  			global $key;
  			$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));*/
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($_GET['idVen']) && isset($_GET['idVen']) ){
  				//curso
  				$cursos = $this->getCurso($id);
  				//tema curso by course id
  				$temaCurso = new ModeloTema_curso();
  				$temas = $temaCurso->getByCourseId($id);//id curso
  				//sub temas
  
  				$curso= new ModeloTema_curso();
  				$arrTemCurso = $curso->getIdsByCourseId($id);//id curso
  				//die(print_r($arrTemCurso));
  				$data= array();
  				for($j=0; $j<count($arrTemCurso); $j++){
  					$subTemaCursoM = new ModeloSubtema_curso();
  					$subTemaCurso = $subTemaCursoM->getByTemaCursoId($arrTemCurso[$j]['idTema']);
  					//die(print_r($subTemaCurso));
  					$herramientasubTema=array();
  
  					if(count($subTemaCurso)>0){
  						for($i=0; $i<count($subTemaCurso); $i++){
  							$her_cur = new ModeloHerramientas_curso();
  							$herramientasubTema = $her_cur->getBySubTemaId($subTemaCurso[$i]['idSubTema']);
  							$subtemas[] = array(
  									"subTemaCurso" => $subTemaCurso[$i],
  									"herramientasubTema" => $herramientasubTema
  							);
  						}
  					}
  				}
  				$curso = array(
  						"curso" => $cursos,
  						"Temas" => $temas,
  						"subTemas" => $subtemas
  				);
  				//
  				return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>$curso));
  			}else{
  				return (array("status" => "error", "message" => "parametros faltantes.", "codigo"=> "401", "data"=>Array()));
  			}
  		//}
  		// if decode fails, it means jwt is invalid
  		//catch (Exception $e){
  			// set response code     //http_response_code(401);
  			// tell the user access denied  & show error message
  			//echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
  		//	return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400", "data"=>Array()));
  		//}
  	//}
  }
  public function postCursos($datos) {
  	$d = json_decode($datos, true);
  	//if(!isset($d['token'])){
  		//return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  	global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);  	
  	}else{
      try {        // decode jwt
        global $key;
        $decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['nombre']) && isset($d['categoria']) ){
      		$fecha = date('Y-m-j H:i:s');
    	  	$this->setNombreCurso($d['nombre']);
    	  	$this->setPoster($d['poster']);
    	  	$this->setIdCategoria($d['categoria']);
    	  	$this->setIdUsuarioRegistro($decoded->data->id);
    	  	$this->setFechaRegistro($fecha);    	  	
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		return json_encode(array("status" => "error", "message" => $this->getStrError()));
    	  	}else{
    	  		return json_encode(array("status" => "ok", "message" => "Informacion almacenada con exito.",  "idCurso" => $this->getIdCurso(), "codigo"=> "200"));
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
  public function putCurso($datos) {
  	//
  	$d = json_decode($datos,true);
  	global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);  	
  	}else{
      try {        // decode jwt
        $decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['idCurso']) && !empty($d['idCurso']) && isset($d['nombreCurso']) && !empty($d['nombreCurso'])
        		&& isset($d['que_aprenderas']) && !empty($d['que_aprenderas']) && isset($d['requisitos']) && !empty($d['requisitos'])
        		&& isset($d['idCategoria']) && !empty($d['idCategoria'])){ 
      		$fecha = date('Y-m-j H:i:s');
      		$this->setIdCurso($d['idCurso']);
      		$this->setNombreCurso($d['nombreCurso']);
      		$this->setPoster($d['poster']); 
      		$this->setDescripcion($d['descripcion']);
      		$this->setQue_aprenderas($d['que_aprenderas']);      		
      		$this->setRequisitos($d['requisitos']);
      		//$this->setIdCategoria($d['idCategoria']);
      		$this->setIdCategoria($d['idCategoria']);
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
