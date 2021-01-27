<?php
//CLASE PRINCIPAL
require_once CLASS_CONEXION;
$ConexionPrincipal = new ConexionBD();
class clsBasicCommon  
{
	#-----------------------------------------------------------------------------------------------#
	#-------------------------------------------Variables-------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	var $error=false;
	var $strError="";
	var $warning=false;
	var $arrWarning=array();

	var $debug=false;
	var $debugFile=false;
	var $debugFileName="";

	var $strSystemError;

	var $dbLink;
	var $link;

	var $__s=array();



	#-----------------------------------------------------------------------------------------------#
	#------------------------------------Constructor Destructor-------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function __construct()
	{
	    global $ConexionPrincipal;
	    if(is_null($ConexionPrincipal->getConexion()))
	    {
	        trigger_error("La coneccion a la base de datos no esta establecida.",E_USER_ERROR);
	        return;
	    }
	    $this->dbLink=$ConexionPrincipal->getConexion();
	    $this->link=$ConexionPrincipal->getConexion();
	    
	}
	


	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------Setter Getter-----------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function clearError()
	{
		$this->error=false;
		$this->strError="";
	}

	public function setError($msg)
	{
		$this->error=true;
		$this->strError=$msg;
		return false;
	}

	public function setSystemError($msg,$msgSystem)
	{
		$this->strSystemError=$msgSystem;
		return $this->setError($msg);

	}

	public function getError()
	{
		return $this->error;
	}

	public function getStrError()
	{
		if(defined("DEVELOPER")&&DEVELOPER)
			return $this->strError . ($this->strSystemError!=""?"::SYSERROR: " . $this->strSystemError : "");
		return $this->strError;
	}

	public function getStrSystemError()
	{
		return $this->strSystemError;
	}

	public function setWarning($msg)
	{
		$this->warning=true;
		$this->arrWarning[]=$msg;
	}

	public function getWarning()
	{
		return $this->warning;
	}
	public function getArrWarning()
	{
		return $this->arrWarning;
	}

	public function getStrWarning($s="<br />")
	{
		return implode($s,$this->arrWarning);
	}

	public function clearWarning()
	{
		$this->warning=false;
		$this->arrWarning=array();
	}

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#


	#-----------------------------------------------------------------------------------------------#
	#---------------------------------------------Otras---------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function toUpper()
	{
		foreach($this->__s as $k=>$v)
			$this->$v=strtoupper($this->$v);
	}


	public function transaccionIniciar()
	{
		if(function_exists("mysqli_begin_transaction"))
		{
			$r=mysqli_begin_transaction($this->dbLink);
		}
		else
		{
			$query="START TRANSACTION";
			$r=mysqli_query($this->dbLink, $query);
		}
		if(!$r)
			return $this->setSystemError("Error en la BD", mysql_error());
		return true;
	}

	public function transaccionCommit()
	{
		if(function_exists("mysqli_commit"))
		{
			$r=mysqli_commit($this->dbLink);
		}
		else
		{
			$query="COMMIT";
			$r=mysqli_query($this->dbLink, $query);
		}
		if(!$r)
			return $this->setSystemError("Error en la BD", mysql_error());
		return true;

	}

	public function transaccionRollback()
	{
		if(function_exists("mysqli_rollback"))
		{
			$r=mysqli_rollback($this->dbLink);
		}
		else
		{
			$query="ROLLBACK";
			$r=mysqli_query($this->dbLink, $query);
		}
		if(!$r)
			return $this->setSystemError("Error en la BD", mysql_error());
		return true;
	}




	public function Clonar($obj)
	{
		foreach($this->__s AS $k=>$v)
		{
			if(isset($obj->$v))
			{
				$this->$v=$obj->$v;
			}
		}


	}

	public function serialize()
	{
		$valores=array();
		foreach($this->__s AS $k=>$v)
		{
			$valores[$v]=$this->$v;
		}
		return serialize($valores);
	}

	public function unserialize($v)
	{

		$valores=unserialize($v);
		foreach($valores AS $k=>$v)
		{
			$this->$k=$v;
		}
	}






}