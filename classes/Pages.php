<?php


class Pages extends \PDO 
{
    private $db = null;
    
    public function __construct(DB $db) 
    {
        $this->db = $db;
    }

    /**
     * Gets all links for dynamic menu
     *
     * @return array
     */
    public function getLinksForMenu() : array
    {
        return $this->db->query("SELECT page_title, page_link FROM pages");
    }

    public function dynamicSwitch(string $link)
    {
        return $this->db->single("SELECT pages.page_link, pagesettings.pagesetting_filename
                          FROM pages
                          INNER JOIN pagesettings
                          ON pages.fk_pageSettings = pagesettings.pagesettings_id
                          WHERE pages.page_link = :link", [':link' => $link]);
    }

    /**
     * Creates a directory, if non existing
     *
     * @param string $directory
     * @return boolean
     */
    public function createDirectory(string $directory) : bool
    {
        if(!file_exists($directory)) {
            mkdir($directory);
            return true;
        } else if (file_exists($directory)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates a page 
     * Uses : createDirectory
     * Uses : insertPageIntoDB
     *
     * @param string $pageName
     * @return void
     */
    public function createPage(string $pageName)
    {
        $directory = "partials";
        $ucFirstPageName = ucfirst($pageName);
        $lowerPageName = strtolower($pageName);

        if($this->createDirectory($directory) == true) {
            if(!file_exists('./'.$directory.'/'.$lowerPageName)) {
                $file = fopen('./'.$directory.'/'.$lowerPageName.'.php', "w") or die('Unable to open file!');
                $txt = '<h1>'.$ucFirstPageName.'</h1>';
                fwrite($file, $txt);
                fclose($file);
                if($this->insertPageIntoDB($pageName) == true) {
                    return true;
                } else {
                    $string = '<div class="alert alert-danger">Der skete en fejl ved upload til databasen!</div>';
                    return $string;
                }
            } else if(file_exists('./'.$directory.'/'.$pageName)) {
                $string = '<div class="alert alert-danger">Siden eksistere allerede!</div>';
                return $string;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Insert the page data into DB
     *
     * @param string $pageName
     * @return boolean
     */
    public function insertPageIntoDB(string $pageName) : bool
    {
        try {
            $ucFirstPageName = ucfirst($pageName);
            $lowerPageName = strtolower($pageName);

            $pageSettings = $this->db->lastId("INSERT INTO pagesettings (pagesetting_filename) VALUES (:filename)", [':filename' => $pageName]);
            $this->db->query("INSERT INTO pages (page_title, page_link, fk_pageSettings) VALUES (:title, :link, :settings)", [':title' => $ucFirstPageName, ':link' => $lowerPageName, ':settings' => $pageSettings]);
    
            return true;
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
        
    }
}