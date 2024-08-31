<?php
header('Access-Control-Allow: *');
header('Content-Type: application/json');
require_once 'masterInclude.inc.php';


if($_SERVER['REQUEST_METHOD'] == "GET"){
  if( isset($_GET['page']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	echo json_encode($cursos->obtenerCursos($_GET['page'],6));
    http_response_code(200);
    //echo "get";
  }elseif( isset($_GET['id']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	echo json_encode($cursos->obtenerCurso($_GET['id']));
    http_response_code(200);
    //echo "get";
  }elseif( isset($_GET['instruc']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	$r = $cursos->obtenerCursosInstructor($_GET['instruc']);
  	
    if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
    //var_dump($r);
  	echo json_encode($r);
  }elseif( isset($_GET['idRep']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	$r = $cursos->obtenerCursosRepro($_GET['idRep']);
  	
    if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
    //var_dump($r);
  	echo json_encode($r);
  }elseif( isset($_GET['al']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	$r = $cursos->obtenerCursosAlumno($_GET['al']);
  	
    if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
    //var_dump($r);
  	echo json_encode($r);
  }elseif( isset($_GET['idVen']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	$r = $cursos->obtenerCursosVenta($_GET['idVen']);
  	
    if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
    //var_dump($r);
  	echo json_encode($r);
  }elseif( isset($_GET['idUsuario']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	$r = $cursos->obtenerCursosByIdUsuario($_GET['idUsuario']);
  	
    if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
    //var_dump($r);
  	echo json_encode($r);
  }elseif( isset($_GET['NoInscrito']) ){
    require_once 'masterInclude.inc.php';
    require_once FOLDER_CONTROLLER. "controladorCursos.php";
  	$cursos = new controladorCursos();
    header("Content-Type: application/json; charset=UTF-8");
  	$r = $cursos->obtenerCursosUsuarioNoInscrito($_GET['NoInscrito']);
  	
    if(isset($r['status']) && $r['status']=="ok"){
  	  http_response_code(200);
    }elseif(isset($r['status']) && $r['status']=="error"){
  	  if(isset($r['codigo'])){
  		http_response_code($r['codigo']);//http_response_code(401);
  	  }else{
  		http_response_code(401);
  	  } 
    }
    //var_dump($r);
  	echo json_encode($r);
  }
}
elseif($_SERVER['REQUEST_METHOD'] == "POST"){
  $datos = file_get_contents("php://input");
  require_once 'masterInclude.inc.php';
  require_once FOLDER_CONTROLLER. "controladorCursos.php";
  $cursos = new controladorCursos();
  $usuario  = $cursos->postCursos($datos);
  
  header("Content-Type: application/json; charset=UTF-8");
  //print_r($usuario);
  if(isset($usuario['status']) && $usuario['status']=="ok"){
  	http_response_code(200);
  }elseif(isset($usuario['status']) && $usuario['status']=="error"){
  	if(isset($usuario['codigo'])){
  		http_response_code($usuario['codigo']);//http_response_code(401);
  	}else{
  		http_response_code(401);
  	}
  }
  echo $usuario;
}elseif($_SERVER['REQUEST_METHOD'] == "PUT"){
  //echo "ut";
	$datos = file_get_contents("php://input");
	require_once 'masterInclude.inc.php';
	require_once FOLDER_CONTROLLER. "controladorCursos.php";
	$cursos = new controladorCursos();
	$usuario  = $cursos->putCurso($datos);
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
