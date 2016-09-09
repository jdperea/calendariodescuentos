<?php

class MySQL
{
  var $link;
  function MySQL()
  {
    if (!($this->link = new mysqli('localhost', 'root', 'root'))) { 
            echo "Error conectando al servidor de base de datos."; 
            exit(); 
        }
        if (!($this->link->select_db('productos'))) { 
            echo "Error seleccionando la base de datos."; 
            exit(); 
        }
        return $this->link; 
    }
      

 function consulta($consulta)
 { 
  $resultado = $this->link->query($consulta);
    if(!$resultado)
  {
      echo 'MySQL Error: ' . $this->link->error;
      exit;
  }
    return $resultado; 
  }
  
    function registro($insert)
    {
  $resultado = $this->link->query($insert);
    if(!$resultado)
  {
      echo '<!--'.$this->link->errno. '|MySQL Error: ' . $this->link->error.'-->';
      //echo mysql_errno(). '|MySQL Error: ' . mysql_error().'<br>Consulta<br>'.$insert;
      //  exit;
  }
    return $resultado; 
  }
  
 function fetch_array($consulta)
 { 
    return $consulta->fetch_array();
 }
 
 function num_rows($consulta)
 { 
   return $consulta->num_rows;
 }
 
 function fetch_row($consulta)
 { 
   return $consulta->fetch_row;
 }
 function fetch_assoc($consulta)
 { 
   return $consulta->fetch_assoc;
 } 
 
}

?>