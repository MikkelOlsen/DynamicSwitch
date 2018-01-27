<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './classes/Installer.php';

$installer = new Installer();
// $dbs = $installer->getDBs();
// var_dump($dbs);

    if(isset($_POST['submit'])) {
        if($installer->canConnect($_POST) == true) {
            $databases = $installer->getDBs();
            var_dump($databases);
            foreach($databases as $key => $value){
                echo $value['Database'].'<br>';
            }
        } else {
            $result = '<div class="alert alert-warning">Der skete en fejl ved connection til din host.<br>Kontroller dine oplysninger og prøv igen.</div>';
        }
    } else {
        header('Location: installer.php');
    }

    // if($installer->checkDB($_POST['db_name']) == true) {
    //     if($installer->createConfig($_POST) == true) {
    //         if($installer->createTables($_POST['db_name']) == true) {
    //             $result = '<div class="alert alert-success">Dit website er installeret!<br> Klik <a href="index.php">her</a> for at komme dertil!</div>';
    //         } else {
    //             $result = '<div class="alert alert-warning">Der skete en fejl ved oprettelsen databasen og dertilhørende tabeller.<br>Prøv igen.</div>';
    //         }
    //     } else {
    //         $result = '<div class="alert alert-warning">Der skete en fejl ved oprettelsen af config.php filen.<br>Prøv igen.</div>';
    //     }
    // } else {
    //     $result = '<div class="alert alert-warning">Der eksistere allerede en database med dette navn.</div>';
    // }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <title>Dynamic</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">     
    <link rel="stylesheet" href="./assets/css/custom.css">
    </head>
    <body>
    <div class="container">
        <div class="main-content">
        <?php include_once './version.php';?>
        <form method="post">
        <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="currentDB" name="dbcheck" class="custom-control-input">
                        <label class="custom-control-label" for="currentDB">Brug en nuværende databse</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="newDB" name="dbcheck" class="custom-control-input">
                        <label class="custom-control-label" for="newDB">Opret en ny database</label>
                    </div>
                    <div class="form-group" id="db_name_group">
                        <label for="db_name">Database Navn</label>
                        <input type="text" class="form-control" id="db_name" aria-describedby="db_name" name="db_name">
                    </div>
        </form>
        </div>
        </div>

        <script src="./assets/js/installer.js"></script>

    </body>
    </html>