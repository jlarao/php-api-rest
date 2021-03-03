<?php

function conectar($db)
{
	$link=mysqli_connect("localhost","root","");
	if(!$link)
		die(mysqli_error());
	if(!mysqli_select_db($link,$db))
		die(mysqli_error($link));
	return $link;
}

if(isset($_POST['BD']))
{
	$link=conectar($_POST['BD']);

	if(trim($_POST['tablas'])!="")
	{
		$tablas=explode(",",$_POST['tablas']);



		foreach($tablas AS $k=>$tabla)
			$tablas[$k]=trim($tabla);
	}
	else
	{
		$SQL="SHOW TABLES";
		$record=mysqli_query($link,$SQL);
		if(!$record)
			die(mysqli_error());
		$tablas=array();
		while($row=mysqli_fetch_array($record))
		{
			$tablas[]=$row[0];
		}
	}



	foreach($tablas AS $k=>$tabla)
	{
		$SQL="DESCRIBE " . $tabla;
		$record=mysqli_query($link,$SQL);
		if(!$record)
			die(mysqli_error($link));
		$campos=array();
		while($row=mysqli_fetch_assoc($record))
		{
			$campos[]=$row;
		}

		$nombreArchivo="model.base." . $tabla . ".inc.php";
		$nombreArchivo2="model." . $tabla . ".inc.php";
		$nombreClase="ModeloBase" . ucfirst($tabla);
		$nombreClase2="Modelo" . ucfirst($tabla);

		$varCampos=array();
		$get=array();
		$set=array();
		$unset=array();
		$primaria="";
		$Propiedades=array();
		$limpiar=array();

		foreach($campos AS $j=>$campo)
		{
			$varCampos[]=$campo['Field'];
			$col=$campo['Field'];
			$Col=ucfirst($col);
			$p="";
			$v="";
			if($campo["Key"]=="PRI")
			{
				if(substr($campo['Type'], 0,3)=='int' ||substr($campo['Type'], 0,7)=='tinyint' )
					$v='if($' . $col . '==0||$' . $col . '==""||!is_numeric($' . $col . ')|| (is_string($' . $col . ')&&!ctype_digit($' . $col . ')))return $this->setError("Tipo de dato incorrecto para ' . $col . '.");';
				else
					$v='if(trim($' . $col . ')=="")return $this->setError("El valor ' . $col . ' no puede ser vacio.");';
				$primaria=$campo['Field'];
				$p="\n\t\t\t\$this->getDatos();";
			}



			$get[]="\n\t\tpublic function get" . $Col . "()\n\t\t{\n\t\t\treturn \$this->" . $col . ";\n\t\t}";

			if(substr($campo['Type'], 0,3)=='int')
			{
				$Propiedades[]="\n\t\tvar \$" . $col . "=0;";
				$limpiar[]="\n\t\t\t\$this->" . $col . "=0;";
				$set[]="\n\t\tpublic function set" . $Col . "(\$" . $col . ")\n\t\t{\n\t\t\t" . $v . "\n\t\t\t\$this->" . $col . "=\$" . $col . ";" . $p . "\n\t\t}";
			}
			elseif(substr($campo['Type'], 0,4)=='enum')
			{
				$Propiedades[]="\n\t\tvar \$" . $col . "='" . $campo['Default'] . "';";
				$limpiar[]="\n\t\t\t\$this->" . $col . "='" . $campo['Default'] . "';";
				$valores=explode("(",$campo['Type']);
				$valores=explode(")",$valores[1]);
				$valores=$valores[0];
				$valores=explode(",",$valores);
				$set[]="\n\t\tpublic function set" . $Col . "(\$" . $col . ")\n\t\t{\n\t\t\t" . $v . "\n\t\t\t\$this->" . $col . "=\$" . $col . ";" . $p . "\n\t\t}";
				foreach($valores AS $kk=>$valor)
				{
					$valor=str_replace("'","", $valor);
					$Valor=ucfirst($valor);
					$set[]="\n\t\tpublic function set" . $Col . $Valor . "()\n\t\t{\n\t\t\t\$this->" . $col . "='" . $valor . "';\n\t\t}";
				}
			}
			elseif($campo['Type']=="date")
			{
				$Propiedades[]="\n\t\tvar \$" . $col . "='';";
				$limpiar[]="\n\t\t\t\$this->" . $col . "='';";
				$set[]="\n\t\tpublic function set" . $Col . "(\$" . $col . ")\n\t\t{\n\t\t\t\$this->" . $col . "=\$" . $col . ";\n\t\t}";
			}
			elseif(substr($campo['Type'], 0,7)=='varchar')
			{
				$Propiedades[]="\n\t\tvar \$" . $col . "='" . $campo['Default'] . "';";
				$limpiar[]="\n\t\t\t\$this->" . $col . "='" . $campo['Default'] . "';";
				$set[]="\n\t\tpublic function set" . $Col . "(\$" . $col . ")\n\t\t{\n\t\t\t" . $v . "\n\t\t\t\$this->" . $col . "=\$" . $col . ";" . $p . "\n\t\t}";
			}

			elseif(substr($campo['Type'], 0,7)=='tinyint')
			{
				$Propiedades[]="\n\t\tvar \$" . $col . "='" . $campo['Default'] . "';";
				$limpiar[]="\n\t\t\t\$this->" . $col . "='" . $campo['Default'] . "';";
				$set[]="\n\t\tpublic function set" . $Col . "()\n\t\t{\n\t\t\t\$this->" . $col . "=1;\n\t\t}";
				$unset[]="\n\t\tpublic function unset" . $Col . "()\n\t\t{\n\t\t\t\$this->" . $col . "=0;\n\t\t}";
			}
			else
			{
				$Propiedades[]="\n\t\tvar \$" . $col . "='';";
				$limpiar[]="\n\t\t\t\$this->" . $col . "='';";
				$set[]="\n\t\tpublic function set" . $Col . "(\$" . $col . ")\n\t\t{\n\t\t\t\$this->" . $col . "=\$" . $col . ";" . $p . "\n\t\t}";
			}
		}

		#forma Propiedades $Propiedades
		#forma limpiar $limpiar

		$Limpiar='

		protected function limpiarPropiedades()
		{
			' . implode("",$limpiar) . '
		}

		';




		#forma s_array()
		$__s="var \$__s=array(\"" . implode('","',$varCampos) . "\");";

		#forma Insertar

		$Binds=array();
		$update=array();
		$valuesDosPuntos=array();
		$Campos=array();
		$Insertar=array();
		
		

		foreach($varCampos AS $k=>$col)
		{
			if($col!=$primaria)
			{
				//$colDos=":" . $col;
				
				$Campos[]=$col;
				$ins='\'" . mysqli_real_escape_string($this->dbLink,$this->' . $col . ') . "\'';
				$Insertar[]=$ins;
				$update[]=$col . '=' . $ins;
			}
		}

		$Insertar='
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO ' . $tabla . '(' . implode(",",$Campos) . ')
						VALUES(' . implode(",",$Insertar) . ')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][' . $nombreClase . '::Insertar]");
				
				$this->' . $primaria . '=mysqli_insert_id($this->dbLink);
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		';

		#forma Actualizar
		$Actualizar='
		protected function Actualizar()
		{
			try
			{
				$SQL="UPDATE ' . $tabla . ' SET ' . implode(",",$update) . '
					WHERE ' . $primaria . '=" . $this->' . $primaria . ';
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][' . $nombreClase . '::Update]");
				
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		';


		#forma Guardar

		$Guardar='
		public function Guardar()
		{
			if(!$this->validarDatos())
				return false;
			if($this->getError())
				return false;
			if($this->' . $primaria . '==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		';



		#forma GetDatos

		$Getatos='
		public function getDatos()
		{
			try
			{
				$SQL="SELECT
						' . implode(",",$varCampos) . '
					FROM ' . $tabla . '
					WHERE ' . $primaria . '=" . mysqli_real_escape_string($this->dbLink,$this->' . $primaria . ');
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[' . $nombreClase . '::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

				if(mysqli_num_rows($result)==0)
				{
					$this->limpiarPropiedades();
				}
				else
				{
					$datos=mysqli_fetch_assoc($result);
					foreach($datos as $k=>$v)
					{
						$campo="" . $k;
						$this->$campo=$v;
					}
				}
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		';


		#forma Eliminar

		$Borrar='
		public function Borrar()
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="DELETE FROM ' . $tabla . '
				WHERE ' . $primaria . '=" . mysqli_real_escape_string($this->dbLink,$this->' . $primaria . ');
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][' . $nombreClase . '::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		';


		$salida='<?php

	class ' . $nombreClase . ' extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.' . $nombreClase . '";

		' . implode("",$Propiedades) . '

		' . $__s . '
		var $__ss=array();

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		' . implode("",$set) . '

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		' . implode("",$unset) . '

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		' . implode("",$get) . '

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		' . $Limpiar . '

		' . $Insertar . '

		' . $Actualizar . '

		' . $Borrar . '

		' . $Getatos . '

		' . $Guardar . '
	}

?>';



		$salida2='<?php

	require FOLDER_MODEL_BASE . "' . $nombreArchivo . '";

	class ' . $nombreClase2 . ' extends ' . $nombreClase . '
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="' . $nombreClase . '";

		var $__ss=array();

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function validarDatos()
		{
			return true;
		}


	}

';

		$pf=fopen("../include/model/base/" . $nombreArchivo,"w");
		if(!$pf)
			die("Error en la apertura de archivo");
		fwrite($pf,$salida);
		fclose($pf);

		if(!file_exists("../include/model/extend/" . $nombreArchivo2)){
			$pf=fopen("../include/model/extend/" . $nombreArchivo2,"w");
			if(!$pf)
				die("Error en la apertura de archivo");
			fwrite($pf,$salida2);
			fclose($pf);
		}


	}

	die("Ok");



}

?>
<html>
	<head>
	</head>
	<body>
		<form action="indexMySQL.php" method="post">
			BD:<br /><input type="text" value="" name="BD"><br /><br />
			Tablas<br /><textarea name="tablas"></textarea><br /><br />
			<input type="submit" enviar>
		</form>
	</body>
</html>