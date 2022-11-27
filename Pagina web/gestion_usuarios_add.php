<?php

// PROGRAMA DE MENU ADMINISTRADOR
include "conexion.php";
                                                 
session_start();
if ($_SESSION["autenticado"] != "SIx3")
    {
      header('Location: index.php?mensaje=3');
    }
else
    {      
        $mysqli = new mysqli($host, $user, $pw, $db);
  	    $sqlusu = "SELECT * from tipo_usuario where id='1'"; //CONSULTA EL TIPO DE USUARIO CON ID=1, ADMINISTRADOR
        $resultusu = $mysqli->query($sqlusu);
        $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
  	    $desc_tipo_usuario = $rowusu[1];
        if ($_SESSION["tipo_usuario"] != $desc_tipo_usuario)
          header('Location: index.php?mensaje=4');
    }
?>


    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
     <html>
       <head>
          <link rel="stylesheet" href="css/estilos_virtual.css" 			type="text/css">
           <title> Gesti&oacute;n Usuarios Adicionar </title>
        </head>
       <body>
        <table width="100%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
    	   <tr>
           <td valign="top" align=left width=70% bgcolor="#FFFFFF">
              <table width="100%" align=center border=0 bgcolor="#FFFFFF">
            	   <tr>
                  <td valign="top" align=center width=30% bgcolor="#FFFFFF">
                    
             	    </td>
                  <td valign="top" align=center width=60% bgcolor="#FFFFFF">
                     <h1><font color=green>Sistema Monitoreo de Turbidez  </font></h1>
             	    </td>
           	    </tr>
         	    </table>
           </td>
           <td valign="top" align=right  bgcolor="#FFFFFF">
              <font FACE="arial" SIZE=2 color="#000000"> <b><u><?php  echo "Nombre Usuario</u>:   ".$_SESSION["nombre_usuario"];?> </b></font><br>
              <font FACE="arial" SIZE=2 color="#000000"> <b><u><?php  echo "Tipo Usuario</u>:   ".$desc_tipo_usuario;?> </b></font><br>  
              <font FACE="arial" SIZE=2 color="#00FFFF"> <b><u> <a href="cerrar_sesion.php"> Cerrar Sesion </a></u></b></font>  
           </td>
	     </tr>
<?php
include "menu_admin.php";


if ((isset($_POST["enviado"])))
  {
   //echo "grabar cambios modificaci�n";
   $nombre_usuario = $_POST["nombre_usuario"];
   $nombre_usuario = str_replace("�","n",$nombre_usuario);
   $nombre_usuario = str_replace("�","N",$nombre_usuario);
   $num_id = $_POST["num_id"];
   $tipo_usuario = $_POST["tipo_usuario"];
   //$direccion = $_POST["direccion"];
   $fecha_nacimiento = $_POST["fecha_nacimiento"];
   $login = $_POST["login"];
   $activo = $_POST["activo"];
   $password = $_POST["password"];
   $id_tarjeta = $_POST["id_tarjeta"];
   $password_enc = md5($password);
   $mysqli = new mysqli($host, $user, $pw, $db);
   $sqlcon = "SELECT * from usuarios where identificacion='$num_id'";
   $resultcon = $mysqli->query($sqlcon);
   $rowcon = $resultcon->fetch_array(MYSQLI_NUM);
   $numero_filas = $resultcon->num_rows;
  
   if ($numero_filas > 0)
     { 
     
         header('Location: gestion_usuarios.php?mensaje=5');
     }
   else
    {
      $sql = "INSERT INTO usuarios(tipo_usuario, nombre_completo, identificacion, passwd, fecha_nacimiento, login, activo) 
      VALUES ('$tipo_usuario','$nombre_usuario','$num_id','$password_enc','$fecha_nacimiento','$login','$activo')";
      //echo "sql es...".$sql;
      $result1 = $mysqli->query($sql);
      
      if ($result1 == 1) 
        {
          header('Location: gestion_usuarios.php?mensaje=3');
        }
      else
         header('Location: gestion_usuarios.php?mensaje=4');
      
    }
}

else

{

   ?>
	
	   <tr valign="top">
                <td width="50%" height="20%" align="Center" 				
                    bgcolor="#D5F5E3" class="_espacio_celdas" 					
                    style="color: #D5F5E3; 
			             font-weight: bold">
			    <font FACE="arial" SIZE=2 color="#000044"> <b><h1>Gesti&oacute;n Usuarios </h1>  Adici&oacute;n Usuario</b></font>  
          

		       </td>
	          <td width="50%" height="20%" align="right" 				
                    bgcolor="#D5F5E3" class="_espacio_celdas" 					
                    style="color: #D5F5E3; 
			             font-weight: bold">
			    
		       </td>
		     </tr>
   	     <tr>
                  <td colspan=2 width="25%" height="20%" align="left" 				
                    bgcolor="#D5F5E3" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">

                   <form method=POST action="gestion_usuarios_add.php">
                   <table width=50% border=1 align=center>
			    <tr>	
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Nombre Usuario</b></font>  
				</td>	
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="text" name=nombre_usuario value="" required>  
				</td>	
       </tr>
	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>N&uacute;mero Id</b></font>  
				</td> 	
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="number" name=num_id value="" required>  
				</td>	
			     </tr>
		     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Tipo Usuario</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
			    <select name=tipo_usuario required> 
           <?php 	
           $sql6 = "SELECT * from tipo_usuario order by id DESC";
           $result6 = $mysqli->query($sql6);
           while($row6 = $result6->fetch_array(MYSQLI_NUM))
            {
              $tipo_usuario_con = $row6[0];
              $desc_tipo_usuario_con = $row6[1];
           ?>   
              <option value="<?php echo $tipo_usuario_con; ?>"> <?php echo $desc_tipo_usuario_con; ?></option>  
           <?php
            }
           ?>           
          </select>
				</td>	
			     </tr>
	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Usuario</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="text" name=login value="" required>  
				</td>	
	     </tr>

	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Clave</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="password" name=password value="" required>  
				</td>	
	     </tr>

	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Fecha De Nacimiento</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="date" name=fecha_nacimiento value="" required>  
				</td>	
	     </tr>
			 <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Teléfono</b></font>  
				</td>
			     <td bgcolor="#EEEEEE" align=center> 
				  <input type="number" name=telefono value="" required>  
				</td>	
       </tr>
			 
	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Activo (S/N)</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
          <select name=activo required> 
            <option value="1"> S (Activo)</option>  
            <option value="0"> N (Inactivo)</option>  
          </select>
				</td>	
	     </tr>
      </table>
         </br>
         <input type="hidden" value="S" name="enviado">
         <table width=50% align=center border=0>
           <tr>  
             <td width=50%></td>                                                                       
             <td align=center><input style="background-color: #1A9CF7" type=submit color= blue value="Agregar" name="Modificar">
                  </form> 
             </td>  
             <td align=left>
                  <form method=POST action="gestion_usuarios.php">                   
                  <input style="background-color: #EEEEEE" type=submit color= blue value="Cancelar" name="Volver">              
                  </form> 
             </td>  
           </tr>
                   </table>
                  </form> 
<br><br><hr>
                  </td>
                </tr>  

<?php
 }
?>

        </table>
        
       </body>
      </html>
