<?php
require_once FOLDER_MODEL_EXTEND. "model.subtema_curso.inc.php";
include FOLDER_MODEL_EXTEND . 'model.herramientas_curso.inc.php';

include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;




class controladorHerramientas_curso extends ModeloHerramientas_curso{
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
  	
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
		  	$curso = $this->getByCourseId($id);
		  	
		  	return (array("status" => "ok", "message" => "Informacion recuperada con exito.",  "data" => $data, "codigo"=> "200"));
		  	//return $curso;
		  	}
		  	// if decode fails, it means jwt is invalid
		catch (Exception $e){		  		
		  		return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "401"));
		  	}
		  	
  }
  }
  
  public function obtenerByTemaCursoId($id)
  {	$headers = getallheaders();
   //var_dump(($headers));
   //die(var_dump(isset($headers['x-auth-token'])));
   //
  if(!isset($headers['X-Auth-Token']) && empty($headers['X-Auth-Token'])){
  	return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  	http_response_code(401);
  }else{
  	try {        // decode jwt
  		global $key;
  		$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
  		$subTemaCurso = $this->getByTemaCursoId($id);
  		$herramientasubTema=array();
  		$data= array();
  		if(count($subTemaCurso)>0){
  			for($i=0; $i<count($subTemaCurso); $i++){
	  			$her_cur = new ModeloHerramientas_curso();
	  			$herramientasubTema = $her_cur->getBySubTemaId($subTemaCurso[$i]['idSubTema']);
	  			$data[] = array(
	  					"subTemaCurso" => $subTemaCurso[$i],
	  					"herramientasubTema" => $herramientasubTema
	  			);
  			}
  		}
  		return (array("status" => "ok", "message" => "Informacion recuperada con exito.",  "data" => $data, "codigo"=> "200"));
  		//return $curso;
  	}
  	// if decode fails, it means jwt is invalid
  	catch (Exception $e){
  		return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "401"));
  	}
  	 
  }
  }
  
  public function postHerramientasCurso($datos) {
  	$d = json_decode($datos, true);  	
  	global $key;
  	$headers = getallheaders();  	
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);  	
  	}else{
      try {        // decode jwt
        global $key;
        $decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
        if(isset($d['urlHerramienta']) && !empty($d['urlHerramienta']) 
        		&& isset($d['agregarVideo'])        		 
        		&& isset($d['idTema']) && !empty($d['idTema'])
        		&& isset($d['nombreHerramienta']) && !empty($d['nombreHerramienta']) 
        		&& isset($d['duracion']) ){
      			$fecha = date('Y-m-j H:i:s');   		    	  	    	  		
    	  		
    	  		$this->setNombreHerramienta($d['nombreHerramienta']);
    	  		$this->setUrlHerramienta($d['urlHerramienta']);    	  			
    	  		$this->setIdTema($d['idTema']);//tabla subtema_curso
    	  		$this->setFechaRegistro($fecha);
    	  		$this->setEstatusActivo();
    	  		if(!empty($d['agregarVideo'])){
	    	  		$this->setIdTipoHerramienta(1);
	    	  		$this->setAgregarVideo($d['agregarVideo']);  	  		    	  		 
	    	  		$this->setFormatoHerramienta($d['formatoHerramienta']);
    	  		}else{
    	  			$this->setIdTipoHerramienta(2);
    	  			$this->setFormatoHerramienta("pdf");
    	  		}
    	  		$this->setDuracion($d['duracion']);
    	  		$this->setIdUsuarioRegistro($decoded->data->id);
    	  		$this->Guardar();
    	  		if($this->getError()){
    	  			$this->transaccionRollback();
    	  			return (array("status" => "error", "message" => "Error al guardar la informacón." . $this->getStrError() , "codigo"=> "401"));
    	  		}   	  						
				
    	  		//$categ = $this->getCategoriasPorCurso($d['id']);
    	  		return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200" , "data" => $this->getIdHerramientaCurso()));
    	  	
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
  public function putHerramientas_curso($datos) {
  	$d = json_decode($datos, true);
  	//if(!isset($d['token'])){
  	//return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  	global $key;
  	$headers = getallheaders();
  	 
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($d['idHerramientaCurso']) && !empty($d['idHerramientaCurso']) &&	isset($d['agregarVideo']) && !empty($d['agregarVideo']) 
  					&&	isset($d['urlHerramienta']) && !empty($d['urlHerramienta']) ){
  						$fecha = date('Y-m-j H:i:s');
  						$this->setIdHerramientaCurso($d['idHerramientaCurso']);  						
  						$this->setUrlHerramienta($d['urlHerramienta']); 
  						$this->setAgregarVideo($d['agregarVideo']);
  						$this->setFormatoHerramienta($d['formatoHerramienta']);
  						$this->setDuracion($d['duracion']);
  						$this->Guardar();
  						if($this->getError()){  							
  							return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));
  						}  							  	
  							//$categ = $this->getCategoriasPorCurso($d['id']);
  							return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200"));
  						}
  			else if(isset($d['idHerramientaCurso']) && !empty($d['idHerramientaCurso']) &&	isset($d['urlHerramienta']) && !empty($d['urlHerramienta']) &&
  							isset($d['formatoHerramienta']) && !empty($d['formatoHerramienta']) && ($d['formatoHerramienta'] == "pdf") ){
  						$fecha = date('Y-m-j H:i:s');
  						$this->setIdHerramientaCurso($d['idHerramientaCurso']);
  						$this->setIdTipoHerramienta(2);
  						$this->setNombreHerramienta($d['nombreHerramienta']);
  						$this->setFormatoHerramienta("pdf");
  						$this->setUrlHerramienta($d['urlHerramienta']);  						
  						$this->Guardar();
  						if($this->getError()){  							
  							return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));
  						}  							  	
  							//$categ = $this->getCategoriasPorCurso($d['id']);
  							return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200"));
  						}
  			else{
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
  	public function deleteHerramientas_curso($datos) {
  		//
  		$d = json_decode($datos,true);
  		global $key;
  		$headers = getallheaders();
  	 	//die(var_dump($_GET));
  		if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  			return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);
  		}else{
        try {        // decode jwt
          $decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
          // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
          if(isset($_GET['idHerramientaCurso']) && !empty($_GET['idHerramientaCurso']) 
          		&& isset($_GET['estatus']) && !empty($_GET['estatus'])){
          			$this->setIdHerramientaCurso($_GET['idHerramientaCurso']);
          			$this->setEstatusSuspendido();
          			//$this->setFdfecha_registro($fecha);
          			$this->Guardar();
          			if($this->getError()){
          				return json_encode(array("status" => "error", "message" => "ocurrio un Error."));
          			
          			}else{
          				return json_encode(array("status" => "ok", "message" => "Informacion eliminada con exito."));;
          			}
          }else       if(isset($_GET['idHerramientaCurso']) && !empty($_GET['idHerramientaCurso'])){
      			$fecha = date('Y-m-j H:i:s');
      			$this->setIdHerramientaCurso($_GET['idHerramientaCurso']);
      			$this->setUrlHerramienta(""); 
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
