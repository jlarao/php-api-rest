<?php
require_once FOLDER_MODEL_EXTEND. "model.tema_curso.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.subtema_curso.inc.php";
require_once FOLDER_MODEL_EXTEND. "model.curso.inc.php";
require_once FOLDER_MODEL_EXTEND . 'model.herramientas_curso.inc.php';

include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;




class controladorSubtema_curso extends ModeloSubtema_curso{
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
  
  public function obtenerByCursoId($id)
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
  		
  		$curso  = new ModeloTema_curso();
  		$arrTemCurso = $curso->getIdsByCourseId($id);
  		//die(print_r($arrTemCurso));
  		$data= array();
  		for($j=0; $j<count($arrTemCurso); $j++){
  		
  		$subTemaCurso = $this->getByTemaCursoId($arrTemCurso[$j]['idTema']);
  		//die(print_r($subTemaCurso));
  		$herramientasubTema=array();
  		
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
        	$idSbTemaCurso=0;
        	$idHerramientaVideo=0;
        	$idHerramientaDoc=0;
      		$fecha = date('Y-m-j H:i:s');
      		$this->transaccionIniciar();
    	  	$this->setNombreSubTema($d['subTema']);
    	  	$this->setIdTema($d['idTema']);
    	  	$this->setIdUsuarioRegistro($decoded->data->id);
    	  	$this->setFechaRegistro($fecha);
    	  	$this->setEstatusActivo();
    	  	$this->Guardar();
    	  	if($this->getError()){
    	  		$this->transaccionRollback();
    	  		return (array("status" => "error", "message" => $this->getStrError(), "codigo"=> "401"));
    	  	}else{
    	  		$idSbTemaCurso = $this->getIdSubTema();
    	  		require_once FOLDER_MODEL_EXTEND. "model.herramientas_curso.inc.php";
    	  		$her_cur = new ModeloHerramientas_curso();
    	  		$her_cur->setNombreHerramienta($d['tituloVideo']);
    	  		$her_cur->setIdTipoHerramienta(1);
    	  		$her_cur->setUrlHerramienta($d['url']);
    	  		$her_cur->setAgregarVideo($d['agregarVideo']);
    	  		$her_cur->setIdTema($this->getIdSubTema());//tabla subtema_curso 
    	  		$her_cur->setFormatoHerramienta("video/mp4,video/x-m4v,video/*");
    	  		$her_cur->setIdUsuarioRegistro($decoded->data->id);
    	  		$her_cur->setEstatusActivo();
    	  		$her_cur->Guardar();
    	  		if($her_cur->getError()){
    	  			$this->transaccionRollback();
    	  			return (array("status" => "error", "message" => "Error al guardar la informacón." . $her_cur->getStrError(), "codigo"=> "401"));
    	  		}
    	  		$idHerramientaVideo = $her_cur->getIdHerramientaCurso();
    	  		if(isset($d['urlPdf']) && !empty($d['urlPdf']) && isset($d['tituloDocumento']) && !empty($d['tituloDocumento'])){
    	  			
    	  			$her_d = new ModeloHerramientas_curso();
    	  			$her_d->setNombreHerramienta($d['tituloDocumento']);
    	  			$her_d->setIdTipoHerramienta(2);
    	  			$her_d->setUrlHerramienta($d['urlPdf']);
    	  			$her_d->setIdTema($this->getIdSubTema());//tabla subtema_curso
    	  			$her_d->setFormatoHerramienta("pdf");
    	  			$her_d->setIdUsuarioRegistro($decoded->data->id);
    	  			$her_d->setEstatusActivo();
    	  			$her_d->Guardar();
    	  			if($her_d->getError()){
    	  				$this->transaccionRollback();
    	  				return (array("status" => "error", "message" => "Error al guardar la informacón.". $her_d->getStrError(), "codigo"=> "401"));
    	  			}
    	  			$idHerramientaDoc= $her_cur;
    	  		}
				$this->transaccionCommit();
				$subTemaCurso = $this->getByTemaCursoId($d['idTema']);
				$herramientasubTema=array();
				$dataR= array();
				if(count($subTemaCurso)>0){
					for($i=0; $i<count($subTemaCurso); $i++){
						$her_cur = new ModeloHerramientas_curso();
						$herramientasubTema = $her_cur->getBySubTemaId($subTemaCurso[$i]['idSubTema']);
						$dataR = array(
								"subTemaCurso" => $subTemaCurso[$i],
								"herramientasubTema" => $herramientasubTema
						);
					}
				}
    	  		//$categ = $this->getCategoriasPorCurso($d['id']);
    	  		return (array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200", "data"=>$dataR));
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
  	global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);  	
  	}else{
      try {        // decode jwt
        $decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
        // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
         if(isset($d['idSubTema']) && !empty($d['idSubTema'])         		
         		&& isset($d['idTema']) && !empty($d['idTema'])
        		&& isset($d['nombreSubTema']) && !empty($d['nombreSubTema']) ){
      		$fecha = date('Y-m-j H:i:s');
      		$this->setIdSubTema($d['idSubTema']);
      		$this->setIdTema($d['idTema']);
      		$this->setNombreSubTema($d['nombreSubTema']);
      		
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
  		//$d = json_decode($datos,true);
  		global $key;
  	$headers = getallheaders();
  	
  	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		//http_response_code(401);  	
  	}else{
        try {        // decode jwt
          $decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
          // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
          if(isset($_GET['idSubTema']) && !empty($_GET['idSubTema'])){
      			$fecha = date('Y-m-j H:i:s');
      			$this->setIdSubTema($_GET['idSubTema']);
      			$this->setEstatusSuspendido();
      			//$this->setFdfecha_registro($fecha);
      			$this->Guardar();
      			if($this->getError()){
      				return (array("status" => "error", "message" => "ocurrio un Error.", "codigo"=> "400" , "data" => Array()));

      			}else{
      				return (array("status" => "ok", "message" => "Informacion eliminada con exito.", "codigo"=> "200", "data" => Array()));;
      			}
      		}else{
      			return (array("status" => "error", "message" => "Datos enviados incompletos o con formato incorrecto.", "codigo"=> "400", "data" => Array()));
      		}
      }
      // if decode fails, it means jwt is invalid
      catch (Exception $e){
      // set response code     //http_response_code(401);
      // tell the user access denied  & show error message
      //echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
      return (array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400", "data" => Array()));
      }
    	}
  }
}
?>
