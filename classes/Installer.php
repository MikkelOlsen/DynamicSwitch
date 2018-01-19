<?php

class Installer extends \PDO 
{
    private $db = null;
    
    public function __construct(DB $db) 
    {
        $this->db = $db;
    }

    public function createTables()
    {
        //Creates Tables
            $this->db->query("CREATE TABLE `pages` (
                                `page_id` int(11) NOT NULL,
                                `page_title` varchar(45) DEFAULT NULL,
                                `page_link` varchar(45) DEFAULT NULL,
                                `fk_pageContent` int(11) DEFAULT NULL,
                                `fk_pageSettings` int(11) DEFAULT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
            $this->db->query("CREATE TABLE `pagesettings` (
                                `pagesettings_id` int(11) NOT NULL,
                                `pagesetting_filename` varchar(126) DEFAULT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        //Alters tables
            $this->db->query("ALTER TABLE `pages`
                                ADD PRIMARY KEY (`page_id`),
                                ADD KEY `page_fk_pageContent_idx` (`fk_pageContent`),
                                ADD KEY `page_fk_pageSettings_idx` (`fk_pageSettings`)");
            $this->db->query("ALTER TABLE `pagesettings`
                              ADD PRIMARY KEY (`pagesettings_id`)");
            $this->db->query("ALTER TABLE `pages`
                              MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT");
            $this->db->query("ALTER TABLE `pagesettings`
                              MODIFY `pagesettings_id` int(11) NOT NULL AUTO_INCREMENT");

        //Inserts Page Craeter
            $firstPage = $this->db->lastId("INSERT INTO `pagesettings` ( `pagesetting_filename`) VALUES ('newpage')");
            $this->db->query("INSERT INTO `pages` (`page_title`, `page_link`, `fk_pageContent`, `fk_pageSettings`) 
                              VALUES ('New Page', 'newpage', NULL, :lastId)", [':lastId' => $firstPage]);
    }
}