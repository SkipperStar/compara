  <?php 

$cantidadTarjetas = $_POST["cantidadTarjetas"];

 if(empty($_POST["Email"])){
$Email = "No Escribio Correo";
}else{
  $Email = $_POST["Email"];
}


$con=mysqli_connect("localhost","comparae_user","5#Ap,JQoq&H1","comparae_ce");

//$con=mysqli_connect("localhost","root","root","Bancos");
  //_V7esZRN_luC

if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{

  $seccion = utf8_decode("Tarjetas De Crédito");
  $sql_e = "INSERT INTO CorreosUsuarios (Correo,Seccion) values ('".$Email."','".$seccion."')";

    $result_e = $con->query($sql_e);

   $sql = "SELECT * FROM TarjetasDeCredito WHERE SalarioMinimo <= $cantidadTarjetas ORDER BY TasaDeInteres DESC ";

   $result = $con->query($sql);

}

 ?>

  
<div class="bs-example" data-example-id="simple-table">
   <table class="table tableRows">
      <caption>Opciones Tarjetas</caption>
      <thead>
         <tr>
            <th>Tarjeta</th>
            <th>Tasa De Interes</th>
            <th>Salario Minimo</th>
            <th>Beneficios</th>
         </tr>
         </thead>
         <tbody>
               <?php 
               if ($result->num_rows > 0) {// output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><a target='_blank' href='".$row["LinkBanco"]."'>".$row["Tarjeta"]."</a></td>";
                    echo "<td>".($row["TasaDeInteres"]*100).'%'."</td>";
                    echo "<td>".number_format($row["SalarioMinimo"])."</td>";
                    echo "<td>".utf8_encode($row["Beneficios"])."</td>";
                    echo "</tr>";
                 }
               }
               $con->close();
               ?>
            </tbody>
   </table>
</div>