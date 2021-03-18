<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT");
//Header ("Access-Control-Allow-Headers:append,delete,entries,foreach,get,has,keys,set,values,Authorization");
header ("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';
require_once FOLDER_LIB . "getid3/getid3.php";
//require_once FOLDER_MODEL_EXTEND. "model.talogin.inc.php";
function obtenernombre($nombre)
{
	$nombre=strtr($nombre,' ','-');
	$nombre=strtr($nombre,'ñÑçÇáÁéÉíÍóÓúÚäÄëËïËöÖüÜàÀè ÈìÌòÒùÙâÂêÊîÎôÔûÛ[]´:+ºª!|"@#$%&/=?¡¿{},;*+\'\\+.',
			'nnccaaeeiioouuaaeeieoouuaaeeiioouuaaeeiioouu ');
	$nombre=str_replace(' ','',$nombre);
	$nombre=str_replace('----','-',$nombre);
	$nombre=str_replace('---','-',$nombre);
	$nombre=str_replace('--','-',$nombre);
	return strtolower($nombre);
}

if($_SERVER['REQUEST_METHOD'] == "GET"){
	if( isset($_GET['maxFile']) ){
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_mb = min($max_upload, $max_post, $memory_limit);
		
		http_response_code(200);
		echo json_encode($upload_mb);
	}
	else{
  http_response_code(200);
  header("Content-Type: application/json; charset=UTF-8");
  echo json_encode(array());
	}
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_FILES["video"] )){		
		$file_size = $_FILES['video']['size'];
		if($file_size<0){			
			echo json_encode(array("status" => "error", "message" => "Video no encontrado tamaño .", "data"=>$file_size));
			http_response_code(400);
			die([]);		}
			
	if( is_uploaded_file($_FILES["video"]["tmp_name"])){
		$tmp_file = $_FILES["video"]["tmp_name"];
		$video_name = $_FILES["video"]["name"];
		$video_name = obtenernombre($video_name);
		$uploader_dir ="./videos/".$video_name;
		//echo $uploader_dir ;
		$ruta = $_SERVER['REQUEST_SCHEME'] ."://". $_SERVER['SERVER_NAME'].":" .$_SERVER['SERVER_PORT'] .  "/rest/api/videos/"   .$video_name;
	if(move_uploaded_file($tmp_file,$uploader_dir)){
		$getID3 = new getID3;
		$file = $getID3->analyze($uploader_dir);
		/*echo("Duration: ".$file['playtime_string'].
				" / Dimensions: ".$file['video']['resolution_x']." wide by ".$file['video']['resolution_y']." tall".
				" / Filesize: ".$file['filesize']." bytes<br />");*/
		if(isset($file['playtime_string']))
			$duracion = $file['playtime_string'];//ogg no soportado // checar webm tenga duracion en vlc player, si no tiene no lo soporta
		else $duracion="00:00";
  $datos = file_get_contents("php://input");
  require_once 'masterInclude.inc.php';
  require_once FOLDER_CONTROLLER. "controladorRegistrarUsuario.php";
  //$registrarUsuario = new controladorRegistrarUsuario();
  //$usuario  = $registrarUsuario->postRegistrarUsuario($datos);
  header("Content-Type: application/json; charset=UTF-8");
	echo json_encode(array("status" => "ok", "message" => "Información almacenada con exito." ,"path"=>"$ruta","Duration"=>$duracion));
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
		echo json_encode(array("status" => "error", "message" => "Video no encontrado.","data"=>$_FILES));
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
