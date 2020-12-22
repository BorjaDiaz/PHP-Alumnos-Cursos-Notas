<?php
require_once 'BDD.php';

class notas extends BDD
{
    protected $cod_cur;
    protected $cod_alu;
    protected $nota1;
    protected $nota2;
    protected $nota3;
    protected $media;
    
    public function tablacursos()
    {
        $result = $this->_db->query('SELECT * FROM cursos');
        if($result)
        {
          return $result;
        }
    }
    
    public function modificar($cod_cur,$cod_alu,$nota1,$nota2,$nota3,$media)
    {
        
        $not1 = $this->_db->real_escape_string($nota1);
        $not2 = $this->_db->real_escape_string($nota2);
        $not3 = $this->_db->real_escape_string($nota3);
        $med = $this->_db->real_escape_string($media);
        
        $sql="UPDATE notas SET NOTA1=?,NOTA2=?,NOTA3=?,MEDIA=? where cod_alu =? and cod_cur =?";
        $stmt=$this->_db->prepare($sql);
        $stmt->bind_param('iiiiss',$not1,$not2,$not3,$med,$cod_alu,$cod_cur);
        $stmt->execute();
        $stmt->close();
        
	
    }
    
    public function borrar($cod_cur,$cod_alu)
    {
        $sql="DELETE FROM notas where cod_cur=? and cod_alu=?";
        $stmt=$this->_db->prepare($sql);
        $stmt->bind_param('ss',$cod_cur,$cod_alu);
        $stmt->execute();
        $stmt->close();
    }
    
    public function tablacombinada($cod_cur)
    {
        $sql="SELECT * FROM notas JOIN alumnos on alumnos.COD_ALU=notas.COD_ALU where notas.COD_CUR = '$cod_cur'";
        $resultado = $this->_db->query($sql);
        if(!$resultado)
	{
	   echo "Error";
           return(FALSE);
	}
	else
	{
	    return $resultado;
	}
        
    }

    public function lee($result)
    {
       $nota = $result->fetch_all(MYSQLI_BOTH); 
       if($nota)
       {
          return($nota);
       }
    }
    
    public function cierra()
    {
       $this->_db->close();
    }
    
    
    
}
