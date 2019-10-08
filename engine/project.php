<?php


class project {
    protected $databaseInstance = "";
    
    public function __construct() {
        $this->databaseInstance = new db();
    }
    
    public function getAllProjects(){
        $query = "select * from projects";
        
        return $this->databaseInstance->getRows($query);
    }
}
