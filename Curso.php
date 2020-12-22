<?php
require_once 'BDD.php';

class curso extends BDD
{
    protected $cod_cur;
    protected $descripcion;
    protected $horas;
    protected $tutor;
    
    public function listar($posi, $canti)
    {
      $result = $this->_db->query('SELECT cod_cur,descripcion,horas, tutor FROM cursos limit '.$posi.', '.$canti);
      if($result)
      {
	return $result;
      }
    }
    
    public function consulta()
    {
      $result = $this->_db->query('SELECT * from cursos');
      if($result)
      {
	return $result;
      }
    }
        
    public function lee($result)
    {
       $curso = $result->fetch_row();
       if($curso)
       {
          return($curso);
       }
    }
    
    public function leeLista($result)
    {
       $curso = $result->fetch_all(MYSQLI_BOTH); 
       if($curso)
       {
          return($curso);
       }
    }
    public function ultimo()
    {
        $result=  $this->_db->query('select * from cursos');
        $ultimo = mysqli_num_rows($result);
        if($ultimo)
        {
            return($ultimo-1);
        }    
    }
    
    public function borrar($codigo)
    {
        $sql="DELETE FROM cursos where cod_cur=?";
        $stmt=$this->_db->prepare($sql);
        $stmt->bind_param('s',$codigo);
        $stmt->execute();
        $stmt->close();
    }
    
    public function modificar($codigo,$descripcion,$horas,$tutor)
    {
        $cod = $this->_db->real_escape_string($codigo);
        $descrip = $this->_db->real_escape_string($descripcion);
        $hor = $this->_db->real_escape_string($horas);
        $tut = $this->_db->real_escape_string($tutor);
        
        $sql="UPDATE cursos SET descripcion=?,horas=?,tutor=? where cod_cur = ?";
        $stmt=$this->_db->prepare($sql);
        $stmt->bind_param('siss',$descrip,$hor,$tut,$cod);
        $stmt->execute();
        $stmt->close();
    }
    
    public function nuevo($codigo,$descripcion,$horas,$tutor)
    {
        $cod = $this->_db->real_escape_string($codigo);
        $descrip = $this->_db->real_escape_string($descripcion);
        $hor = $this->_db->real_escape_string($horas);
        $tut = $this->_db->real_escape_string($tutor);
        $sql = "INSERT INTO cursos(cod_cur, descripcion, horas, tutor) VALUES(?,?,?,?) ";
	($stmt=$this->_db->prepare($sql));
        $stmt->bind_param('siss',$cod,$descrip,$hor,$tut);
        $stmt->execute();
        $stmt->close();
        

    }

    public function cierra()
    {
       $this->_db->close();
    }
}


