
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


    // Recoge los datos para el gráfico de turbidez
    
	$sql = "SELECT sensorTurbidez as count FROM medidas_sensor order by id DESC LIMIT 10 ";
	$turb = mysqli_query($mysqli,$sql);
    $turb = mysqli_fetch_all($turb,MYSQLI_ASSOC);
    $turb=array_reverse($turb);
	$turb = json_encode(array_column($turb, 'count'),JSON_NUMERIC_CHECK);
    
    $sql1 = "SELECT *FROM medidas_sensor order by id DESC LIMIT 10 ";
	$turbidez = mysqli_query($mysqli,$sql1);
    $turbidez= mysqli_fetch_all($turbidez,MYSQLI_NUM);

    $sql2 = "SELECT *FROM MaximaTurbidez order by id DESC LIMIT 1 ";
	$max = mysqli_query($mysqli,$sql2);
    $max= mysqli_fetch_all($max,MYSQLI_NUM);

    $maxturb = $max[0][1];
    
	//$hora = json_encode(array_column($hora, 'count'),JSON_NUMERIC_CHECK);
    

    ?>


    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
     <html>
       <head>
           <title> Generar Informes</title>
           	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
	        <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	           
       </head>
       <body> 
       
       

           <script type="text/javascript">

        $(function () { 

            var data_turb = <?php echo $turb; ?>;

            $('#container').highcharts({
                chart: {
                type: 'line'
                },
                title: {
                text: 'Ultimos 10 datos medidos de turbidez '
                },
                xAxis: {
                categories: ['<?php echo $turbidez[9][4]?>','<?php echo $turbidez[8][4]?>','<?php echo $turbidez[7][4]?>','<?php echo $turbidez[6][4]?>','<?php echo $turbidez[5][4]?>','<?php echo $turbidez[4][4]?>','<?php echo $turbidez[3][4]?>','<?php echo $turbidez[2][4]?>','<?php echo $turbidez[1][4]?>','<?php echo $turbidez[0][4]?>']
                },
                yAxis: {
                title: {
                text: 'Turbidez'
                }
                },
            series: [{
            name: 'Turbidez',
            data: data_turb
            }]
            });
           });

        </script>
        
        

        <table width="100%" align=center cellpadding=5 border=0 bgcolor="#FFFFFF">
    	   <tr>
           <td valign="top" align=left width=70%>
              <table width="100%" align=center border=0>
            	   <tr>
                  <td valign="top" align=center width=30%>
                  <img src="img/logo.jpg" border=0 width=300 height=100>
             	    </td>
                     
             	   
                  <td valign="top" align=center width=60%>
                     <h1><font color="#21618C">Sistema Monitoreo de Turbidez </font></h1>
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
    <table width="100%" align=center cellpadding=5 border=0 bgcolor="#AED6F1 ">
    <?php
    include "menu_admin.php";
    ?>
    
 	    <tr valign="top" bgcolor= "#D5F5E3">
         <td height="20%" align="Center" 				
            bgcolor="#D5F5E3" class="_espacio_celdas" 					
            style="color: #D5F5E3; 
            font-weight: bold">
    		    <font FACE="arial" SIZE=2 color="Black"> <b><h1>Registros de Turbidez</h1></b></font>  
	       </td>
	    </tr>

      <?php

if ((isset($_POST["enviado"])))
{
$enviado = $_POST["enviado"];
if ($enviado == "S1")
 {
    $maxturb = $_POST["maxturb"];  // en esta variable se almacena el dato de la maxima turbidez que se tiene para generar la alerta
    $mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

    $sql = "INSERT INTO MaximaTurbidez(maxturb) 
      VALUES ('$maxturb')";
      //echo "sql es...".$sql;
      $result1 = $mysqli->query($sql);

    $maxturb = $maxturb;
?>

 </table>
   <table width="80%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
      <tr>
      <td valign="top" align=center bgcolor="#E1E1E1" colspan=6>
         <b>Turbidez máxima:  <?php echo $maxturb; ?> </b>
      </td>
      </tr>
      </table>

      <?php
         if($turbidez[0][2]>$maxturb){
       ?>
          <script>
              
              swal.fire({
                   
                title: "Alerta \n Turbidez = <?php echo $turbidez[0][2]?> MTU"
               });
               
              
          </script>

        <?php   
          }
        ?>
    
    <table width="100%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
    <tr>
     <td align=left width=50%>

  <div class="container">
     <br>
         <h2 class="text-center">Gr&aacute;fico </h2>
              <div class="row">
              <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
              <div class="panel-heading">Panel</div>
              <div class="panel-body">
              <div id="container"></div>
              </div>
              </div>
              </div>
              </div>
  </div>

    </td>

    </tr>
<?php

echo '
   <tr>	
     <form method=POST action="datos_turbidez_ad.php">
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
  
  <?php
         if($turbidez[0][2]>$maxturb){
       ?>
          <script>
              
              swal.fire({
                   
                title: "Alerta \n Turbidez = <?php echo $turbidez[0][2]?> MTU"
               });
               
              
          </script>

        <?php   
          }
        ?>

 </table>	 
 <table width="70%" align=left cellpadding=5 border=0 bgcolor="#D5F5E3">
  <form method=POST action="datos_turbidez_ad.php">
       <tr>	
           <td bgcolor="#D5F5E3" align=left> 
                  <font FACE="arial" SIZE=2 color="black"> <b>Cambiar máxima turbidez:</b></font>  
               </td>	
               <td bgcolor="#EEEEEE" align=center> 
                 <input type="text" name="maxturb" value="" required>  
       </td>	
     	
               <td bgcolor="#D5F5E3" align=center colspan=2> 
                 <input type="hidden" name="enviado" value="S1">  
                 <input style="background-color: #1A9CF7" type="submit" color= blue value="Actualizar" name="Consultar">  
         </form>
       </td>	

      </tr>
      </table>
    
      <table width="100%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
      <tr>
       <td align=left width=50%>

    <div class="container">
	   <br>
	       <h2 class="text-center">Gr&aacute;fico </h2>
                <div class="row">
                <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                <div class="panel-heading">Panel</div>
                <div class="panel-body">
                <div id="container"></div>
                </div>
                </div>
                </div>
                </div>
    </div>

      </td>

      </tr>

<?php
 } 
?>    

    
</table>
<br><br><hr>
<script>
       setInterval("location.reload()",40000);
        </script>
 </body>
</html>


   
