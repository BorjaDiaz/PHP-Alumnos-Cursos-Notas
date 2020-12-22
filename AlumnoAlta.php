<?php
require_once 'Alumno.php';
$_LOCALPOST = filter_input_array(INPUT_POST);
session_start();
$alumno=new alumno();
$cod_alu="";
$dni="";
$ape="";
$nom="";

if(isset($_LOCALPOST['alta']))
{
    $alu=$_LOCALPOST["alu"];
    $dni=$_LOCALPOST["dni"];
    $ape=$_LOCALPOST["ape"];
    $nom=$_LOCALPOST["nom"];
    $alumnos = $alumno->nuevo($alu, $dni, $ape, $nom);
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
    <form action="AlumnoAlta.php" method="post">
    <div>
        C&Oacute;DIGO DEL ALUMNO:&nbsp;<input type="text" id="alu" name="alu" value="<?php echo $cod_alu;  ?>"> 
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
       <input type="submit" name="alta" id="alta" value="ALTA">
   </div>
        <br>
        <br>
        <a href="./Alumnopag.php">Atras</a>
   </form>
</body>
</html>
