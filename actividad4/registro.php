<?php
$host = "sql207.epizy.com";
$database = "epiz_33838860_actividad4";
$username = "epiz_33838860";
$password = "5NrupkqMI60m";

// Crea conexion
$conexion = mysqli_connect($host, $username, $password, $database);

// Checkea conexion
if (!$conexion) {
    die("Conexion fallida: " . mysqli_connect_error());
}

$Comando_t = "SELECT * from medicion";
$Comando_g = "SELECT nombre, psi FROM medicion ORDER BY psi DESC";
$Comando_gg = "SELECT nombre, psi, fecha, hora FROM medicion ORDER BY fecha AND hora ASC";
?>

<style>
    <?php include "style.css"?>
</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        <?php $Grafica = mysqli_query($conexion, $Comando_g);?>

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Fecha', 'PSI'],
            <?php
            if($Grafica->num_rows > 0){
                while($row = $Grafica->fetch_assoc()){
                    echo "['".$row['nombre']."', ".$row['psi']."],";
                }
            }
            ?>
            ]);



            var options = {
                title: 'Valvulas (PSI)',
                hAxis: {title: 'Registro de cambio de presion pretrolifero',  titleTextStyle: {color: '#123'}},
                vAxis: {minValue: 0}
            };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        }
    </script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
<script>
   google.load("visualization", "1", {packages:["corechart"]});
   google.setOnLoadCallback(dibujarGrafico);

   <?php $Grafica = mysqli_query($conexion, $Comando_gg);?>

   function dibujarGrafico() {
    
     var data = google.visualization.arrayToDataTable([
       ['Fecha', 'PSI'],
       <?php
            if($Grafica->num_rows > 0){
                while($row = $Grafica->fetch_assoc()){
                    echo "['".$row['fecha']."', ".$row['psi']."],";
                }
            }
        ?>    
     ]);
     var options = {
       title: 'Registro de Presion de valvulas'
     }
     
     new google.visualization.ColumnChart( 
     
       document.getElementById('Grafico')
     ).draw(data, options);
   }
 </script>

    <title>Historical</title>
</head>
<body>
    
    <header><h1><img src="img/patria.png" width="140" height="110" align="left" ><a href="index.php">Anotar</a> | <a href="registro.php">Registro</a><img src="img/bandera.png" width="150" height="100" border="2"></h1></header>

    <table>
        <tr>
            <td class="petro"><b>id</b></td>
            <td class="petro"><b>Nombre</b></td>
            <td class="petro"><b>PSI</b></td>
            <td class="petro"><b>Fecha</b></td>
            <td class="petro"><b>Hora</b></td>
        </tr>

        <?php
        
        $Resultado = mysqli_query($conexion, $Comando_t);

        while($Datos = mysqli_fetch_array($Resultado)) {
        
        ?>

        <tr>
            <td class="darkweat"><?php echo $Datos['id']?></td>
            <td class="darkweat"><?php echo $Datos['nombre']?></td>
            <td class="darkweat"><?php echo $Datos['psi']?></td>
            <td class="darkweat"><?php echo $Datos['fecha']?></td>
            <td class="darkweat"><?php echo $Datos['hora']?></td>
        </tr>

        <?php
        }
        ?>
        
    </table>

    <div class="centrado">
        <div id="Grafico" style="width: 100%; height: 600px"></div>
    </div>

</body>

</html>