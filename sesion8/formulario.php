<html>
	<head>
		<title>UOLS</title>
	</head>
	<body>
		<form action="formulario.php" method="post">
			<div>
				<label for="name">IP:</label>
				<input type="text" name="ip" />
				<label for="name">Netmask:</label>
				<input type="text" name="mask" />
				<button type="submit">Search</button>
		    	</div>
		</form>
		<div>
			<?php
				function PasarMask($mask)
				{
					$long = ip2long($mask);
					$base = ip2long("255.255.255.255");
					return 32-log(($long ^ $base)+1,2);
				}
				if(isset($_POST["ip"]))
				{
					$ip = $_POST["ip"]."/".PasarMask($_POST["mask"]);
					include "conexionGeoip.php";
					$Salida=$Geo->Consulta($ip);
					$Parametros = explode(",",$Salida);
					echo "<p>CP: ".$Parametros[4]."</p>";
					echo "<p>Lat: ".$Parametros[2]."</p>";
					echo "<p>Long: ".$Parametros[3]."</p>";
					echo "<p>Pais: ".$Parametros[1]."</p>";
					echo "<p>Ciudad: ".$Parametros[0]."</p>";
				}
			?>
		</div>
	</body>
</html>
