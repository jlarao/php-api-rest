<?php
session_start();

date_default_timezone_set('America/Mexico_City');


if (! DEVELOPER) {
    /**
     * constantes de producci�n
     */
    define("FOLDER_INCLUDE", $_SERVER['DOCUMENT_ROOT'] . "/include/");

    define("FOLDER_HTDOCS", $_SERVER['DOCUMENT_ROOT'] . "/");

    define("ERR_DEBUG", false);
    define("SESSION_TIME", 1800);
    define("SOPORTE_TIME", 600);

  } else {
    /**
     * constantes de desarrollo
     *
     */
    define("FOLDER_INCLUDE", $_SERVER['DOCUMENT_ROOT'] . "/rest/api/include/");

    define("FOLDER_HTDOCS", $_SERVER['DOCUMENT_ROOT'] . "/rest/api/");

    define("ERR_DEBUG", true);
  }

/*
 * DEFINIR VARIABLES
 */
define("CLASS_CONEXION", FOLDER_INCLUDE.'Conexion/Conexion.php');


define("FOLDER_LIB", FOLDER_INCLUDE . "lib/");


define("FOLDER_MODEL", FOLDER_INCLUDE . "model/");
define("FOLDER_MODEL_BASE", FOLDER_MODEL . "base/");
define("FOLDER_MODEL_EXTEND", FOLDER_MODEL . "extend/");

define("FOLDER_MODEL_DATA", FOLDER_INCLUDE . "model/data/");

define("FOLDER_LOG", FOLDER_INCLUDE . 'log/');

define("LIB_EXCEPTION", FOLDER_LIB . "Excepciones/Exception.php");


//define("LIB_XAJAX", FOLDER_LIB . "xajax_core/xajax.inc.php");

define("CLASS_COMUN", FOLDER_MODEL_DATA . "clsBasicCommon.inc.php");

define("CLASS_SESSION", FOLDER_MODEL_DATA . "clsSession.inc.php");


define("URL_JAVASCRIPT", "js/system/");

define("FOLDER_CONTROLLER", FOLDER_INCLUDE . "controler/");

define("FOLDER_JS", FOLDER_HTDOCS . "js/system/");


/*******************************************************/

require_once(CLASS_COMUN);
require_once CLASS_SESSION;

//verifica que se inici� sesi�n
/*
 * crea un objeto de la clase clsSession sin asignarle informaci�n
 * */
$objSession=new clsSession();
$sesion=false;
if(isset($_SESSION['objSession'])){
  $objSession=unserialize($_SESSION['objSession']);
  $sesion=true;
    if($objSession->isSessionActive()){
      $objSession->updateTime();
      $_SESSION['objSession']=serialize($objSession);
    }else {
      header("Location: logout.php");
    }
  }else {
  }

$pedazos=explode("/", $_SERVER['PHP_SELF']);
$__FILE_NAME__=str_replace(array("/",".php"),"",$pedazos[count($pedazos)-1]);

if(is_file(FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php")){
  require_once(FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php");
}



//ini_set('max_execution_time', 5000);
//ini_set('max_input_time', 5000);
//ini_set('memory_limit',500M);
  //require_once FOLDER_MODEL_EXTEND.'model.tapermiso.inc.php';

  //$permisos= new ModeloTapermiso();//obtenemos el menu
  //$_SESSION['menus']=$permisos->getMenus();

 /* if ($sesion){
      if (in_array($__FILE_NAME__, $_SESSION['menus'])){
          if (!in_array($__FILE_NAME__, $_SESSION['menus_rol']))
              header("Location: accesoRestringido.php");
      }
  }else {
      if (in_array($__FILE_NAME__,$_SESSION['menus']))
          header("Location: login.php");
  }*/
      if (!function_exists('getallheaders')) {
      	function getallheaders() {
      
      		$headers = [];
      		foreach($_SERVER as $name => $value) {
      			if($name != 'HTTP_MOD_REWRITE' && (substr($name, 0, 5) == 'HTTP_' || $name == 'CONTENT_LENGTH' || $name == 'CONTENT_TYPE')) {
      				$name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', str_replace('HTTP_', '', $name)))));
      				if($name == 'Content-Type') $name = 'Content-type';
      				$headers[$name] = $value;
      			}
      		}
      		return ($headers);
      	}
      }
$_NOW_=date("Y-m-d H:i:s");
$key = "XAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9";
?>
