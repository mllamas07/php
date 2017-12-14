<?php
$SERVER   = "localhost";
$DATABASE = "geoip";
$USERNAME = "root";
$PASSWORD = "uent1063";

$Geo= new GeoIp($USERNAME,$PASSWORD,$DATABASE,$SERVER);

$Geo->Consulta2($argv[1]);


class Database{

    private $Conexion;	
    protected function __construct($user,$pass,$baseDatos,$ip)
	{
		$this->Conexion = new mysqli($ip, $user, $pass,$baseDatos);
		if ($this->Conexion->connect_errno) 
		{
			echo 'No pudo conectarse a mysql';
			exit;
		}		
    }
    
   protected function ConsultaConRetorno($query)
   {	   
		$resultado = $this->Conexion->query($query);
		if (!$resultado) {
			echo "Error de BD, no se pudo consultar la base de datos $query\n";
			echo "Error MySQL: " . mysql_error();
			exit;
		}

		$salida = "";
		
		while ($fila = $resultado->fetch_assoc()) 
		{
$salida="ciudad:".$fila['country_name'].", pais:".$fila['continent_name'].", lat:".$fila['latitude'].", lon:".$fila['longitude'].", cp:".$fila['postal_code'];
		}

		$resultado->free();
		
		return $salida;
   }
}



class GeoIp extends Database
{
	private $Database;
	
    public function __construct($user,$password,$dbname,$host)
    {		
		$this->Database = new Database($user,$password,$dbname,$host);
    }
    
    public function Consulta2($ip)
    {
		
		$salida = $this->Database->ConsultaConRetorno("Select country_name, continent_name, latitude, longitude, postal_code FROM cities_blocks_ip4 cpb,cities_locations cl WHERE cpb.network='$ip' and cl.geoname_id=cpb.geoname_id");
		echo "$salida\n";
	}
}
?>
