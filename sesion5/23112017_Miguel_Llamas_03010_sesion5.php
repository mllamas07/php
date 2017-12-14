<?php
	error_reporting(-1);
	ini_set('display_errors', 'on');
	$path="photo";
	$image=new Image($path);
	$image_List=$image->getImages();
	
	class File
	{
		//rutas de las imagenes
		var $ruta = "/";
		var $rutaMini = "/";
		
		//constructor
		public function __construct($path)
		{
			$this->ruta 	= $path;
			$this->rutaMini = $path."/thumbs";
		}	
		
		//creamos directorios si no existen segun un ruta
		protected function createDir()
		{
			//si no existe la carpeta la creamos
			if (!file_exists($this->ruta))
			{
				mkdir($this->ruta,0777,true);	
			}
			
			if (!file_exists($this->rutaMini))
			{
				mkdir($this->rutaMini,0777,true);		
			}	
				
		}
		
		//checkeamos si existen las miniaturas
		protected function checkIfFileExistes($file)
		{
			if (file_exists($this->rutaMini."/".$file))	
				return true;
			else
				return false;
		}
		
		//genero una lista de los ficheros de la ruta
		protected function getFileList()
		{
			$dirname=opendir($this->ruta);
			$files=scandir($this->ruta);
			closedir ($dirname);	
			
			return $files;		
		}		
	}
	
	class System
	{
		public function execCommand($instruccion)
		{
			echo exec($instruccion);
		}	
	}
	
	class Image extends File
	//Se convierte las imagenes a miniatura
	{		
		private function createThumb($file)
		{
			$ExecLinux = new System();
			$ExecLinux->execCommand("convert ".$this->ruta."/$file -resize 40x40 ".$this->rutaMini."/$file");		
		}
		
		private function validatePhoto($file)
		{
			//filtramos las imagenes sólo con estas extensiones
			if (preg_match('/\.(jpg|png|gif)$/', $file))
				return true;
			else 
				return false;
		}
		
		public function getImages()
		{
			
			//miramos si existe las carpetas photo y thumb
			$this->createDir();
			//sacamos la lista de ficheros de la carpeta photos
			$files = $this->getFileList();
			//array de salida
			$image_List = array();
			
			//recorremos el contenido de esa carpeta
			foreach($files as $file)
			{
				//tiene que ser jpg, gif o png para que muestre las imagenes y que no sea . o ..
				if($file!="." && $file!=".." && $this->validatePhoto($file))
				{				
					//guardo en el array la lista de imagenes
					array_push($image_List, $file);
					
					//miro si existe la imagen en el thumbs si no lo creo
					if(!$this->checkIfFileExistes($file))
					{
						//como NO existe la minituara la creamos
						$this->createThumb("$file");
					}
					//mostramos la miniatura y al hacer clic mostramos original 
										
					echo "<a href='".$this->ruta."/$file' target='_blank' ><img src='".$this->rutaMini."/$file'/></a>";	
				}		
					
			}
			
			
		}
	}
?>		