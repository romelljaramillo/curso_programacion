<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$arrayMeses = array("Enero","Febrero","Marzo", "Abril","Mayo","Junio", "Julio","Agosto","Septiembre", "Octubre","Noviembre","Diciembre");
var_dump($arrayMeses);


$long=count($arrayMeses);

echo '<br>';
echo '<br>';

$i=0;



function estacion($mes) {

    $invierno = array("diciembre","enero","febrero");
    $primavera = array("marzo", "abril","mayo");
    $verano = array("junio","julio","agosto");
    $otono = array("septiembre","octubre","noviembre");

    if (in_array(strtolower($mes), $invierno )){
        return ($mes) . ' es invierno' . '<br>';
    } elseif (in_array(strtolower($mes), $primavera )){
        return ($mes) . ' es primavera' . '<br>';
    } elseif (in_array(strtolower($mes), $verano )){
        return ($mes) . ' es verano' . '<br>';
    } elseif (in_array(strtolower($mes), $otono )){
        return ($mes) . ' es otoño' . '<br>';
    } else {
        return 'Este mes no existe ' . $mes . '<br>';
    }

}

foreach($arrayMeses as $mes) {

    $estacion = estacion($mes);
    echo utf8_encode($estacion);
}


/*
for ($i=0; $i<count($arrayMeses); $i++){
    switch (strtolower($arrayMeses[$i])){
        case "enero":
        echo $arrayMeses[$i] . ' es invierno' . '<br>';
        break;
        case "febrero":
        echo($arrayMeses[$i] . ' es invierno'. '<br>');
        break;
        case "marzo":
        echo($arrayMeses[$i] . ' es primavera'. '<br>');
        break;
        case "abril":
        echo($arrayMeses[$i] . ' es primavera'. '<br>');
        break;
        case "mayo":
        echo($arrayMeses[$i] . ' es primavera'. '<br>');
        break;
        case "junio":
        echo($arrayMeses[$i] . ' es verano'. '<br>');
        break;
        case "julio":
        echo($arrayMeses[$i] . ' es verano'. '<br>');
        break;
        case "agosto":
        echo($arrayMeses[$i] . ' es verano'. '<br>');
        break;
        case "septiembre":
        echo($arrayMeses[$i] . ' es otoño'. '<br>');
        break;
        case "octubre":
        echo($arrayMeses[$i] . ' es otoño'. '<br>');
        break;
        case "noviembre":
        echo($arrayMeses[$i] . ' es otoño'. '<br>');
        break;
        case "diciembre":
        echo($arrayMeses[$i] . ' es invierno'. '<br>');
        break;
    }
}
*/
//$a= estacion ($arrMeses);
//echo $a;


?>

    
</body>
</html>