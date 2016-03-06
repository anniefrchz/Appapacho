<?php 
		require "DBControl.php";
		
		function insertHistorial($idDispositivo,$idTipoMedicion,$valor){
			$sql = "insert into historial(FechaRegistro,idDispositivo,idTipoMedicion,Valor)values (now(),".$idDispositivo.",".$idTipoMedicion.",".$valor.")";
			$res = mysqli_query(conectar(),$sql);
			return ($res);
		}
		
		class Usuario{
			function iniciar_sesion($usuario,$pass){
				$sql = "select * from usuarios where id = 0 or (usuario = '".$usuario."' and Contrasenia = '".$pass."') or idTipoUsuario = 0;";
				$res = mysqli_query(conectar(),$sql);
				return ($res);
			}
		}
		
		class UsuarioCuidador{
			function insertCuidador($Nombre,$AP,$AM,$Nac,$sexo,$User,$Pass,$tel){
				$sql = "insert into usuarios(idTipoUsuario,Nombre,ApellidoPat,ApellidoMat,FechaNacimiento,sexo,Usuario,Contrasenia,TelefonoParticular)
					values(1,'".$Nombre."','".$AP."','".$AM."','".$Nac."','".$sexo."','".$User."','".$Pass."','".$tel."')
					where not exists (select * from usuarios where Usuario = '".$User."')";
				$res = mysqli_query(conectar(),$sql);
				return ($res);
			}
		
			function obtener_pacientes($idusuario) {
				$sql = "select A.idCuidador, A.idPaciente, concat(B.Nombre,' ',B.ApellidoPat) as NombrePaciente,
					concat(C.Nombre,' ',C.ApellidoPat) as NombreCuidador, D.id as Dispositivo, E.Descripcion,
					ifnull(concat(H.Nombre,' ',H.ApellidoPat),'No asignado') as Medico,
					ifnull(G.Especialidad,'No asignado') as Especialidad
					from paciente as A join usuarios B on A.idPaciente = B.id
					join usuarios as C on A.idCuidador = C.id 
					join dispositivo as D on A.idPaciente = D.idPaciente
					join tiposdispositivos as E on D.idTipoDispositivo = E.id
					left join medico_paciente as F on A.idPaciente = F.idPaciente
					left join medico as G on G.idMedico = F.idMedico
					left join usuarios H on H.id = G.idMedico
					where A.idCuidador = ".$idusuario;
				$res=mysqli_query(conectar(),$sql);
				return($res);
			}
		}
		
		class UsuarioMedico {
			function insertMedico($Nombre,$AP,$AM,$Nac,$sexo,$User,$Pass,$tel,$cedula,$especialidad){
				$sql = "insert into usuarios(idTipoUsuario,Nombre,ApellidoPat,ApellidoMat,FechaNacimiento,sexo,Usuario,Contrasenia,TelefonoParticular)
					values(3,'".$Nombre."','".$AP."','".$AM."','".$Nac."','".$sexo."','".$User."','".$Pass."','".$tel."')
					where not exists (select * from usuarios where Usuario = '".$User."');
					insert into medico(Cedula,Especialidad,idMedico)
					values('".$cedula."','".$especialidad."',(select id from usuarios where idTipoUsuario = 3 and TelefonoParticular = '".$tel."' and 
						ApellidoPat = '".$AP."' and ApellidoMat = '".$AM."' and Nombre = '".$Nombre."'))";
				$res = mysqli_query(conectar(),$sql);
				return ($res);
			}
		}
		
		class UsuarioPaciente{
			function insertPaciente($Nombre,$AP,$AM,$Nac,$sexo,$tel,$Padecimiento,$idCuidador){
				$sql = "insert into usuarios(idTipoUsuario,Nombre,ApellidoPat,ApellidoMat,FechaNacimiento,sexo,Usuario,Contrasenia,TelefonoParticular)
					values(2,'".$Nombre."','".$AP."','".$AM."','".$Nac."','".$sexo."','".$User."','".$Pass."','".$tel."')
					where not exists (select * from usuarios where Usuario = '".$User."');
					insert into medico(DescripcionPadecimientos,idPaciente,idCuidador)
					values('".$Padecimiento."', (select id from usuarios where idTipoUsuario = 2 and TelefonoParticular = '".$tel."' and 
						ApellidoPat = '".$AP."' and ApellidoMat = '".$AM."' and Nombre = '".$Nombre."'), ".$idCuidador.")";
				$res = mysqli_query(conectar(),$sql);
				return ($res);
			}
		}
		
		class Catalogos{
			function obtenerTiposUsuarios(){
				$sql = "select * from tipousuario";
				$res=mysqli_query(conectar(),$sql);
				return($res);
			}
			
			function obtenerTiposDispositivos(){
				$sql = "select * from tiposdispositivos";
				$res=mysqli_query(conectar(),$sql);
				return($res);
			}
		}
		
		class Historial{
			function obtenerHistorial($idDispositivo){
				$sql = "select * from historial where idDispositivo = ".$idDispositivo." order by FechaRegistro desc";
				$res = mysqli_query(conectar(),$sql);
				return ($res);
			}
			function insertHistorial($idDispositivo,$idTipoMedicion,$valor){
				$sql = "insert into historial(FechaRegistro,idDispositivo,idTipoMedicion,Valor)values (now(),".$idDispositivo.",".$idTipoMedicion.",".$valor.")";
				$res = mysqli_query(conectar(),$sql);
				return ($res);
			}
			function PromedioDispositivo($idDispositivo){
				$sql = "SELECT day(FechaRegistro), idDispositivo, sum(Valor) / count(*) as Promedio FROM appche.Historial where idDispositivo =".$idDispositivo." and FechaRegistro between curdate() and date_add(curdate(), interval 1 day) group by day(FechaRegistro), idDispositivo";
				$res = mysqli_query(conectar(),$sql);
				$datarow = $res->fetch_array(); 
				return ($datarow[2]);
			}
		}
	?>