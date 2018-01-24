<?php

class Installer
{

    public $conn = null;

    public function canConnect(array $post) : bool {
        try{
            $this->conn = new PDO('mysql:host='.$post['db_host'].';', $post['db_user'], $post['db_pass']);
            return true;
        } catch(PDOException $e) {
            return false;
        }
        return false;
    }

    public function createConfig(array $post)
    {
        
        try{
            $dbName = strtolower($_POST['db_name']);
            $dbName = str_replace(' ', '', $dbName);
            $configFile = fopen('./config.php', 'w') or die('Unable to create config file.');
            $configTxt = '<?php';
            $configTxt .= "
                define('_DB_HOST_', '".$_POST['db_host']."');
                define('_DB_NAME_', '".$dbName."');
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
            return true;
        } catch(PDOException $e) {
            return false;
        }
        return false;

    }

    public function createTables()
    {
        try {
            $dbName = strtolower($_POST['db_name']);
            $dbName = str_replace(' ', '', $dbName);
            $this->conn->query("CREATE DATABASE IF NOT EXISTS `".$dbName."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
            $this->conn = new PDO('mysql:host='.$_POST['db_host'].';dbname='.$dbName.'', $_POST['db_user'], $_POST['db_pass']);
            //Creates Tables
            $this->conn->query("CREATE TABLE IF NOT EXISTS `pages` (
                                    `page_id` int(11) NOT NULL AUTO_INCREMENT,
                                    `page_title` varchar(45) DEFAULT NULL,
                                    `page_link` varchar(45) DEFAULT NULL,
                                    `fk_pageSettings` int(11) DEFAULT NULL,
                                    PRIMARY KEY (`page_id`),
                                    KEY `page_fk_pageSettings_idx` (`fk_pageSettings`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

            $this->conn->query("CREATE TABLE IF NOT EXISTS `pagesettings` (
                                    `pagesettings_id` int(11) NOT NULL AUTO_INCREMENT,
                                    `pagesettings_filename` varchar(126) DEFAULT NULL,
                                    PRIMARY KEY (`pagesettings_id`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

            $this->conn->query("ALTER TABLE `pages` ADD CONSTRAINT `page_fk_pageSettings_idx` FOREIGN KEY (`fk_pageSettings`) REFERENCES `pagesettings` (`pagesettings_id`) ON DELETE NO ACTION ON UPDATE NO ACTION; COMMIT;");



            //Inserts Page Craeter
            $this->conn->query("INSERT INTO `pagesettings` ( `pagesettings_filename`) VALUES ('newpage')");
            $firstPage = $this->conn->lastInsertId();
            $prepared = $this->conn->prepare("INSERT INTO `pages` (`page_title`, `page_link`, `fk_pageSettings`) 
              VALUES ('New Page', 'newpage', :lastId)");

            $prepared->execute([':lastId' => $firstPage]);
              return true;
        } catch(PDOException $e) {
            return false;
        }
        return false;
    }
}