<?php

/*
 * clase de conexión
*/
require 'configuracionBD.php';

class ConexionBD{
    
    protected $dbLink;
    
    public function __construct(){
        $this->dbLink= new mysqli(BD_HOST,BD_USER,BD_PASS,BD_DB);
        if ($this->dbLink->connect_errno){
            //echo 'existe un error';
            return 'existe un error';
        }
        
        $this->dbLink->set_charset(BD_CHARSET);
        
    }
    
    public function getConexion(){
        return $this->dbLink;
    }
}

?>