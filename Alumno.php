<?php
require_once 'BDD.php';

class alumno extends BDD
{
    protected $cod_alu;
    protected $dni;
    protected $apellidos;
    protected $nombre;
    
    public function consulta()
    {
      $result = $this->_db->query('SELECT * from alumnos');
      if($result)
      {
	return $result;
      }
    }
    //METODO QUE USO PARA OBTENER LOS CURSOS QUE HAY
    public function consultaCursos()
    {
        $result = $this->_db->query('SELECT * from cursos');
        if($result)
        {
          return $result;  
        }
    }
    
    
    public function lee($result)
    {
       $alumno = $result->fetch_all(MYSQLI_BOTH); 
       if($alumno)
       {
          return($alumno);
       }
    }
    //BUSCAR ALUMNO
    public function buscar($codigo)
    {
      $result = $this->_db->query("SELECT * from alumnos where cod_alu='$codigo'");
      if($result)
      {
	return $result;
      }
    }
    //METODO PARA MODIFICAR EL ALUMNO
    public function  modificar($codigo,$dni,$apellido,$nombre)
    {
        $cod= $this->_db->real_escape_string($codigo);
        $dn = $this->_db->real_escape_string($dni);
        $ape = $this->_db->real_escape_string($apellido);
        $nom = $this->_db->real_escape_string($nombre);
        $sql="UPDATE alumnos SET DNI=?,apellidos=?,nombre=? where cod_alu=?";
        $stmt=$this->_db->prepare($sql);
        $stmt->bind_param('ssss',$dn,$ape,$nom,$cod);
        $stmt->execute();
        $stmt->close();
    }
    //METODO PARA BORRAR EL ALUMNO
    public function borrarAlumno($codigo)
    {
        $sql="DELETE FROM alumnos where cod_alu='$codigo'";
        $resultado = $this->_db->query($sql);
        if(!$resultado)
	{
	   echo "* fallo al borrar el alumno";
           return(FALSE);
	}
	else
	{
	    return $resultado;
	}
    }
    //METODO PARA BORRAR LAS NOTAS DEL ALUMNO
    public function borrarNotas($codigo)
    {
        $sql="DELETE FROM notas where cod_alu='$codigo'";
        $resultado = $this->_db->query($sql);
        if(!$resultado)
	{
	   echo "* fallo al borrar las notas del alumno";
           return(FALSE);
	}
	else
	{
	    return $resultado;
	}
        
    }
    
    public function nuevo($codigo,$dni,$apellido,$nombre)
    {
        $cod= $this->_db->real_escape_string($codigo);
        $dn = $this->_db->real_escape_string($dni);
        $ape = $this->_db->real_escape_string($apellido);
        $nom = $this->_db->real_escape_string($nombre);

        $sql = "INSERT INTO alumnos(cod_alu, dni, apellidos, nombre) VALUES(?,?,?,?) ";
	$stmt=$this->_db->prepare($sql);
        $stmt->bind_param('ssss',$cod,$dn,$ape,$nom);
        $stmt->execute();
        $stmt->close();
    }
    
    public function nuevoNotas($cod_cur,$cod_alu)
    {
        $codalu=$this->_db->real_escape_string($cod_alu);
        $codcur=$this->_db->real_escape_string($cod_cur);
        $sql="INSERT INTO notas(cod_cur,cod_alu,nota1,nota2,nota3,media) values(?,?,'0','0','0','0')";
        $stmt=$this->_db->prepare($sql);
        $stmt->bind_param('ss',$codcur,$codalu);
        $stmt->execute();
        $stmt->close();
    }
    
    
    public function cierra()
    {
       $this->_db->close();
    }
}


