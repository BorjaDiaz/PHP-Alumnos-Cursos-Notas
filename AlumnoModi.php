<?php
require_once 'Alumno.php';
$_LOCALPOST = filter_input_array(INPUT_POST);
session_start();
$alumno=new alumno();
$cod_alu=$_SESSION["alu"];
$dni=$_SESSION["dni"];
$nom=$_SESSION["nombre"];
$ape=$_SESSION["apellido"];


if(isset($_LOCALPOST['modificar']))
{
    $cod_alum=$_LOCALPOST["alu"];
    $dnim=$_LOCALPOST["dni"];
    $apem=$_LOCALPOST["ape"];
    $nomm=$_LOCALPOST["nom"];
    $alumno->modificar($cod_alum, $dnim, $apem, $nomm);
    
    header('Location: Alumnopag.php');
}
$alumno->cierra();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link href="CssAlumnos.css" type="text/css" rel="stylesheet"/>
    </head>
<body>
    <form action="AlumnoModi.php" method="post">
    <div>
        C&Oacute;DIGO DEL ALUMNO:&nbsp;<INPUT TYPE="text" readonly id="alu" name="alu" value="<?php echo $cod_alu;  ?>"> 
    </div>
    <div>
        DNI:&nbsp;  <input type="text" id="dni" name="dni" value="<?php echo $dni;  ?>" >  
    </div>
    <div>
         APELLIDOS:&nbsp;  <input type="text" id="ape" name="ape" value="<?php echo $ape;  ?>" > 
    </div>
    <div>
        NOMBRE:&nbsp;  <input type="text" id="nom" name="nom" value="<?php echo $nom;  ?>" >  
    </div>
   <div>
       <input type="submit" name="modificar" id="modificar" value="ACEPTAR">
   </div>
        <br>
        <br>
        <a href="./Alumnopag.php">Atras</a>
   </form>
</body>
</html>
