<?php


include('controller/UserController.php');

define("_ROOT_", "http://miweb.com/");

$user = new UserController('Romell', 'Jaramillo', '25', 'Masculino');

echo 'El nombre: ' . $user->nombre . "\n";
echo 'El apellido: ' . $user->apellido . "\n";
echo 'La edad: ' . $user->edad . "\n";
echo 'El sexo: ' . $user->sexo . "\n";

echo "------------------------------------ \n";

$edad = $user->ingresarEdad('40');

echo 'La nueva edad: ' . $edad . "\n";
echo "------------------------------------ \n";

echo 'El nombre: ' . $user->nombre . "\n";
echo 'El apellido: ' . $user->apellido . "\n";
echo 'La edad: ' . $user->edad . "\n";
echo 'El sexo: ' . $user->sexo . "\n";

// $user->createDirBackup('nueva_carpeta3');
define("_ROOT_", "nueva");


echo 'enlace = '._ROOT_;