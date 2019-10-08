<?php

class calendar {
    //put your code here
    protected $databaseInstance = "";
    
    public function __construct() {
        $this->databaseInstance = new db();
    }
    
    public function getAllEvents(){
        $query = "select * from calendar_events";
        
        return $this->databaseInstance->getRows($query);
    }
    
    public function createEvent($from, $to, $title, $creator, $type, $category, $description){
        $query = "insert into calendar_events set start = ?, end = ?, title = ?, creator = ?, type = ?, category = ?, description = ?";
        $values = array($from, $to, $title, $creator, $type, $category, $description);
        
        $this->databaseInstance->insertRow($query, $values);
        
        return true;
    }
}
