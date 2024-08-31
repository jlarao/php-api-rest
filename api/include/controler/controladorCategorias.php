<?php
require_once FOLDER_MODEL_EXTEND. "model.categoria_curso.inc.php";
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


error_reporting(E_ALL);

class controladorCategoria_curso extends ModeloCategoria_curso{
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

  public function obtenerCategorias($pagina,$tamano)
  {
    $categorias = $this->getCategoriasCurso($pagina,$tamano);
    return $categorias;
  }

  public function obtenerCategoria($id)
  {
  	$categoria = $this->getCategoriaCurso($id);
    return $categoria;
  }

  public function postCategoria($datos) {
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
  			if(isset($d['nombreCategoria']) && !empty($d['nombreCategoria'])){
  				$fecha = date('Y-m-j H:i:s');
  				$this->setNombreCategoria($d['nombreCategoria']); 				  				
  				$this->setIdUsuarioRegistro($decoded->data->id);
  				$this->setEstatusActivo();
  				$this->setFechaRegistro($fecha);
  				$this->Guardar();
  				if($this->getError()){
  					return (array("status" => "error", "message" => $this->getStrError()));
  				}else{
  					return (array("status" => "ok", "message" => "Informacion almacenada con exito.",  "idCategoria" => $this->getIdCategoria(), "codigo"=> "200"));
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
  public function putCurso($datos) {
  	//
  	$d = json_decode($datos,true);
  	global $key;
  	$headers = getallheaders();
  	 
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return (array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);
  	}else{
  		try {        // decode jwt
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
  			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
  			if(isset($d['idCategoria']) && !empty($d['idCategoria']) 
  					&& isset($d['nombreCategoria']) && !empty($d['nombreCategoria'])  					
  					){
  						$fecha = date('Y-m-j H:i:s');
  						$this->setIdCategoria($d['idCategoria']);
  						$this->setNombreCategoria($d['nombreCategoria']);
  						//if (isset($d['estatus']) && !empty($d['estatus']))
  							//$this->setEstatus($d['estatus']);    
  						$this->Guardar();
  						if($this->getError()){
  							return array("status" => "error", "message" => $this->getStrError());
  
  						}else{
  								return array("status" => "ok", "message" => "Informacion almacenada con exito.", "codigo"=> "200");
  						}
  			}else{
  				return array("status" => "error", "message" => "Datos enviados incompletos o con formato incorrecto.", "codigo"=> "401");
  			}
  		}
  		// if decode fails, it means jwt is invalid
  		catch (Exception $e){
  			// set response code     //http_response_code(401);
  			// tell the user access denied  & show error message
  			//echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
  			return array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400");
  		}
  	}
  }
  	public function deleteUsuario($datos) {
  		//
  		global $key;
  	$headers = getallheaders();
  	 
  	if(!isset($headers['X-Auth-Token']) && !empty($headers['X-Auth-Token'])){
  		return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
  		http_response_code(401);
  	}else{
  		try {        // decode jwt
  			$decoded = JWT::decode($headers['X-Auth-Token'], $key, array('HS256'));
          // show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/
          if(isset($_GET['idCategoria']) && !empty($_GET['idCategoria'])){
      			$fecha = date('Y-m-j H:i:s');
      			$this->setIdCategoria($_GET['idCategoria']);
      			$this->setEstatusSuspendido();
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
