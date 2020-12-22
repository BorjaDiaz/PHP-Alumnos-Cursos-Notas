<?php
require_once 'Alumno.php';
$_LOCALPOST = filter_input_array(INPUT_POST);
$tb_alu="";
$tb_cu="";
$tb_dn="";
$tb_no="";
$tb_ap="";
session_start();
$alumno=new alumno();
 
if(isset($_LOCALPOST['modi']))
{
    $consulta=$alumno->consulta();
    $alumnos = $alumno->lee($consulta);
    $_SESSION["valor"]=$_LOCALPOST['modi'];
    $_SESSION["alu"]=$alumnos[$_SESSION["valor"]]["COD_ALU"];
    $_SESSION["dni"]=$alumnos[$_SESSION["valor"]]["DNI"];
    $_SESSION["nombre"]=$alumnos[$_SESSION["valor"]]["NOMBRE"];
    $_SESSION["apellido"]=$alumnos[$_SESSION["valor"]]["APELLIDOS"];
    
    header('Location: AlumnoModi.php');
    
}
if(isset($_LOCALPOST['borra']))
{
    $consulta=$alumno->consulta();
    $alumnos = $alumno->lee($consulta);
    $_SESSION["valor"]=$_LOCALPOST['borra'];
    
    $cod_alu=$alumnos[$_SESSION["valor"]]["COD_ALU"];
    $result2=$alumno->borrarNotas($cod_alu);
    $result=$alumno->borrarAlumno($cod_alu);
}

if(isset($_LOCALPOST['alumno']))
{
    header('Location: AlumnoAlta.php');

    
}
if(isset($_LOCALPOST['curso']))
{
    header('Location: AlumnoAltaCurso.php');
}


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link href="CssAlumnos.css" type="text/css" rel="stylesheet"/>
    </head>
<body>
    <form action="Alumnopag.php" method="post">
        <table>
            <tr>
                <th>COD_ALU</th>
                <th>DNI</th>
                <th>APELLIDOS</th>
                <th>NOMBRE</th>
            </tr>
                <?php
                $_SESSION['valor']=0;
                
                $consulta=$alumno->consulta();
                $alumnos = $alumno->lee($consulta);
                $num = count($alumnos);
                for($i=0;$i<$num;$i++)
                {
                   $cod_alu=$alumnos[$_SESSION["valor"]]["COD_ALU"];
                   $DNI=$alumnos[$_SESSION["valor"]]["DNI"];
                   $nombre=$alumnos[$_SESSION["valor"]]["NOMBRE"];
                   $apellidos=$alumnos[$_SESSION["valor"]]["APELLIDOS"];
            
                   echo '<tr>
                   <td >'.$cod_alu.'</td>
                   <td >'.$DNI.'</td>
                   <td >'.$nombre.'</td>
                   <td >'.$apellidos.'</td>
                   <td><button name="modi" id="modi" value="'.$_SESSION['valor'].'">MODIFICAR</button</td>
                   <td><button name="borra" id="borra" value="'.$_SESSION['valor'].'">BORRAR</button></td>
                   </tr>';
                   $_SESSION['valor']++;
                }
                $alumno->cierra();
                ?>     
        </table> 
        <div>
            <INPUT TYPE="submit" name="alumno" id="alumno" value="ALTA ALUMNO">
            <INPUT TYPE="submit" name="curso" id="curso" value="ALTA CURSO">
        </div>
        <br>
        <a href="./index.php">Inicio</a>
    </form>
</body>
</html>

