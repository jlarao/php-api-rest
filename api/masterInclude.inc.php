<?php
/*
 * Este es el principal php que tendrá el proyecto
 * define la variable DEVELOPER que va a indicar si el proyecto se ejecuta locamente o desde un servidor

 * manda a traer el php en donde se definen y se configuran las variables y rutas
 * además de cargar librerías escenciales del proyecto
 * 
 * este sistema es de una agenda de citas, pero sólo tomé la sección de administración de sucursales
 * */
define("DEVELOPER", true);
require_once 'include/config/constantes.php';

?>