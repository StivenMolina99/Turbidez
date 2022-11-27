<?php

// PROGRAMA DE MENU Operario
include "conexion.php";
                                                 
session_start();
if ($_SESSION["autenticado"] != "SIx3")
    {
      header('Location: index.php?mensaje=3');
    }
else
    {      
        $mysqli = new mysqli($host, $user, $pw, $db);
  	    $sqlusu = "SELECT * from tipo_usuario where id='2'"; //CONSULTA EL TIPO DE USUARIO CON ID=2, Operario
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
           <title> Registrar acciones </title>
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
include "menu_operario.php";


if ((isset($_POST["enviado"])))
  {
    
    //echo "grabar cambios modificaci�n";
    $nombre_de_operario = $_POST["nombre_de_operario"];
    $nombre_de_operario = str_replace("�","n",$nombre_de_operario);
    $nombre_de_operario = str_replace("�","N",$nombre_de_operario);
    $num_id = $_POST["num_id"];
    $fecha_de_gestion = $_POST["fecha_de_gestion"];
    $hora = $_POST["hora"];
    $descripcion = $_POST["descripcion"];
    $mysqli = new mysqli($host, $user, $pw, $db);
    
    $sql = "INSERT INTO Registro_acciones(nombre_op, identificacion, fecha, hora, descripcion) 
    VALUES ('$nombre_de_operario','$num_id','$fecha_de_gestion','$hora','$descripcion')";
    //echo "sql es...".$sql;
    $result1 = $mysqli->query($sql);
    
    if ($result1 == 1) 
      {
        header('Location: datos_turbidez_op.php?mensaje=3');
      }
    else {header('Location: datos_turbidez_op.php?mensaje=4');
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
			              <font FACE="arial" SIZE=2 color="#000044"> <b><h1>Registrar acciones </h1>  Adici&oacute;n acciones</b></font>  
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

                   <form method=POST action="registrar_acciones.php">
                  <table width=50% border=1 align=center>
			              <tr>	
				                <td bgcolor="#A8DDA8" align=center> 
				                    <font FACE="arial" SIZE=2 color="#004400"> <b>Nombre de Operario</b></font>  
				               </td>	
				                <td bgcolor="#EEEEEE" align=center> 
				                       <input type="text" name=nombre_de_operario value="" required>  
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
				                      <font FACE="arial" SIZE=2 color="#004400"> <b>Fecha de Gestion</b></font>  
				                  </td>
				                  <td bgcolor="#EEEEEE" align=center> 
				                      <input type="date" name=fecha_de_gestion value="" required>  
				                 </td>	
	                  </tr>
			               <tr>
				                   <td bgcolor="#A8DDA8" align=center> 
				                       <font FACE="arial" SIZE=2 color="#004400"> <b>Hora</b></font>  
				                   </td>
			                     <td bgcolor="#EEEEEE" align=center> 
				                       <input type="time" name=hora value="" required>  
			                   	</td>	
                      </tr>
			                <tr>
				                   <td bgcolor="#A8DDA8" align=center> 
				                      <font FACE="arial" SIZE=2 color="#004400"> <b>Descripcion</b></font>  
				                  </td>
                          <td bgcolor="#EEEEEE" align=center> 
				                       <input type="text" style="width : 600px; heigth : 1px" name=descripcion value="" required>  
				                 </td>
	                     </tr>
                 </table>
         </br>
            <input type="hidden" value="S" name="enviado">
               <table width=50% align=center border=0>
                 <tr>  
                      <td width=50%></td>                                                                       
                      <td align=center><input style="background-color: #1A9CF7" type=submit color= blue value="Agregar" name="Agregar">
                </form> 
                      </td>  
                       <td align=left>
                <form method=POST action="datos_turbidez_op.php">                   
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
         <script>
       setInterval("location.href='datos_turbidez_op.php'",60000);
        </script>
       </body>
      </html>



  