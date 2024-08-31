<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
Header ("Access-Control-Allow-Headers:append,delete,entries,foreach,get,has,keys,set,values,Authorization");
//header ("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';
//require_once FOLDER_MODEL_EXTEND. "model.talogin.inc.php";

if($_SERVER['REQUEST_METHOD'] == "GET"){  
	if( isset($_GET['page']) ){
		require_once 'masterInclude.inc.php';
		require_once FOLDER_CONTROLLER. "controladorCategorias.php";
		$categorias = new controladorCategoria_curso;
		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode($categorias->obtenerCategorias($_GET['page'],5));
		http_response_code(200);
		//echo "get";
	}elseif( isset($_GET['id']) ){
		require_once 'masterInclude.inc.php';
		require_once FOLDER_CONTROLLER. "controladorCursos.php";
		$categorias = new controladorCategoria_curso();
		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode($categorias->obtenerCategoria($_GET['id']));
		http_response_code(200);
		//echo "get";
	}
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorCategorias.php";
	$datos = file_get_contents("php://input");
	$categorias = new controladorCategoria_curso;
	$usuario  = $categorias->postCategoria($datos);
	header("Content-Type: application/json; charset=UTF-8");
	if(isset($usuario['status']) && $usuario['status']=="ok"){
		http_response_code(200);
	}elseif(isset($usuario['status']) && $usuario['status']=="error"){
		if(isset($usuario['codigo'])){
			http_response_code($usuario['codigo']);//http_response_code(401);
		}else{
			http_response_code(401);
		}
	}
	echo json_encode($usuario);
  	
}elseif($_SERVER['REQUEST_METHOD'] == "PUT"){
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorCategorias.php";
	$categorias = new controladorCategoria_curso;
	$datos = file_get_contents("php://input");
	
	$usuario  = $categorias->putCurso($datos);
	header("Content-Type: application/json; charset=UTF-8");
	if(isset($usuario['status']) && $usuario['status']=="ok"){
		http_response_code(200);
	}elseif(isset($usuario['status']) && $usuario['status']=="error"){
		if(isset($usuario['codigo'])){
			http_response_code($usuario['codigo']);//http_response_code(401);
		}else{
			http_response_code(401);
		}
	}
	echo json_encode($usuario);
	
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorCategorias.php";
	$categorias = new controladorCategoria_curso();
	$usuario  = $categorias->deleteUsuario($datos);
	header("Content-Type: application/json; charset=UTF-8");
if(isset($usuario['status']) && $usuario['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($usuario['status']) && $usuario['status']=="error"){
  	  if(isset($usuario['codigo'])){
  		http_response_code($usuario['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
	echo json_encode($usuario);
}else{
  header("Content-Type: application/json; charset=UTF-8");
  echo json_encode(array("status" => "error", "message" => "Metodo no permitido."));
  http_response_code(405);
}
?>
