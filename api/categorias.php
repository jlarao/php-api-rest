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
  	http_response_code(200);	 
}elseif($_SERVER['REQUEST_METHOD'] == "PUT"){
		http_response_code(200);
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){
	http_response_code(200);
}else{
  header("Content-Type: application/json; charset=UTF-8");
  echo json_encode(array("status" => "error", "message" => "Metodo no permitido."));
  http_response_code(405);
}
?>
