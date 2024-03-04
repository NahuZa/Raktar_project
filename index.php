<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home page</title>
</head>
<body>
    <h1>Raktár</h1>
<?php
    require_once('raktar.php');
    

$database = new Database();
$database->createDatabase();
$database->createTables();
$database->importRaktarok('raktarok.csv');

?>  

</body>
</html>