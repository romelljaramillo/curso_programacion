<?php
    $root = "http://localhost";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <script src="<?php echo $root ?>/curso_programacion/js/clase_1.js"></script>
    <script src="/curso_programacion/js/clase_1.js"></script>
    <script src="../js/clase_1.js"></script>
    <script>    
        alert("<h1>"+Hola mundo+"</h1>");
    </script>

<body>
    <?php
        echo 'hola mundo ' . $root;
     ?>
</body>
</html>