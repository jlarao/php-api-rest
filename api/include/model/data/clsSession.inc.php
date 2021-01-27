<?php
//CLASE PARA CONTROLAR LA SESIÓN DE UN USUARIO
class clsSession 
{
	#-----------------------------------------------------------------------------------------------#
	#-------------------------------------------Variables-------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	private $userName;
	private $idRol;
	private $nombre;
	private $idUsuario;
	private $apellidos;
	private $correo;
	
	public $_lastTime;
	public $_lastTimeSoporte;


	public $_ejecucionPendiente=array();

	private $_data=array();

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------#
	#--------------------------------------------Control--------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	var $__s=array(	"idUsuario","nombre","apellidos","idRol", "userName");

	public function __construct()
	{

	}


	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------#
	#----------------------------------------Setter Getter------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function setData($k,$v)
	{
		$this->_data[$k]=$v;
	}

	public function getData($k)
	{
		return $this->_data[$k];
	}

	public function getUserName()
	{
		return $this->userName;
	}

	public function getCorreo()
	{
		return $this->correo;
	}
	
	public function getNombre()
	{
	    return $this->nombre;
	}
	
	public function getApellidos()
	{
	    return $this->apellidos;
	}
	
	public function getidUsuario()
	{
	    return $this->idUsuario;
	}
	
	public function getidRol()
	{
	    return $this->idRol;
	}
	
	public function isSessionActive()
	{
		return time()-$this->_lastTime<defined("SESSION_TIME")?SESSION_TIME:1800;
	}

	public function updateTime()
	{
		$this->_lastTime=time();
	}

	public function setObjetoGetInfo($oGI)
	{

		foreach($oGI as $k=>$v)
		{
			if(in_array($k, $this->__s))
			{
				$this->$k=$v;
			}
		}

	}


	public function resetError()
	{
		$this->error=false;
		$this->strError="";
	}

} ?>