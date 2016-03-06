<?php 
			define("DB_RUTA", "localhost");
			define("DB_USUARIO", "root");
			define("DB_PASS", "");
			define("DB_NOMBRE", "appche");
		
			function conectar (){
				$enlace = mysqli_connect(DB_RUTA,DB_USUARIO,DB_PASS,DB_NOMBRE);
				if($enlace){
				}     else{
					die('Error de Conexion (' . mysqli_connect_errno() . ') '.mysqli_connect_error());
				}
				return($enlace);
				mysqli_close($enlace); 
			}
?>
