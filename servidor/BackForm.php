<?php
require 'phpmailer/PHPMailerAutoload.php';


 $db = mysqli_connect('localhost', 'root', 'root', 'AutoVDB');
	if(mysqli_connect_errno())
	{
		echo 'Failed to connect to MySQL: '.mysqli_connect_error();
	}

function enviaMail($nombre,$telefono,$email,$mensaje){

    
        //Template Admin
        $templateAdministrador = file_get_contents('MailAdminForm.html');
        $templateAdministrador= str_replace('%nombre%', $nombre,$templateAdministrador);
        $templateAdministrador = str_replace('%telefono%', $telefono,$templateAdministrador);
        $templateAdministrador = str_replace('%email%', $email,$templateAdministrador);
        $templateAdministrador = str_replace('%mensaje%', $mensaje,$templateAdministrador);
        $templateAdministrador = str_replace('\r\n','<br>', $templateAdministrador);

       

        //Envia Mail Admin
        $mail2 = new PHPMailer;
        $mail2->isSMTP();
        //$mail2->SMTPDebug = 1;
        $mail2->Host = 'smtp.gmail.com';
        $mail2->SMTPAuth = true;
        $mail2->SMTPSecure = "tls";
        $mail2->Port =  587;
        //$mail2->SMTPSecure = "ssl";
        $mail2->Username = ''; //mail real
        //$mail2->Username = 'erik@concepthaus.mx'; //Mail para pruebas
        $mail2->Password = '';
        $mail2->setFrom('',''); //Real se envía de este
        // $mail2->setFrom('erik@concepthaus.mx','Erik'); //Pruebas se envía de este
        $mail2->addAddress('',''); //mail admin real
        //$mail2->addAddress('erik@concepthaus.mx','Erik'); //aqui llega el mail para el administrador
        $mail2->isHTML(true);
        $mail2->CharSet = 'UTF-8';
        $mail2->Subject = 'Nuevo cliente'; 
        $mail2->Body = $templateAdministrador;
        $mail2->send();


		// 	if(!$mail2->send()) {
		// 	echo 'Message could not be sent.';
		// 	echo 'Mailer Error: ' . $mail2->ErrorInfo;

		// } else{
		// 	echo 'email enviado con exito a admin';
		// }

    
        }





function ValidaMail($email){
if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$email))
{
return true;
}
else{
return false;
}
}


if(isset($_POST['usuario']) && !empty($_POST['usuario']) AND
  isset($_POST['telefono']) && !empty($_POST['telefono']) AND
  isset($_POST['email']) && !empty($_POST['email']) AND
  isset($_POST['mensaje']) && !empty($_POST['mensaje'])) 
{	

$usuario = mysqli_real_escape_string($db,$_POST['usuario']);
$telefono = mysqli_real_escape_string($db,$_POST['telefono']);
$email = mysqli_real_escape_string($db,$_POST['email']);
$mensaje = mysqli_real_escape_string($db,$_POST['mensaje']);
$longnom = strlen ($usuario);

if(ValidaMail($email))
{

if(!is_numeric($usuario))
{
if($longnom > 3)
{


$sql="INSERT INTO FormularioAutoV(`id`, `usuario`,`telefono`,`email`,`mensaje`) VALUES
				  ('','$usuario','$telefono','$email','$mensaje')";
$saveDB = mysqli_query($db, $sql);

if($saveDB){
	enviaMail($usuario,$telefono,$email,$mensaje);

	echo "<div id='DivForm'> <script>document.getElementById('AvanForm').reset(); </script> 


	<script>swal({   title: 'Datos guardados.',
	     text: 'Gracias por contactarnos.',
	     imageUrl: './images/Sw.png',
	     confirmButtonColor:'#a3db63' });
	     </script></div>";
		    }
else
{
echo "<div id='DivForm'>
											<script>sweetAlert({title:'Error',text:'Ocurrio un error en la base de datos.',confirmButtonColor:'#F06060' ,type:'error'}); </script></div>"; 
						echo   mysqli_error($db);

}
}
else
{
	echo "<div id='DivForm'>
											<script>sweetAlert({title:'Error',text:'Tu nombre debe contener como minimo 4 caracteres.',confirmButtonColor:'#F06060' ,type:'error'}); </script></div>"; 


}
}
else
{
echo "<div id='DivForm'>
											<script>sweetAlert({title:'Error',text:'El campo nombre debe ser texto.',confirmButtonColor:'#F06060' ,type:'error'}); </script></div>"; 

}
}
else
{
	echo "<div id='DivForm'>
											<script>sweetAlert({title:'Error',text:'Mail inválido.',confirmButtonColor:'#F06060' ,type:'error'}); </script></div>"; 

}
}
else{
	echo "<div id='DivForm'>
											<script>sweetAlert({title:'Error',text:'Datos incompletos.',confirmButtonColor:'#F06060' ,type:'error'}); </script></div>"; 

}







