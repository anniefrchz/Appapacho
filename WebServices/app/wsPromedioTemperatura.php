<?php
	require_once ('../Controlador/ABCEntidades.php');
      
    function getPromedioSensor($idUsuario) {
    		$holi = new Historial;
			$prom = $holi->PromedioDispositivo($idUsuario)->fetch_array();
    }	
    getPromedioSensor(htmlspecialchars($_GET["idUsuario"]));
?>