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

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // database connection will be here
    // get posted data
    //$data = json_decode(file_get_contents("php://input"));

    // set product property values
    //$user->email = $data->email;
    //$email_exists = $user->emailExists();
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
        //die(json_encode($arrSesion));
        //$r=new xajaxResponse();

        if (!$arrSesion[0]){      //si no se encuentra muestra el error
            //$r->call('mostrarMsjError',$arrSesion[1],5);
            //print_r (json_encode( $arrSesion));
            http_response_code(401);

        // tell the user login failed
        echo json_encode(array("status" => "error","message" => "Login failed."));
        }else{
            // generate json web token
            //include_once 'config/core.php';

            //json_encode( 'perfil.php');
            //print_r (json_encode( $arrSesion));
            // check if email exists and if password is correct
    //if($email_exists && password_verify($data->password, $user->password)){

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
                    "token" => $jwt
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

}else{
	//die(json_encode('No hay parametros'));
    echo json_encode(array("status" => "error", "message" => "Metodo no permitido popst."));
    http_response_code(200);
}
?>
