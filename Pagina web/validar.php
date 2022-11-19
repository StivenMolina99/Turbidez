                                                       
<?php

// PROGRAMA DE VALIDACION DE USUARIOS
                   
                                                       
$login = $_POST["login"];
$passwd = $_POST["passwd"];

$passwd_comp = md5($passwd);
session_start();

//echo "login es...".$login;
//echo "password es...".$passwd;

include ("conexion.php");

$mysqli = new mysqli($host, $user, $pw, $db);
       
$sql = "SELECT * from usuarios where login = '$login' and activo='1'";
$result1 = $mysqli->query($sql);
$row1 = $result1->fetch_array(MYSQLI_NUM);
$numero_filas = $result1->num_rows;
if ($numero_filas > 0)
  {
    $passwdc = $row1[6];

    if ($passwdc == $passwd_comp)
      {
        $_SESSION["autenticado"]= "SIx3";
        $tipo_usuario = $row1[7];
        $nombre_usuario = $row1[1];
        $sql2 = "SELECT * from tipo_usuario where id='$tipo_usuario'";
        $result2 = $mysqli->query($sql2);
        $row2 = $result2->fetch_array(MYSQLI_NUM);
        $desc_tipo_usu = $row2[1];
        $_SESSION["tipo_usuario"]= $desc_tipo_usu;
        $_SESSION["nombre_usuario"]= $nombre_usuario;  
        $_SESSION["id_usuario"]= $row1[0];;  
        
        if ($tipo_usuario == 1)
            header("Location: datos_turbidez_ad.php");
         else
            header("Location: datos_turbidez_op.php");
      }
    else 
     {
      header('Location: index.php?mensaje=1');
     }
  }
else
  {
    header('Location: index.php?mensaje=2');
 }  
?>
