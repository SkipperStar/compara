<?php 

$moneda = $_POST["moneda"];
$cantidad = $_POST["cantidad"];
$plazo = $_POST["plazo"];
  //$email = $_POST["Email"];

$email = "sss";

$TazaDeInteres = 0;

$otrosBancos = 0;

$con=mysqli_connect("localhost","comparae_user","5#Ap,JQoq&H1","comparae_ce");

//$con=mysqli_connect("localhost","root","root","Bancos");
  //_V7esZRN_luC

if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
  $seccion = utf8_decode("Depósitos");

  $sql_e = "INSERT INTO CorreosUsuarios (Correo,Seccion) values ('".$email."','".$seccion."')";

  $result_e = $con->query($sql_e);

  if ($moneda == 'JPY') {
    $sql = "SELECT * FROM Depositos WHERE Moneda = 'JPY'";
  } else {
    $sql = "SELECT * FROM Depositos WHERE Plazo = '".$plazo."' AND Moneda = '".$moneda."' ORDER BY TazaDeInteres DESC";
  }
  

  
  $result = $con->query($sql);

}


if ($moneda == "EUR") {

  if($cantidad >= 6000 && $cantidad <= 69999){

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.03;
      break;
      case '24 M':
      $TazaDeInteres = 4.56;

      break;
      case '36 M':
      $TazaDeInteres = 5.09;

      break;
      case '48 M':
      $TazaDeInteres = 5.62;

      break;
      case '60 M':
      $TazaDeInteres = 6.15;

      break;

      }//swich


    }//if

    else if($cantidad >= 70000  && $cantidad <= 139999 ){

      switch ($plazo) {
        case '12 M':
        $TazaDeInteres = 4.21;

        break;
        case '24 M':
        $TazaDeInteres = 4.74;

        break;
        case '36 M':
        $TazaDeInteres = 5.26;

        break;
        case '48 M':
        $TazaDeInteres = 5.79;

        break;
        case '60 M':
        $TazaDeInteres = 6.32;

        break;

      }//swich


    }//if
    else {

      switch ($plazo) {

        case '12 M':
        $TazaDeInteres = 4.38;

        break;
        case '24 M':
        $TazaDeInteres = 4.91;

        break;
        case '36 M':
        $TazaDeInteres = 5.44;

        break;
        case '48 M':
        $TazaDeInteres = 5.97;

        break;
        case '60 M':
        $TazaDeInteres = 6.50;

        break;

      }//swich


    }

  }//CLOSE EUR

//USD
  else if ($moneda == "USD") {

    if($cantidad >= 7000  && $cantidad <= 79999 ){

      switch ($plazo) {

        case '12 M':
        $TazaDeInteres = 3.96;

        break;
        case '24 M':
        $TazaDeInteres = 4.56;

        break;
        case '36 M':
        $TazaDeInteres = 5.18;


        break;
        case '48 M':
        $TazaDeInteres = 5.73;


        break;
        case '60 M':
        $TazaDeInteres = 6.27;


        break;

    }//swich

    
  }//if

  else if($cantidad >= 80000   && $cantidad <= 159999  ){

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.14;

      break;
      case '24 M':
      $TazaDeInteres = 4.74;


      break;
      case '36 M':
      $TazaDeInteres = 5.36;

      break;
      case '48 M':
      $TazaDeInteres = 5.36;


      break;
      case '60 M':
      $TazaDeInteres = 6.46;

      break;

    }//swich

    
  }//if
  //$cantidad > 159999
  else{

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.31;

      break;
      case '24 M':
      $TazaDeInteres = 4.91;

      break;
      case '36 M':
      $TazaDeInteres = 5.54;

      break;
      case '48 M':
      $TazaDeInteres = 6.09;

      break;
      case '60 M':
      $TazaDeInteres = 6.64;

      break;

    }//swich


  }

}//CLOSE USD

//JPY
  else if ($moneda == "JPY") {

    if($cantidad >= 7000  && $cantidad <= 79999 ){

      switch ($plazo) {

        case '12 M':
        $TazaDeInteres = 3.9;

        break;
        case '24 M':
        $TazaDeInteres = 4.42;

        break;
        case '36 M':
        $TazaDeInteres = 4.93;


        break;
        case '48 M':
        $TazaDeInteres = 5.44;


        break;
        case '60 M':
        $TazaDeInteres = 5.96;


        break;

    }//swich

    
  }//if

  else if($cantidad >= 80000   && $cantidad <= 16999999){

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.07;

      break;
      case '24 M':
      $TazaDeInteres = 4.59;


      break;
      case '36 M':
      $TazaDeInteres = 5.10;

      break;
      case '48 M':
      $TazaDeInteres = 5.61;


      break;
      case '60 M':
      $TazaDeInteres = 6.13;

      break;

    }//swich

    
  }//if
  //$cantidad > 16999999
  else{

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.25;

      break;
      case '24 M':
      $TazaDeInteres = 4.76;

      break;
      case '36 M':
      $TazaDeInteres = 5.27;

      break;
      case '48 M':
      $TazaDeInteres = 5.79;

      break;
      case '60 M':
      $TazaDeInteres = 6.3;

      break;

    }//swich


  }

}//CLOSE JPY


//GBP
else if ($moneda == "GBP") {

    if($cantidad >= 5000  && $cantidad <= 59999 ){

      switch ($plazo) {

        case '12 M':
        $TazaDeInteres = 3.94;

        break;
        case '24 M':
        $TazaDeInteres = 4.52;

        break;
        case '36 M':
        $TazaDeInteres = 5.12;


        break;
        case '48 M':
        $TazaDeInteres = 5.65;


        break;
        case '60 M':
        $TazaDeInteres = 6.19;


        break;

    }//swich

    
  }//if

  else if($cantidad >= 60000   && $cantidad <= 109999){

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.12;

      break;
      case '24 M':
      $TazaDeInteres = 4.69;


      break;
      case '36 M':
      $TazaDeInteres = 5.29;

      break;
      case '48 M':
      $TazaDeInteres = 5.83;


      break;
      case '60 M':
      $TazaDeInteres = 6.37;

      break;

    }//swich

    
  }//if
  //$cantidad > 109999
  else{

    switch ($plazo) {

      case '12 M':
      $TazaDeInteres = 4.29;

      break;
      case '24 M':
      $TazaDeInteres = 4.87;

      break;
      case '36 M':
      $TazaDeInteres = 5.47;

      break;
      case '48 M':
      $TazaDeInteres = 6.01;

      break;
      case '60 M':
      $TazaDeInteres = 6.55;

      break;

    }//swich


  }

}//CLOSE GBP

if ($result->num_rows > 0) {// output data of each row
  echo "<div class='bs-example' data-example-id='simple-table'>
  <table class='table tableRows'>
    <caption>Opciones Depositos</caption>
    <thead>
     <tr>
      <th>Producto</th>
      <th>Tasa De Interes</th>
      <th>Plazo</th>
      <th>Monto Minimo</th>
    </tr>
  </thead>
  <tbody>";
    if($moneda == "USD" || $moneda == "EUR" || $moneda == "JPY" || $moneda == "GBP" ){
      echo "<tr>
      <td><a id='vivier' href='https://vivierco.com/contact-us/' target='_blank'>Vivier & Co.</a></td>

      <td>$TazaDeInteres%</td>
      <td>$plazo</td>";
      if($moneda == "USD"){
        echo "<td>7,000</td></tr>";
      }else if($moneda == "EUR"){
        echo "<td>6,000</td></tr>";
      }
      else if($moneda == "JPY"){
        echo "<td>700,000</td></tr>";
      }
      else if($moneda == "GBP"){
        echo "<td>5,000</td></tr>";
      }
    }

    while($row = $result->fetch_assoc()) {
      echo "<tr><td><a target='_blank' href='".$row["LinkBanco"]."'>".$row["Producto"]."</a></td>";
      echo "<td>".($row["TazaDeInteres"]*100).'%'."</td>";
      echo "<td>".$row["Plazo"]."</td>";
      echo "<td>".$row["MontoMinimo"]."</td></tr>";
    }

    echo "</tbody></table></div>";
    $con->close();
  }
  ?>