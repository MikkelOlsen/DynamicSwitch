<?php

require_once './classes/Installer.php';

$installer = new Installer();


$result = '';

if(file_exists('./config.php')) {
    $result .= '<form method="post">';
    $result .= '<div class="alert alert-warning">Du har allerede en config.php fil. <br> <button type="submit" class="btn btn-primary" name="delete_conf">Slet config.php</button></div>';
    $result .= '</form>';

    if(isset($_POST['delete_conf'])) {
        unlink('./config.php');
        header('Location: installer.php');
    }
} else if(!file_exists('./config.php')) {
    $result = '<form method="post">
                    <div class="form-group">
                        <label for="db_host">Host Navn</label>
                        <input type="text" class="form-control" id="db_host" aria-describedby="db_host" name="db_host" value="localhost">
                    </div>
                    <div class="form-group">
                        <label for="db_name">Database Navn</label>
                        <input type="text" class="form-control" id="db_name" aria-describedby="db_name" name="db_name">
                    </div>
                    <div class="form-group">
                        <label for="db_user">Database Username</label>
                        <input type="text" class="form-control" id="db_user" aria-describedby="db_user" name="db_user" value="root">
                    </div>
                    <div class="form-group">
                        <label for="db_pass">Database Password</label>
                        <input type="text" class="form-control" id="db_pass" aria-describedby="db_pass" name="db_pass">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Opret</button>
                </form>';
    if(isset($_POST['submit'])) {
        if($installer->canConnect($_POST) == true) {
            if($installer->createConfig($_POST) == true) {
                if($installer->createTables($_POST['db_name']) == true) {
                    $result = '<div class="alert alert-success">Dit website er installeret!<br> Klik <a href="index.php">her</a> for at komme dertil!</div>';
                } else {
                    $result = '<div class="alert alert-warning">Der skete en fejl ved oprettelsen databasen og dertilhørende tabeller.<br>Prøv igen.</div>';
                }
            } else {
                $result = '<div class="alert alert-warning">Der skete en fejl ved oprettelsen af config.php filen.<br>Prøv igen.</div>';
            }
        } else {
            $result = '<div class="alert alert-warning">Der skete en fejl ved connection til din host.<br>Kontroller dine oplysninger og prøv igen.</div>';
        }
    }
}

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dynamic</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">     
    <link rel="stylesheet" href="./assets/custom.css">
</head>
<body>
    <div class="container">
        <div class="main-content">
                <?php include_once './version.php';?>
                <?= $result ?>
        </div>
    </div>
    
</body>
</html>