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
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);
  	}else{
  		try {        // decode jwt
  			global $key;
  			$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
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
  if(!isset($headers['x-auth-token']) && empty($headers['x-auth-token'])){
  	return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  	http_response_code(401);
  }else{
  	try {        // decode jwt
  		global $key;
  		$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
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
  
  public function postSubTemaCurso($datos) {
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
        if(isset($d['subTema']) && !empty($d['subTema']) && isset($d['agregarVideo']) && !empty($d['agregarVideo'])
        		&&	isset($d['url']) &&	!empty($d['url']) && isset($d['idTema']) && !empty($d['idTema'])
        		&& isset($d['tituloVideo']) && !empty($d['tituloVideo']) ){
      		$fecha = date('Y-m-j H:i:s');
      		$this->transaccionIniciar();
    	  	$this->setNombreSubTema($d['subTema']);
    	  	$this->setIdTema($d['idTema']);
    	  	$this->setIdUsuarioRegistro($decoded->data->id);
    	  	$this->setFechaRegistro($fecha);    	  	
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		$this->transaccionRollback();
    	  		return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));
    	  	}else{
    	  		require_once FOLDER_MODEL_EXTEND. "model.herramientas_curso.inc.php";
    	  		$her_cur = new ModeloHerramientas_curso();
    	  		$her_cur->setNombreHerramienta($d['tituloVideo']);
    	  		$her_cur->setIdTipoHerramienta(1);
    	  		$her_cur->setUrlHerramienta($d['url']);
    	  		$her_cur->setAgregarVideo($d['agregarVideo']);
    	  		$her_cur->setIdTema($this->getIdSubTema());//tabla subtema_curso 
    	  		$her_cur->setFormatoHerramienta("video/mp4,video/x-m4v,video/*");
    	  		$her_cur->setIdUsuarioRegistro($decoded->data->id);
    	  		$her_cur->Guardar();
    	  		if($her_cur->getError()){
    	  			$this->transaccionRollback();
    	  			return (array("status" => "error", "message" => "Error al guardar la informacón." . $her_cur->getStrError(), "codigo"=> "401"));
    	  		}
    	  		if(isset($d['urlPdf']) && !empty($d['urlPdf']) && isset($d['tituloDocumento']) && !empty($d['tituloDocumento'])){
    	  			$her_cur = new ModeloHerramientas_curso();
    	  			$her_cur->setNombreHerramienta($d['tituloDocumento']);
    	  			$her_cur->setIdTipoHerramienta(2);
    	  			$her_cur->setUrlHerramienta($d['urlPdf']);
    	  			$her_cur->setIdTema($this->getIdSubTema());//tabla subtema_curso
    	  			$her_cur->setFormatoHerramienta("pdf");
    	  			$her_cur->setIdUsuarioRegistro($decoded->data->id);
    	  			$her_cur->Guardar();
    	  			if($her_cur->getError()){
    	  				$this->transaccionRollback();
    	  				return (array("status" => "error", "message" => "Error al guardar la informacón.". $her_cur->getStrError(), "codigo"=> "401"));
    	  			}	
    	  		}
				$this->transaccionCommit();
				
    	  		//$categ = $this->getCategoriasPorCurso($d['id']);
    	  		return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200"));
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
  public function putHerramientas_curso($datos) {
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
  			if(isset($d['idHerramientaCurso']) && !empty($d['idHerramientaCurso'])	 ){
  						$fecha = date('Y-m-j H:i:s');
  						$this->setIdHerramientaCurso('');  						
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
  		if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  			return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);
  		}else{
        try {        // decode jwt
          $decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
          // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
          if(isset($_GET['idHerramientaCurso']) && !empty($_GET['idHerramientaCurso'])){
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
