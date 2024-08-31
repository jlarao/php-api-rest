<?php
header('Access-Control-Allow: *');
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';


if($_SERVER['REQUEST_METHOD'] == "GET"){
  
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorInscripcion.php";
	$cursos = new controladorInscritos();
	$r  = $cursos->postCursos($datos);
	header("Content-Type: application/json; charset=UTF-8");
if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
	echo json_encode($r);
  
}elseif($_SERVER['REQUEST_METHOD'] == "PUT"){
  //echo "ut";
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorInscripcion.php";
	$cursos = new controladorInscritos();
	$usuario  = $cursos->putCurso($datos);
	header("Content-Type: application/json; charset=UTF-8");
if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
	echo json_encode($usuario);
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE"){
  //echo "delete";
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorCursos.php";
	$cursos = new controladorCursos();
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
