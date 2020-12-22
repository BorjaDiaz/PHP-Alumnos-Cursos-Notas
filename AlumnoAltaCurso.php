<?php
require_once 'Alumno.php';
$_LOCALPOST = filter_input_array(INPUT_POST);
$cod_alu="";
$dni="";
$nom="";
$ape="";
session_start();
$alumno=new alumno();

if(isset($_LOCALPOST['buscar']))
{
    $_SESSION["alu"]=$_LOCALPOST["ddlAlumno"];
    $result=$alumno->buscar($_SESSION["alu"]);
    $alumnos=$alumno->lee($result);
    $cod_alu= $alumnos[0]["COD_ALU"];
    $dni= $alumnos[0]["DNI"];
    $ape= $alumnos[0]["APELLIDOS"];
    $nom= $alumnos[0]["NOMBRE"];   
}

if(isset($_LOCALPOST['alta']))
{
    $_SESSION["alumno"]=$_LOCALPOST["ddlAlumno"];
    $_SESSION["cur"]=$_LOCALPOST["ddlCursos"];
    $cod_alu=$_LOCALPOST["alu"];
    $alumnos=$alumno->nuevoNotas($_SESSION["cur"], $cod_alu);
    header('Location: Alumnopag.php');
       
}
else
{
    $_SESSION["cur"]="";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link href="CssAlumnos.css" type="text/css" rel="stylesheet"/>
    </head>
<body>
    <form action="AlumnoAltaCurso.php" method="post">
        
         <select name="ddlAlumno">
            <?php
            $_SESSION["valor"]=0;
            $result=$alumno->consulta();
            $alumnos=$alumno->lee($result);
            $num=count($alumnos);
            
            for($x=0;$x<$num;$x++)
            {
                if($alumnos[$_SESSION["valor"]]["COD_ALU"]==$_SESSION["alumno"])
                {
                    echo '<option selected value="'.$alumnos[$_SESSION["valor"]]["COD_ALU"].'" >'.$alumnos[$_SESSION["valor"]]["COD_ALU"].'</option>';
                    $_SESSION["valor"]++;
                }
                else
                {
                    echo '<option value="'.$alumnos[$_SESSION["valor"]]["COD_ALU"].'" >'.$alumnos[$_SESSION["valor"]]["COD_ALU"].'</option>';
                    $_SESSION["valor"]++;
                }
            }
            $_SESSION["valor"]=0;
        ?>
        </select>
        <input type="submit" id="buscar" name="buscar" value="BUSCAR">
        <br>
        <br>
        <div>
            C&Oacute;DIGO DEL ALUMNO:&nbsp;<input type="text" readonly id="alu" name="alu" value="<?php echo $cod_alu;?>"> 
        </div>
        <div>
            DNI:&nbsp;  <input type="text" readonly="" id="dni" name="dni" value="<?php echo $dni;  ?>" >  
        </div>
        <div>
            APELLIDOS:&nbsp;  <input type="text" readonly id="ape" name="ape" value="<?php echo $ape;  ?>" > 
        </div>
        <div>
            NOMBRE:&nbsp;  <input type="text" readonly id="nom" name="nom" value="<?php echo $nom;  ?>" >  
        </div>
        <div>
        <select name="ddlCursos">
        <?php
        $_SESSION["valor"]=0;
        $consulta=$alumno->consultaCursos();
        $cursos=$alumno->lee($consulta);
        $num2=count($cursos);
        for($i=0;$i<$num2;$i++)
        {
            echo '<option value="'.$cursos[$_SESSION["valor"]]["COD_CUR"].'" >'.$cursos[$_SESSION["valor"]]["DESCRIPCION"].'</option>';
            $_SESSION["valor"]++;
        }
        $_SESSION["valor"]=0;
        $alumno->cierra();
        ?>
        </select>
        </div>
        <div>
           <input type="submit" name="alta" id="alta" value="ACEPTAR">
        </div>
        <br>
        <br>
        <a href="./Alumnopag.php">Atras</a>
   </form>
</body>
</html>

