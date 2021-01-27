<?php
/*
 * Variables conexion a BD
 */

if (! DEVELOPER) {
    /* variables de la BD */
    define("BD_HOST", "localhost");
    define("BD_USER", "user_linarte");
    define("BD_PASS", "cn@E8sMp89i?2");
    define("BD_DB", "bd_linarte");
    define("BD_CHARSET", "utf8");
} else {
    
    /* variables de la BD */
    define("BD_HOST", "localhost");
    define("BD_USER", "root");
    define("BD_PASS", "");
    define("BD_DB", "elearning");
    define("BD_CHARSET", "utf8");
}


?>