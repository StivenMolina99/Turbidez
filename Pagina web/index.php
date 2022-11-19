<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title> Página de Inicio Sistema Monitoreo de Turbidez
		  </title>
      <meta charset="utf-8">
      <meta http-equiv="refresh" content="15" />
    </head>
    <body    >
    <style>
        body{  
            background-image: url('img/fondo_index.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
        }
        .ensayotbla table {
         width:95%;
          height: 75vh;
          padding: 10px;
          display: flex;
          justify-content: center;
          align-items:center;
          
          }
    </style>
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
             
           </td>
	     </tr>
     </table>
    <div class="ensayotbla">
     
        <table>
           <tr>
             <th colspan="2" > <font color=white> <H2>Ingreso de Usuarios</H2> </font></th>
         </tr>
       
         
            <form method="POST" action="validar.php">
              
  	            <tr>
                  <td width="25%" height="20%" align="center" 				
                    class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
         		      Usuario: 
                  </td>
                  <td width="25%" height="20%" align="center" 				
                     class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
                     <input type=text value="" name="login" required> 
                  </td>
                </tr>  
  	            <tr>
                  <td width="25%" height="20%" align="center" 				
                     class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
                   Password: 
                  </td>
                  <td width="25%" height="20%" align="center" 				
                    class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
                     <input type=password value="" name="passwd" required> 
                  </td>
                </tr>  
  	            <tr>
                  <td width="25%" height="20%" align="center" 				
                     class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
                    &nbsp;&nbsp;
                  </td>
                  <td width="25%" height="20%" align="center" 				
                     class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: 900">
                   <input type=submit value="Ingresar" name="Enviar"> 
                  </td>
                </tr>  
                <?php
                if (isset($_GET["mensaje"]))
                 {
                 $mensaje = $_GET["mensaje"];
                    if ($_GET["mensaje"]!=""){
                ?>
  	            <tr>
                  <td width="25%" height="20%" align="center" 				
                   
                  </td>
                  <td width="25%" height="20%" align="left" 				
                    bgcolor="#FFDDDD" class="_espacio_celdas_p" 					
                    style="color: #FF0000; 
			             font-weight: 900">
                    <?php 
                       if ($mensaje == 1)
                         echo "Datos erroneos";
                       if ($mensaje == 2)
                         echo "Datos erroneos";
                       if ($mensaje == 3)
                         echo "Datos erroneos";
                       if ($mensaje == 4)
                         echo "Datos erroneos";
                    ?>                         
                  </td>
                </tr>  
                <?php 
                   }
                 }
                ?>
                
             </form> 
      
 	   
          
        </table>
  	        

       
    </div>
       
       
     </body>
   </html>