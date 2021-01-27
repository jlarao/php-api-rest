<?php
	class madException extends Exception
	{
		public function __construct($message, $code = 0, Exception $previous = null)
		{
			parent::__construct($message, ERR_AUTOR/*, $previous*/);
			if(DEBUG_FILE){
					$msg = "\n\n---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------".
					 "\nDate\t\t:\t". date("Y-m-d H:i:s").
					 "\nMessage\t\t:\t". html_entity_decode($this->getMessage()).
					 "\nFile\t\t:\t". $this->getFile().
					 "\nLine\t\t:\t". $this->getLine().
					 "\nOriginal Msg\t:\t". implode("\t\t", explode("#", $this->__toString())).
					 "\nCode\t\t:\t". $code/*.
					 "\nPrevious\t:\t". $this->getPrevious()*/;
					$fh = fopen(DEBUG_PATH_FILE, 'a+') or die("can't open file");
					fwrite($fh, $msg);
					fclose($fh);
			}
		}
	}
?>