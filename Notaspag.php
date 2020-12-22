<!DOCTYPE html>
<?php
require_once 'Notas.php';
$_LOCALPOST = filter_input_array(INPUT_POST);
session_start();
$nota = new notas();
$tb_al="";
$tb_cu="";
$tb_dn="";
$tb_no="";
$tb_ap="";


//GUARDAR EL COD_CUR PARA PASARLO A LA TABLA
if(isset($_LOCALPOST['ddlcursos']))
{
    $_SESSION["CUR"]=$_LOCALPOST["ddlcursos"];
}
else
{
    $_SESSION["CUR"]="ING";
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cursos</title>
        <link href="CssNotas.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <form name="notas" action="Notaspag.php" method="post">
            
            <select name='ddlcursos' id='ddlcursos' onchange="this.form.submit()" >
            <?php
            $_SESSION["valor"]=0;
            
            $consulta3=$nota->tablacursos();
            $cursos=$nota->lee($consulta3);
            
            $num=count($cursos);
            $i=0;
            
            for($i=0;$i<$num;$i++)
            {
                if($cursos[$_SESSION["valor"]]["COD_CUR"]==$_SESSION["CUR"])
                {
                    echo '<option selected value="'.$cursos[$_SESSION["valor"]]["COD_CUR"].'" >'.$cursos[$_SESSION["valor"]]["DESCRIPCION"].'</option>';
                    
                }
                else
                {
                    echo '<option value="'.$cursos[$_SESSION["valor"]]["COD_CUR"].'" >'.$cursos[$_SESSION["valor"]]["DESCRIPCION"].'</option>';
                }
                $_SESSION["valor"]++;
            }
            $_SESSION["valor"]=0;
            ?>
            </select>
            <br>
            <br>
            <div class="scroll">
            <label>Alumnos de: <?php echo $_SESSION["CUR"]?></label>
            <table>
                <tr>
                    <th>COD_ALU</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>NOTA1</th>
                    <th>NOTA2</th>
                    <th>NOTA3</th>
                    <th>MEDIA</th>
                </tr>
                <?php
                $_SESSION["valor"]=0;
                $consulta = $nota->tablacombinada($_SESSION["CUR"]);
                $notas=$nota->lee($consulta);
                @$num2=count($notas);
                for($x=0;$x<$num2;$x++)
                {
                    $cod_alu=$notas[$_SESSION["valor"]]["COD_ALU"];
                    $NOMBRE=$notas[$_SESSION["valor"]]["NOMBRE"];
                    $APE=$notas[$_SESSION["valor"]]["APELLIDOS"];
                    $NOT1=$notas[$_SESSION["valor"]]["NOTA1"];
                    $NOT3=$notas[$_SESSION["valor"]]["NOTA3"];
                    $NOT2=$notas[$_SESSION["valor"]]["NOTA2"];
                    $MEDI=$notas[$_SESSION["valor"]]["MEDIA"];

                        echo '<tr>
                        <td >'.$cod_alu.'</td>
                        <td >'.$NOMBRE.'</td>
                        <td >'.$APE.'</td>
                        <td >'.$NOT1.'</td>
                        <td >'.$NOT2.'</td>
                        <td >'.$NOT3.'</td>
                        <td >'.$MEDI.'</td>
                        <td><button name="modi" id="modi" value="'.$_SESSION['valor'].'">MODIFICAR</button</td> 
                        <td><button name="borra" id="borra" value="'.$_SESSION['valor'].'">BORRAR</button</td>                          
                        </tr>';
                    $_SESSION["valor"]++;
                }
                $_SESSION['valor']=0;
                ?>
            </table>
            </div>
            <?php
            if(isset($_LOCALPOST["borra"]))
            {
                $_SESSION["valor"]=$_LOCALPOST["borra"];
                $cod_cur=$_SESSION["CUR"];
                $cod_alu=$notas[$_SESSION["valor"]]["COD_ALU"];
                $result=$nota->borrar($cod_cur, $cod_alu);
                header("Location: Notaspag.php");
            }
            if(isset($_LOCALPOST['modi']))
            {
                $_SESSION["valor"]=$_LOCALPOST['modi'];
                $tb_alu=$notas[$_SESSION["valor"]]["COD_ALU"];
                $tb_not1=$notas[$_SESSION["valor"]]["NOTA1"];
                $tb_not2=$notas[$_SESSION["valor"]]["NOTA2"];
                $tb_not3=$notas[$_SESSION["valor"]]["NOTA3"];
                $tb_med=$notas[$_SESSION["valor"]]["MEDIA"];
                $tb_no=$notas[$_SESSION["valor"]]["NOMBRE"];
                $tb_ap=$notas[$_SESSION["valor"]]["APELLIDOS"];
                echo  
                '
                    <form action="notas.php" method="post">
                    <div>
                    COD_ALU:&nbsp;  <input type="text" readonly name="tb_alu" value=
                    "'.$tb_alu.'" > 
                    </div>
                    <div>
                    NOMBRE:&nbsp;  <input type="text" readonly name="tb_nom" value=
                    "'.$tb_no.'" > 
                    </div>
                    <div>
                    APELLIDOS:&nbsp;  <input type="text" readonly name="tb_ape" value=
                    "'.$tb_ap.'" > 
                    </div>
                    <div>
                    NOTA1:&nbsp;  <input type="text" name="tb_not1" value=
                    "'.$tb_not1.'" > 
                    </div>
                    <div>
                    NOTA2:&nbsp;  <input type="text" name="tb_not2" value=
                    "'.$tb_not2.'" >    
                    </div>
                    <div>
                    NOTA3:&nbsp;  <input type="text" name="tb_not3" value=
                     "'.$tb_not3.'" >  
                    </div>
                    <div>
                    MEDIA:&nbsp;  <input type="text" readonly name="tb_med" value=
                    "'.$tb_med.'" > 
                    </div>
                    <div>
                    <input type="submit" name="OK" value="OK">
                    <input type="submit" name="CANCEL" value="CANCEL">
                    </div>
                    </form>
                ';
            }
      
            
            if(isset($_LOCALPOST['OK']))
            {
                $cod_alu = $_LOCALPOST['tb_alu'];
                $cod_cur = $_SESSION["CUR"];
                $nom = $_LOCALPOST['tb_nom'];
                $ape = $_LOCALPOST['tb_ape'];
                $not1 = $_LOCALPOST['tb_not1'];
                $not2 = $_LOCALPOST['tb_not2'];
                $not3 = $_LOCALPOST['tb_not3'];
                $medi =  ($not1)+($not2)+($not3);
                $med=$medi/3;
                $result=$nota->modificar($cod_cur,$cod_alu,$not1,$not2,$not3,$med);
                header("Location: Notaspag.php");
                
            }
           
            $nota->cierra();
            ?>
            </br>
            </br>
            <a href="./index.php">Inicio</a>
        </form>
    </body>
</html>
        


     
    




