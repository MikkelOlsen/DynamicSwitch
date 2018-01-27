<?php
    if(file_exists('./config.php')) {
        $result .= '<form method="post">';
        $result .= '<div class="alert alert-warning">Du har allerede en config.php fil. <br> <button type="submit" class="btn btn-primary" name="delete_conf">Slet config.php</button></div>';
        $result .= '</form>';
    
        if(isset($_POST['delete_conf'])) {
            unlink('./config.php');
            header('Location: installer.php');
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">     
    <link rel="stylesheet" href="./assets/css/custom.css">
</head>
<body>
    <div class="container">
        <div class="main-content">
                <?php include_once './version.php';?>
                <pre><?php var_dump(@$_SESSION); ?></pre>
                <?= @$result ?>
                <form method="post" action="installerDB.php">
                    <div class="form-group">
                        <label for="db_host">Host Navn</label>
                        <input type="text" class="form-control" id="db_host" aria-describedby="db_host" name="db_host" value="localhost">
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
                </form>
        </div>
    </div>
    
</body>
</html>