<!DOCTYPE html>
<?php
          require_once 'Curso.php';
          $cod_cur="";
          $descripcion="";
          $horas="";
          $tutor="";
          $nuevo=0;
          $posi = 0;
          $_LOCALPOST = filter_input_array(INPUT_POST);
          session_start();
          $curso = new curso();
          if(!isset($_LOCALPOST["cod_cur"]))
          {
            
            if($curso == NULL)
            {
                echo "<script>alert('Error en la conexión')</script>";
                return;
            }
            $_SESSION["posi"] = $posi;
            $_SESSION["nuevo"] = $nuevo;
            $result = $curso->listar($posi, 10);
            $fila = $curso->lee($result);
            $cod_cur=$fila[0];
            $descripcion = $fila[1];
            $horas = $fila[2];
            $tutor = $fila[3]; 
            
            //VARIABLES DE SEESION PARA EL BOTON CANCELAR
            $_SESSION["cod_cur"]=$cod_cur;
            $_SESSION["descripcion"]=$descripcion;
            $_SESSION["horas"]=$horas;
            $_SESSION["tutor"]=$tutor;
            
          }
          else
          {
            //BOTON DE SIGUIENTE
            if(isset($_LOCALPOST["siguiente"])) 
            {
              $posi = $_SESSION["posi"]+1;
              $result = $curso->listar($posi, 1);
              $fila = $curso->lee($result);
              
              if($fila == FALSE)
              {
                echo "<script>alert('Fin de tabla')</script>";
                $cod_cur = $_LOCALPOST["cod_cur"];
                $descripcion = $_LOCALPOST["descripcion"];
                $horas = $_LOCALPOST["horas"];
                $tutor = $_LOCALPOST["tutor"]; 
                $posi=$_SESSION["posi"];
              }
              else 
              {
                $cod_cur = $fila[0];
                $descripcion = $fila[1];
                $horas = $fila[2];
                $tutor = $fila[3];            
              }
              $_SESSION["posi"]=$posi;
           }
           //BOTON DE ANTERIOR
           if(isset($_LOCALPOST["anterior"]))
           {
              $posi = $_SESSION["posi"]-1;
              if($posi < 0)
              {
                  $posi=0;
              }
              $result = $curso->listar($posi, 1);
              $fila = $curso->lee($result);
              if($fila == FALSE)
              {
                
                echo "<script>alert('Fin de tabla')</script>";
                $cod_cur = $_LOCALPOST["cod_cur"];
                $descripcion = $_LOCALPOST["descripcion"];
                $horas = $_LOCALPOST["horas"];
                $tutor = $_LOCALPOST["tutor"];
                $posi=$_SESSION["posi"];
                
              }
              else 
              {
                $cod_cur = $fila[0];
                $descripcion = $fila[1];
                $horas = $fila[2];
                $tutor = $fila[3];            
              }
              $_SESSION["posi"]=$posi;
               
           }
           //BOTON PRIMERO
           if(isset($_LOCALPOST["primero"]))
           {
              $posi = 0;
              $result = $curso->listar($posi, 1);
              $fila = $curso->lee($result);
              $cod_cur = $fila[0];
              $descripcion = $fila[1];
              $horas = $fila[2];
              $tutor = $fila[3];
              $_SESSION["posi"]=$posi;
              
           }
           //BOTON ULTIMO
           if(isset($_LOCALPOST["ultimo"]))
           {
              
              $ultimo = $curso->ultimo();
              $result = $curso->listar($ultimo, 1);
              $fila = $curso->lee($result);
              $cod_cur = $fila[0];
              $descripcion = $fila[1];
              $horas = $fila[2];
              $tutor = $fila[3];
              $_SESSION["posi"]=$ultimo;
              
              
           }
           //BOTON CANCELAR
           if(isset($_LOCALPOST["cancelar"]))
           {
               $cod_cur = $_SESSION["cod_cur"];
               $descripcion = $_SESSION["descripcion"];
               $horas = $_SESSION["horas"];
               $tutor = $_SESSION["tutor"];
               $posi=$_SESSION["posi"];
           }
           if(isset($_LOCALPOST["modificar"]))
           {
               $cod_cur = $_LOCALPOST["cod_cur"];
               $descripcion = $_LOCALPOST["descripcion"];
               $horas = $_LOCALPOST["horas"];
               $tutor = $_LOCALPOST["tutor"];
               $result=$curso->modificar($cod_cur,$descripcion,$horas,$tutor);
               
           }
           //BOTON BORRAR
           if(isset($_LOCALPOST["borrar"]))
           {
               $cod_cur = $_LOCALPOST["cod_cur"];
               $result=$curso->borrar($cod_cur);
               
           }
           //BOTON VACIAR
           if(isset($_LOCALPOST["vaciar"]))
           {
               $cod_cur = "";
               $descripcion = "";
               $horas = "";
               $tutor = "";
           }
           //BOTON NUEVO
           if(isset($_LOCALPOST["nuevo"]))
           {
               $cod_cur = $_LOCALPOST["cod_cur"];
               $descripcion = $_LOCALPOST["descripcion"];
               $horas = $_LOCALPOST["horas"];
               $tutor = $_LOCALPOST["tutor"];
               $result=$curso->nuevo($cod_cur, $descripcion, $horas, $tutor);
               
           }
           
        }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cursos</title>
        <link href="CssCursos.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <form name="curso" ACTION="Cursopag.php" METHOD="post">
            <div>
                <label>Cursos</label>
            </div>
                <div>
                    C&Oacute;DIGO DEL CURSO:&nbsp;<INPUT TYPE="text" id="cod_cur" name="cod_cur" value=
                       "<?php echo $cod_cur; ?>" >
                </div>
                <div>
                    DESCRIPCI&Oacute;N:&nbsp;<INPUT TYPE="text" id="descripcion" name="descripcion" value=
                       "<?php echo $descripcion;  ?>" >  
                </div>
                <div>
                    HORAS:&nbsp;<INPUT TYPE="text" id="horas" name="horas" value=
                       "<?php echo $horas;  ?>" >
                </div>
                <div>
                    TUTOR:&nbsp;<INPUT TYPE="text" id="tutor" name="tutor" value=
                       "<?php echo $tutor;  ?>" >  
                </div>
            <div>
                <input type="submit" name="primero" id="primero" value="primero">
                <input type="submit" name="siguiente" id="siguiente" value="siguiente">
                <input type="submit" name="anterior" id="anterior" value="anterior">
                <input type="submit" name="ultimo" id="ultimo" value="ultimo">
            </div>
            <div>
                <input type="submit" name="modificar" value="modificar">
                <input type="submit" name="borrar" value="borrar">
                <input type="submit" name="vaciar" value="vaciar">
                <input type="submit" name="nuevo" value="nuevo" onsubmit="">
                <input type="submit" name="cancelar" value="cancelar">
            </div>
            <div>
                <input type="submit" name="tabla" id="tabla" value="TABLA CURSOS">
            </div>
               <?php
               if(isset($_LOCALPOST["tabla"]))
               {
                   echo '<table>';
                   echo '<tr><td>Curso</td><td>Descripción</td><td>Horas</td><td>Tutor</td></tr>';
                   $_SESSION["valor"]=0;
                   $consulta = $curso->consulta();
                   $cursos=$curso->leeLista($consulta);
                   $num=count($cursos);
                   for($x=0;$x<$num;$x++)
                   {
                       $cod_cur=$cursos[$_SESSION["valor"]]["COD_CUR"];
                       $descripcion=$cursos[$_SESSION["valor"]]["DESCRIPCION"];
                       $horas=$cursos[$_SESSION["valor"]]["HORAS"];
                       $tutor=$cursos[$_SESSION["valor"]]["TUTOR"];

                       echo '<tr>
                       <td >'.$cod_cur.'</td>
                       <td >'.$descripcion.'</td>
                       <td >'.$horas.'</td>
                       <td >'.$tutor.'</td>
                       </tr>';
                       $_SESSION['valor']++;
                   }
                   $_SESSION["valor"]=0;
                   $consulta->close();
                   echo '</table>';
               }
               $curso->cierra();
             ?>  
            <br>
            <br>
            <a href="./index.php">Inicio</a>
        </form>
    </body>
</html>
