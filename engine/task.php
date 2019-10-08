<?php


class task {
    protected $databaseInstance = "";
    protected $libraryInstance = "";


    public function __construct() {
        $this->databaseInstance = new db();
        $this->libraryInstance = new library();
    }
    
    public function getDailyGoalByUsername($username){
        $query = "select * from daily_goals where username = ? and day = ?";
        
        return $this->databaseInstance->getRow($query, array($username, date("l jS F")));
    }
    
    public function createTask($creator, $project, $title, $assignee, $priority, $type, $description){
        $today = date("Y-m-d G:i:s");
        
        $query = "insert into tasks set title = ?, project = ?, assignee = ?, creator = ?, priority = ?, type = ?, description = ?, time_created = ?";
        $values = array($title, $project, $assignee, $creator, $priority, $type, $description, $today);
        
        $this->databaseInstance->insertRow($query, $values);
        
        $message = "A task has been assigned to you";
        $channel = "@" . $assignee;
        
        $this->libraryInstance->sendSlackMessage($message, $channel);
        
        return true;
    }

    public function getAllTasks(){
        $query = "select * from tasks";
        
        return $this->databaseInstance->getRows($query);
    }

    public function createDailyGoal($username, $day, $mainGoal, $three30Goal){
        //first check if user has not already set daily goal
        $dailyGoals = $this->getDailyGoalByUsername($username);
        if (!empty($dailyGoals['id'])){
            throw new Exception("You have already set your daily goal for today. Please edit previous.");
        }
        
        $query = "insert into daily_goals set username = ?, day = ?, main_goal = ?, 330_goal = ?";
        $values = array($username, $day, $mainGoal, $three30Goal);
        
        $this->databaseInstance->insertRow($query, $values);
        
        return true;
    }
    
    public function getNotifications($username = null){
        if ($username == null){
            $query = "select * from notifications";
            $values = array();
        } else {
            $query = "select * from notifications where username = ?";
            $values = array($username);
        }
        
        return $this->databaseInstance->getRows($query, $values);
    }
}
