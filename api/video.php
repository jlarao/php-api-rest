<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT");
//Header ("Access-Control-Allow-Headers:append,delete,entries,foreach,get,has,keys,set,values,Authorization");
header ("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';
//require_once FOLDER_MODEL_EXTEND. "model.talogin.inc.php";

if($_SERVER['REQUEST_METHOD'] == "GET"){  
  http_response_code(200);
  header("Content-Type: application/json; charset=UTF-8");
  echo json_encode(array());
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_FILES["video"] )){		
		$file_size = $_FILES['video']['size'];
		if($file_size<0){			
			echo json_encode(array("status" => "error", "message" => "Video no encontrado."));
			http_response_code(200);
			die();		}
			
	if( is_uploaded_file($_FILES["video"]["tmp_name"])){
		$tmp_file = $_FILES["video"]["tmp_name"];
		$video_name = $_FILES["video"]["name"];
		$uploader_dir ="./videos/".$video_name;
		$ruta = $_SERVER['REQUEST_SCHEME'] ."://". $_SERVER['SERVER_NAME'].":" .$_SERVER['SERVER_PORT'] .  "/rest/api/videos/"   .$video_name;
	if(move_uploaded_file($tmp_file,$uploader_dir)){

  $datos = file_get_contents("php://input");
  require_once 'masterInclude.inc.php';
  require_once FOLDER_CONTROLLER. "controladorRegistrarUsuario.php";
  //$registrarUsuario = new controladorRegistrarUsuario();
  //$usuario  = $registrarUsuario->postRegistrarUsuario($datos);
  header("Content-Type: application/json; charset=UTF-8");
	echo json_encode(array("status" => "ok", "message" => "Información almacenada con exito." ,"path"=>"$ruta"));
		http_response_code(200);
	}else{
		echo json_encode(array("status" => "error", "message" => "No se pudo almacenar el video en le servidor." .$uploader_dir));
		http_response_code(200);
	}
	}else{
		echo json_encode(array("status" => "error", "message" => "No hay video que cargar."));
		http_response_code(200);
	}
	}else{
		echo json_encode(array("status" => "error", "message" => "Video no encontrado."));
		http_response_code(200);
	}
  //echo $usuario;
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
	echo $usuario;
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){
  //echo "delete";
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorUsuarios.php";
	$usuarios = new controladorUsuarios();
	$usuario  = $usuarios->deleteUsuario($datos);
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
