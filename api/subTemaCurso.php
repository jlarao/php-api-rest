<?php
header('Access-Control-Allow: *');
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';


if($_SERVER['REQUEST_METHOD'] == "GET"){
  if( isset($_GET['page']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
  	$cursos = new controladorSubtema_curso();
    //header("Content-Type: application/json; charset=UTF-8");
  	//echo json_encode($cursos->obtenerCursos($_GET['page'],5));
    http_response_code(200);
    echo "get";
  }elseif( isset($_GET['id']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
  	//$cursos = new controladorSubtema_curso();
    //header("Content-Type: application/json; charset=UTF-8");
  	//echo json_encode($cursos->obtenerCurso($_GET['id']));
    http_response_code(200);
    //echo "get";
  }elseif( isset($_GET['byCourse']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
    
  	//$cursos = new controladorSubtema_curso();
    //header("Content-Type: application/json; charset=UTF-8");
  	//$curso = $cursos->obtenerByCourseId($_GET['byCourse']);
  	
  	//if(isset($curso['status']) && $curso['status']=="ok"){
  		http_response_code(200);
  	//}elseif(isset($curso['status']) && $curso['status']=="error"){
  		//if(isset($curso['codigo'])){
  			//http_response_code($curso['codigo']);//http_response_code(401);
  		//}else{
  			//http_response_code(401);
  		//}
  	//}
  	//echo json_encode($curso);
  }elseif( isset($_GET['idTemaCurso']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
    //echo "idTemaCurso";
  	$cursos = new controladorSubtema_curso();
    header("Content-Type: application/json; charset=UTF-8");
  	$curso = $cursos->obtenerByTemaCursoId($_GET['idTemaCurso']);
  	
  	if(isset($curso['status']) && $curso['status']=="ok"){
  		http_response_code(200);
  	}elseif(isset($curso['status']) && $curso['status']=="error"){
  		if(isset($curso['codigo'])){
  			http_response_code($curso['codigo']);//http_response_code(401);
  		}else{
  			http_response_code(401);
  		}
  	}
  	echo json_encode($curso);
  }
  
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
  $datos = file_get_contents("php://input");
  require_once 'masterInclude.inc.php';
  require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
  $cursos = new controladorSubtema_curso();
  $usuario  = $cursos->postSubTemaCurso($datos);
  
  header("Content-Type: application/json; charset=UTF-8");
 // var_dump( $usuario);
  if(isset($usuario['status']) && $usuario['status']=="ok"){  	
  	http_response_code(200);
  }
  if(isset($usuario['status']) && $usuario['status']=="error"){
  	if(isset($usuario['codigo'])){
  		http_response_code($usuario['codigo']);//http_response_code(401);  		
  	}else{  		
  		http_response_code(401);
  	}
  }
  echo json_encode($usuario);
}elseif($_SERVER['REQUEST_METHOD'] == "PUT"){
  //echo "ut";
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
	$cursos = new controladorTema_Curso();
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
	require_once FOLDER_CONTROLLER. "controladorsubTemaCurso.php";
	$cursos = new controladorTema_Curso();
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
