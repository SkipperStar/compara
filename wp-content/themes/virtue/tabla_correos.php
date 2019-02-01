<?php
$con=mysqli_connect("localhost","comparae_user","5#Ap,JQoq&H1","comparae_ce");
// Create connection
//$con=mysqli_connect("localhost","root","root","Bancos");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{

    $myArray = array();


    $sql = "SELECT * FROM CorreosUsuarios";

    $result = $con->query($sql);

    if($result->num_rows > 0){

      while($row= $result->fetch_assoc()) {
        $myArray[]=$row;
      }
    }

}

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Tabla-Correos</title>

      <!-- Bootstrap core CSS -->



      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
      <!--<link rel="stylesheet" type="text/css" href="style.css">-->

      <!-- dataTable -->
      <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

      <link href="assets/css/dataTables.tableTools.css" rel="stylesheet">

      
      <!--[if lt IE 9]>
      <script src="../assets/js/ie8-responsive-file-warning.js"></script>
      <![endif]-->
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="nav-md">
      <div class="container body">

      <h1>Tabla De Correos ComparaExpress</h1>

      <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 ">
         <table id="mitabla" class="table table-bordered table-hover dataTable tableRows" role="grid">
            <thead>
               <tr>
                  <th>Correo</th>
                  <th>Sección</th>
                  <th>Fecha Registro</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  foreach ($myArray as $key => $renglon) {
                         echo"<tr style=text-align:center;>";

                         echo "<td>".$renglon['Correo']."</td>";

                         echo "<td>".utf8_encode($renglon['Seccion'])."</td>";

                         echo "<td>".$renglon['FechaRegistro']."</td>";

                         echo"</tr>";
                      }
                     
                  ?>
            </tbody>
         </table>
      </div>
      </div>
      </div>
      <!-- dataTable -->
 <script src="assets/js/jquery.min.js"></script>

  <script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>
<script src="assets/js/dataTables.tableTools.min.js"></script>



      <script>
$(document).ready(function() {

   $('#mitabla').DataTable({
  "order": [[1,"des"]],
   dom: 'T<"clear">lfrtip',
   tableTools: { 
    "sSwfPath": "assets/copy_csv_xls_pdf.swf",
    "aButtons": [
        "xls"
    ]
  },
  responsive: true,
  "scrollX": true
  }); //datatable


    });
   </script>

   </body>
</html>