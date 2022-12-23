<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
                                                 
session_start();
if ($_SESSION["autenticado"] != "SIx3")
    {
      header('Location: index.php?mensaje=3');
    }
else
    {      
        $mysqli = new mysqli($host, $user, $pw, $db);
  	    $sqlusu = "SELECT * from tipo_usuario where id='1'"; //CONSULTA EL TIPO DE USUARIO CON ID=1, TIPO Administrador EL TIPO
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
           <title> Datos de Turbidez por rango de fechas
           <meta http-equiv="refresh" content="15" />
           </title>
        </head>
       <body>
        <table width="100%" align=center cellpadding=5 border=0 bgcolor="#FFFFFF">
    	   <tr>
           <td valign="top" align=left width=70%>
              <table width="100%" align=center border=0>
            	   <tr>
                  <td valign="top" align=center width=30%>
                  <img src="img/logo.jpg" border=0 width=300 height=100>
             	    </td>
                  <td valign="top" align=center width=60%>
                     <h1><font color=#21618C>Sistema Monitoreo de Turbidez </font></h1>
             	    </td>
           	    </tr>
         	    </table>
           </td>
           <td valign="top" align=right>
              <font FACE="arial" SIZE=2 color="#000000"> <b><u><?php  echo "Nombre Usuario</u>:   ".$_SESSION["nombre_usuario"];?> </b></font><br>
              <font FACE="arial" SIZE=2 color="#000000"> <b><u><?php  echo "Tipo Usuario</u>:   ".$desc_tipo_usuario;?> </b></font><br>  
              <font FACE="arial" SIZE=2 color="#00FFFF"> <b><u> <a href="cerrar_sesion.php"> Cerrar Sesion </a></u></b></font>  

           </td>
	     </tr>
     </table>
    <table width="100%" align=center cellpadding=5 border=0 bgcolor="#FFFFFF">
<?php
include "menu_admin.php";
?>   
 	    <tr valign="top">
        <td height="20%" align="center" bgcolor="#D5F5E3" class="_espacio_celdas" style="color: #FFFFFF; font-weight: bold">
			    <font FACE="arial" SIZE=2 color="black"> <b><h1>Consulta datos de Turbidez (por rango de fechas)</h1></b></font>  

		       </td>
	          <td height="20%" align="right" 				
                    bgcolor="#FFFFFF" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">  
		       </td>
		     </tr>
<?php

if ((isset($_POST["enviado"])))
   {
   $enviado = $_POST["enviado"];
   if ($enviado == "S1")
    {
       $fecha_ini = $_POST["fecha_ini"];  // en estas variables se almacenan los datos de fechas recibidos del formulario HTML inicial
       $fecha_fin = $_POST["fecha_fin"];
       $mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.
?>
    </table>
      <table width="80%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
    	 <tr>
         <td valign="top" align=center bgcolor="#E1E1E1" colspan=6>
            <b>Rango de fechas consultado: desde <?php echo $fecha_ini; ?> hasta <?php echo $fecha_fin; ?></b>
         </td>
    	 </tr>
    	 <tr>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Turbidez</b>
         </td>
       </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Fecha</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Hora</b>
         </td>
        
 	     </tr>
<?php


// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.
$sql1 = "SELECT * from medidas_sensor where  Fecha >= '$fecha_ini' and Fecha <= '$fecha_fin' order by fecha DESC"; 
// la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
$result1 = $mysqli->query($sql1);
// la siguiente linea es el inicio de un ciclo while, que se ejecuta siempre que la respuesta a la consulta de la base de datos
// tenga algún registro resultante. Como la consulta arroja X resultados, se ejecutará X veces el siguiente ciclo while.
// el resultado de cada registro de la tabla, se almacena en el arreglo row, row[0] tiene el dato del 1er campo de la tabla, row[1] tiene el dato del 2o campo de la tabla, así sucesivamente
while($row1 = $result1->fetch_array(MYSQLI_NUM))
{
 $turb = $row1[2];
 $fecha = $row1[3];
 $hora = $row1[4];
?>
    	 <tr>
         <td valign="top" align=center>
           <?php echo $turb; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $fecha; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hora; ?> 
         </td>
 	     </tr>
<?php
}  // FIN DEL WHILE
 echo '
      <tr>	
        <form method=POST action="Datos_Turbidez_x_rango_ad.php">
				  <td bgcolor="#D5F5E3" align=center colspan=6> 
				    <input type="submit" value="Volver" name="Volver">  
          </td>	
        </form>	
       </tr>';
 

    } // FIN DEL IF, si ya se han recibido las fechas del formulario
   }  // FIN DEL IF, si la variable enviado existe, que es cuando ya se envío el formulario
  else
    {
?>    
    </table>	 
    <table width="70%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
     <form method=POST action="Datos_Turbidez_x_rango_ad.php">
 	     <tr>	
      		<td bgcolor="#D5F5E3" align=center> 
			   	  <font FACE="arial" SIZE=2 color="black"> <b>Fecha Inicial:</b></font>  
				  </td>	
				  <td bgcolor="#EEEEEE" align=center> 
				    <input type="date" name="fecha_ini" value="" required>  
          </td>	
	     </tr>
 	     <tr>	
      		<td bgcolor="#D5F5E3" align=center> 
			   	  <font FACE="arial" SIZE=2 color="black"> <b>Fecha Final:</b></font>  
				  </td>	
				  <td bgcolor="#EEEEEE" align=center> 
				    <input type="date" name="fecha_fin" value="" required>  
          </td>	
	     </tr>
       <tr>	
				  <td bgcolor="#D5F5E3" align=right colspan=2> 
				    <input type="hidden" name="enviado" value="S1">  
				    <input style="background-color: #1A9CF7" type="submit" color= blue value="Consultar" name="Consultar">  
            </form>
          </td>	
          <td align=left>
                <form method=POST action="datos_turbidez_ad.php">                   
                            <input style="background-color: #EEEEEE" type=submit color= blue value="Cancelar" name="Volver">              
                </form> 
                       </td> 

	     </tr>
        

<?php
    } 
?>    


       </table>
      <hr><br><br> 
     </body>
   </html>