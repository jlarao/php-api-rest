<?php
header('Access-Control-Allow: *');
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';
//require_once FOLDER_MODEL_EXTEND. "model.talogin.inc.php";

if($_SERVER['REQUEST_METHOD'] == "GET"){
  if( isset($_GET['page']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
  	$usuarios = new controladorUsuarios();
    header("Content-Type: application/json; charset=UTF-8");
  	echo json_encode($usuarios->obtenerUsuarios($_GET['page'],5));
    http_response_code(200);
    //echo "get";
  }elseif( isset($_GET['id']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
  	$usuarios = new controladorUsuarios();
    header("Content-Type: application/json; charset=UTF-8");
  	echo json_encode($usuarios->obtenerUsuario($_GET['id']));
    http_response_code(200);
    //echo "get";
  }elseif( isset($_GET['instructor']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
  	$usuarios = new controladorUsuarios();
    header("Content-Type: application/json; charset=UTF-8");
  	$usuario = $usuarios->obtenerInstructor($_GET['instructor']);
  	if(isset($usuario['status'])=="ok"){
  		http_response_code(200);
  	}if(isset($usuario['status'])=="error"){
  		if(isset($usuario['codigo'])){
  			http_response_code($usuario['codigo']);//http_response_code(401);
  		}
  	}else{
  		http_response_code(200);
  	}
  	echo json_encode($usuario);
  }
elseif( isset($_GET['usuarios_rol']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
  	$usuarios = new controladorUsuarios();
    header("Content-Type: application/json; charset=UTF-8");
  	$usuario = $usuarios->obtenerUsuariosRol();
  	if(isset($usuario['status'])=="ok"){
  		http_response_code(200);
  	}if(isset($usuario['status'])=="error"){
  		if(isset($usuario['codigo'])){
  			http_response_code($usuario['codigo']);//http_response_code(401);
  		}
  	}else{
  		http_response_code(200);
  	}
  	echo json_encode($usuario);
  
}
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
  $datos = file_get_contents("php://input");
  require_once 'masterInclude.inc.php';
  require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
  $usuarios = new controladorUsuarios();
  $usuario  = $usuarios->postUsuario($datos);
  header("Content-Type: application/json; charset=UTF-8");
  if(isset($usuario['status'])=="ok"){
  	http_response_code(200);
  }if(isset($usuario['status'])=="error"){
  	if(isset($usuario['codigo'])){
  		http_response_code($usuario['codigo']);//http_response_code(401);
  	}
  }else{
  	http_response_code(200);
  }
  echo $usuario;
}elseif($_SERVER['REQUEST_METHOD'] == "PUT"){
  //echo "ut";
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
	$usuarios = new controladorUsuarios();
	$usuario  = $usuarios->putUsuario($datos);
	header("Content-Type: application/json; charset=UTF-8");
	if(isset($usuario['status'])=="ok"){
		http_response_code(200);

	}else{
		http_response_code(200);
	}
	echo json_encode($usuario);
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){
  //echo "delete";
	//$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
	$usuarios = new controladorUsuarios();
	$usuario  = $usuarios->deleteUsuario();
	header("Content-Type: application/json; charset=UTF-8");
	if(isset($usuario['status'])=="ok"){
		http_response_code(200);

	}else{
		http_response_code(200);
	}
	echo $usuario;
}else{
  header("Content-Type: application/json; charset=UTF-8");
  echo json_encode(array("status" => "error", "message" => "Metodo no permitido."));
  http_response_code(405);
}
?>
