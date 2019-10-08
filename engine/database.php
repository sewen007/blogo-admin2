<?php

class db {
    /*
      protected $username = "";
      protected $password = "" ;
      protected $host = "";
      protected $dbname = "";
      public $isConnected;
      protected $datab;
     */

    public function __construct() {
        $this->isConnected = true;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        try {
            //$this->datab = new PDO("mysql:host=localhost;dbname=admin;charset=utf8", 'root', '', $options);
            $this -> datab = new PDO("mysql:host=localhost;dbname=i-blog;charset=utf8", 'root', '', $options);
            $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->isConnected = false;
            throw new Exception($e->getMessage());
        }
    }

    public function Disconnect() {
        $this->datab = null;
        $this->isConnected = false;
    }

    public function getRow($query, $params = array()) {
        try {
            $stmt = $this->datab->prepare($query);

            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage() . ". The query is $query");
        }
    }

    public function getRows($query, $params = array()) {
        try {
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function insertRow($query, $params) {
        try {
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateRow($query, $params) {
        return $this->insertRow($query, $params);
    }

    public function deleteRow($query, $params) {
        return $this->insertRow($query, $params);
    }

}

function get_data($query) {
    $connection = mysql_connect("localhost", "root", "");
    mysql_select_db("admin", $connection);

    $result = mysql_query($query);

    if (!$result) {
        $error = mysql_error();
        throw new Exception("Could not get data. $error " . "$query");
        return false;
    }

    return $result;
}

//$database = new db();
//USAGE
/*
 Connecting to DataBase
 $database = new db("root", "", "localhost", "database", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

 Getting row
 $getrow = $database->getRow("SELECT email, username FROM users WHERE username =?", array("yusaf"));

 Getting multiple rows
 $getrows = $database->getRows("SELECT id, username FROM users");

 inserting a row
 $insertrow = $database ->insertRow("INSERT INTO users (username, email) VALUES (?, ?)", array("yusaf", "yusaf@email.com"));

 updating existing row
 $updaterow = $database->updateRow("UPDATE users SET username = ?, email = ? WHERE id = ?", array("yusafk", "yusafk@email.com", "1"));

 delete a row
 $deleterow = $database->deleteRow("DELETE FROM users WHERE id = ?", array("1"));

 disconnecting from database
 $database->Disconnect();

 checking if database is connected
 if($database->isConnected){
 echo "you are connected to the database";
 }else{
 echo "you are not connected to the database";
 }

 */
