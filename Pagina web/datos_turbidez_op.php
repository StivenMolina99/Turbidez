
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


    // Recoge los datos para el gráfico de turbidez
    
	$sql = "SELECT unidades as count FROM Datos_turbidez order by id DESC LIMIT 10 ";
	$turb = mysqli_query($mysqli,$sql);
    $turb = mysqli_fetch_all($turb,MYSQLI_ASSOC);
    $turb=array_reverse($turb);
	$turb = json_encode(array_column($turb, 'count'),JSON_NUMERIC_CHECK);
    
    $sql1 = "SELECT *FROM Datos_turbidez order by id DESC LIMIT 10 ";
	$hora = mysqli_query($mysqli,$sql1);
    $hora= mysqli_fetch_all($hora,MYSQLI_NUM);
    
	//$hora = json_encode(array_column($hora, 'count'),JSON_NUMERIC_CHECK);
    

    ?>


    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
     <html>
       <head>
           <title> Operario</title>
           	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
	        <script src="https://code.highcharts.com/highcharts.js"></script>
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
                categories: ['<?php echo $hora[9][3]?>','<?php echo $hora[8][3]?>','<?php echo $hora[7][3]?>','<?php echo $hora[6][3]?>','<?php echo $hora[5][3]?>','<?php echo $hora[4][3]?>','<?php echo $hora[3][3]?>','<?php echo $hora[2][3]?>','<?php echo $hora[1][3]?>','<?php echo $hora[0][3]?>']
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
             	    </td>
                  <td valign="top" align=center width=60%>
                     <h1><font color=green>Sistema Monitoreo de Turbidez </font></h1>
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
    <table width="100%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
    <?php
    include "menu_operario.php";
    ?>
 	    <tr valign="top">
         <td height="20%" align="Center" 				
            bgcolor="#D5F5E3" class="_espacio_celdas" 					
            style="color: #FFFFFF; 
            font-weight: bold">
    		    <font FACE="arial" SIZE=2 color="black"> <b><h1>Datos Turbidez</h1></b></font>  
	       </td>
         <td height="20%" align="right" 				
             bgcolor="#D5F5E3" class="_espacio_celdas" 					
             style="color: #FFFFFF; 
            font-weight: bold">
    			      
		     </td>
	    </tr>
	  </table>
      <table width="100%" align=center cellpadding=5 border=0 bgcolor="#D5F5E3">
      <tr>
       <td align=left width=50%>
        <form action="datos_turbidez_op.php" method="POST">
         
        </td>
       <td align=left width=50%>
         
         </form>
        </td>
      </tr>
    
      <?php
        if (isset($_GET["mensaje"]))
        {
            $mensaje = $_GET["mensaje"];
            if ($_GET["mensaje"]!=""){
     ?>
  		     <tr>
             <td> </td>
             <td height="20%" align="left">
                  <table width=60% border=1>
                   <tr>
                    <?php 
                       if ($mensaje == 3)
                         echo "<td bgcolor=#DDFFDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Accion agregada correctamente.";
                       if ($mensaje == 4)
                         echo "<td bgcolor=#FFDDDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Accion no fue agregada. Se present� un inconveniente";
                      ?>
                    </td>
                   </tr>
                  </table>
              </td>
    		     </tr>
           <?php
            }
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
    </table>
<br><br><hr>
    
 </body>
</html>


   
