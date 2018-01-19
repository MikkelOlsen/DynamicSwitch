<?php
exec('git log -1',$line);
if(!file_exists('./config.php')) {
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
        
        try {
            $dbh = new PDO('mysql:host='.$_POST['db_host'].';dbname='.$_POST['db_name'].'', $_POST['db_user'], $_POST['db_pass']);
            $configFile = fopen('./config.php', 'w') or die('Unable to create config file.');
            $configTxt = '<?php';
            $configTxt .= "
                define('_DB_HOST_', '".$_POST['db_host']."');
                define('_DB_NAME_', '".$_POST["db_name"]."');
                define('_DB_USER_', '".$_POST["db_user"]."');
                define('_DB_PASSWORD_', '".$_POST["db_pass"]."');
                define('_DB_PREFIX_', '');
                define('_MYSQL_ENGINE_', 'InnoDB');
                
                function ClassLoader(string \$className)
                {
                    \$className = str_replace('\\\', '/', \$className);
                    if(file_exists(__DIR__ .'/classes/'. \$className . '.php')){
                    require_once(__DIR__ .'/classes/'. \$className . '.php');
                    } else {
                    echo 'ERROR: '. __DIR__ .'/classes/'. \$className . '.php';
                    }
                }
                spl_autoload_register('ClassLoader');
                

                \$db = new DB('mysql:host='._DB_HOST_.';dbname='._DB_NAME_.';charset=utf8',_DB_USER_,_DB_PASSWORD_);";

        fwrite($configFile, $configTxt);
        fclose($configFile);

        } catch (PDOException $e) {
            $dbh = new PDO('mysql:host='.$_POST['db_host'].';', $_POST['db_user'], $_POST['db_pass']);
            $dbSql = "CREATE DATABASE IF NOT EXISTS `".$_POST['db_name']."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $stmt = $dbh->prepare($dbSql);
            $stmt->execute();
            $configFile = fopen('./config.php', 'w') or die('Unable to create config file.');
            $configTxt = '<?php';
            $configTxt .= "
                define('_DB_HOST_', '".$_POST['db_host']."');
                define('_DB_NAME_', '".$_POST["db_name"]."');
                define('_DB_USER_', '".$_POST["db_user"]."');
                define('_DB_PASSWORD_', '".$_POST["db_pass"]."');
                define('_DB_PREFIX_', '');
                define('_MYSQL_ENGINE_', 'InnoDB');
                
                function ClassLoader(string \$className)
                {
                    \$className = str_replace('\\\', '/', \$className);
                    if(file_exists(__DIR__ .'/classes/'. \$className . '.php')){
                    require_once(__DIR__ .'/classes/'. \$className . '.php');
                    } else {
                    echo 'ERROR: '. __DIR__ .'/classes/'. \$className . '.php';
                    }
                }
                spl_autoload_register('ClassLoader');
                

                \$db = new DB('mysql:host='._DB_HOST_.';dbname='._DB_NAME_.';charset=utf8',_DB_USER_,_DB_PASSWORD_);";

        fwrite($configFile, $configTxt);
        fclose($configFile);
        }
        
        

        // $installer = new Installer($db);

        // $dbCheck = $installer->createDatabase($_POST['db_name']);

    }
} else {
    $result = '<h1>Du har allerede en config fil.</h1>';
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
            <h1>Website Installer - <?= $line[4] ?></h1>
                <?= $result ?>
        </div>
    </div>
    
</body>
</html>