<?php
//header
header("Access-Control-Allow-Origin: http://localhost:81/rest/api/loginjwt");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'php-jwt-master/src/BeforeValidException.php';
    include_once 'php-jwt-master/src/ExpiredException.php';
    include_once 'php-jwt-master/src/SignatureInvalidException.php';
    include_once 'php-jwt-master/src/JWT.php';
    use \Firebase\JWT\JWT;

    error_reporting(0);
if($_SERVER['REQUEST_METHOD'] == "POST"){   
    global $key;
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60); // valid for 1 hour
    $issuer = "http://localhost:81/rest/api/";
    $_POST = json_decode(file_get_contents("php://input"), true);

    require_once 'masterInclude.inc.php';
    require_once FOLDER_MODEL_EXTEND. "model.login.inc.php";
    if(isset($_POST['usuario']) && isset($_POST['password'])){
        $login=new ModeloLogin();
        $arrSesion=$login->validarUsuarioPassword(array('username'=>$_POST['usuario'],'password'=>$_POST['password']));//se manda el usuario y contraseña para validar       
        if (!$arrSesion[0]){      //si no se encuentra muestra el error           
            http_response_code(401);
        // tell the user login failed
        echo json_encode(array("status" => "error","message" => "Usuario o contraseña incorrectos."));
        }else{          
        $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "id" => $arrSesion[1]['idUsuario'],
            "firstname" => $arrSesion[1]['nombre'],
            "lastname" => $arrSesion[1]['apellidos'],
            "email" => $arrSesion[1]['correoElectronico']
        )
        );
        // set response code
        http_response_code(200);
        // generate jwt
        $jwt = JWT::encode($token, $key);
        echo json_encode(
                array("status" => "ok",
                    "message" => "Successful login.",
                    "token" => $jwt,
                	"data"=> $token["data"]
                )
            );
            //$decoded = JWT::decode($jwt, $key, array('HS256'));
            //print_r($decoded);
    }

    // login failed will be here
        }
    //}
    else{
        //die(json_encode('No hay parametros'));
        http_response_code(200);
        echo json_encode(array("status" => "error", "message" => "Datos incompletos."));
    }

}else if($_SERVER['REQUEST_METHOD'] == "GET"){
	require_once 'masterInclude.inc.php';
	global $key;
	$headers = getallheaders();
	
	if(!isset($headers['x-auth-token']) && !empty($headers['x-auth-token'])){
		return json_encode(array("status" => "error", "message" => "No autorizado", "codigo"=> "401"));
		http_response_code(401);
	}else{
		try {        // decode jwt// $decoded->data->id			
			$decoded = JWT::decode($headers['x-auth-token'], $key, array('HS256'));
			// show user details /*        echo json_encode(array(            "message" => "Access granted.",            "data" => $decoded->data        ));*/			
				echo  json_encode(array("status" => "ok", "message" => "Procesada correctamente", "codigo"=> "200",  "token" => $headers['x-auth-token'],"usuario"=> $decoded->data));
				http_response_code(200);
			}
		// if decode fails, it means jwt is invalid
		catch (Exception $e){
			// set response code     //http_response_code(401);
			// tell the user access denied  & show error message
			//echo json_encode(array(        "message" => "Access denied.",        "error" => $e->getMessage()    ));
			echo json_encode(array("status" => "error", "message" => $e->getMessage(), "codigo"=> "400"));
			http_response_code(401);
		}
	}
}else{
	//die(json_encode('No hay parametros'));
    echo json_encode(array("status" => "error", "message" => "Metodo no permitido "));
    http_response_code(401);
}
?>
