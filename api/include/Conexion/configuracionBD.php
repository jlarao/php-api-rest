<?php
/*
 * Variables conexion a BD
 */

if (! DEVELOPER) {
    /* variables de la BD */
    define("BD_HOST", "sql101.mipropia.com");
    define("BD_USER", "mipc_28108662");
    define("BD_PASS", "Laoj81082");
    define("BD_DB", "mipc_28108662_elearning");
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