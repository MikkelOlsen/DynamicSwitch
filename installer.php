<?php
if(!file_exists('./config.php')) {
    $result = '<form method="post">
                    <div class="form-group">
                        <label for="db_name">Database navn</label>
                        <input type="text" class="form-control" id="db_name" aria-describedby="db_name" name="db_name">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Opret</button>
                </form>';
    if(isset($_POST['submit'])) {
        

        $configFile = fopen('./config.php', 'w') or die('Unable to create config file');
        $configTxt = '<?php';
        $configTxt .= "
                define('_DB_HOST_', 'localhost');
                define('_DB_NAME_', '".$_POST["db_name"]."');
                define('_DB_USER_', 'root');
                define('_DB_PASSWORD_', '');
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
                

                \$db = new DB('mysql:host='._DB_HOST_.';dbname='._DB_NAME_.';charset=utf8',_DB_USER_,_DB_PASSWORD_);
        ";

        fwrite($configFile, $configTxt);
        fclose($configFile);

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
                <?= $result ?>
        </div>
    </div>
    
</body>
</html>