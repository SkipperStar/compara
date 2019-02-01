  <?php 

  $cantidadPrestamos = $_POST["cantidadPrestamos"];

  $plazo = $_POST["plazo"];


$moneda = $_POST["moneda"];


  if(empty($_POST["Email"])){
    $Email = "No Escribio Correo";
  }else{
    $Email = $_POST["Email"];
  }

/*echo $cantidadPrestamos;

echo "<br>";

echo $plazo;*/

$con=mysqli_connect("localhost","comparae_user","5#Ap,JQoq&H1","comparae_ce");

//$con=mysqli_connect("localhost","root","root","Bancos");
  //_V7esZRN_luC

if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{

  $seccion = utf8_decode("Préstamos Personales");
  $sql_e = "INSERT INTO CorreosUsuarios (Correo,Seccion) values ('".$Email."','".$seccion."')";

  $result_e = $con->query($sql_e);

  //$sql = "SELECT * FROM PrestamosPersonales WHERE Monto <= 3";
  $sql = "SELECT * FROM PrestamosPersonales WHERE Plazo = '".$plazo."' AND Monto = '".$cantidadPrestamos."' AND Moneda = '".$moneda."' ORDER BY TasaDeInteres DESC";

  //echo($sql);

  $result = $con->query($sql);

}
?>


<div class="bs-example" data-example-id="simple-table">
 <table class="table tableRows">
  <caption>Opciones Préstamos Personales</caption>
  <thead>
   <tr>

    <th>Banco</th>
    <th>Pago Mensual</th>
    <th>Tasa De Interes</th>
    <th>Pago Total</th>
    <th>Comision Por Apertura</th>
  </tr>
</thead>
<tbody>
 <?php 
               if ($result->num_rows > 0) {// output data of each row
                while($row = $result->fetch_assoc()) {
                  echo "<tr><td><a target='_blank' href='".$row["LinkBanco"]."'>".$row["Banco"]."</a></td>";
                  echo "<td>".$row["PagoMensual"]."</td>";
                  echo "<td>".($row["TasaDeInteres"]*100).'%'."</td>";
                  echo "<td>".$row["PagoTotal"]."</td>";
                  echo "<td>".($row["ComisionPorApertura"]*100).'%'."</td></tr>";
                }
              }
              $con->close(); 
              ?>
            </tbody>

          </table>
        </div>