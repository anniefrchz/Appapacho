<?php
	require_once ('../Controlador/ABCEntidades.php');
      
    function getPromedioSensor($idDispositivo) {
    		$holi = new Historial;
			$prom = $holi->PromedioDispositivo($idDispositivo);
			print $prom;
    }	
    getPromedioSensor(htmlspecialchars($_GET["idDispositivo"]));
?>