<?php
	require_once ('../Controlador/ABCEntidades.php');
      
    function setInfoSensor($idDispositivo,$idTipoMedicion,$Valor) {
    		$holi = new Historial;
			$holi->insertHistorial($idDispositivo,$idTipoMedicion,$Valor);
    }	
    setInfoSensor(htmlspecialchars($_GET["idDispositivo"]), htmlspecialchars($_GET["idTipoMedicion"]), htmlspecialchars($_GET["Valor"]));
?>