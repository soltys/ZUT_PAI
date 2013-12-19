<?php

require_once 'Todo.php';

define('TABLE_PREFIX', "pai4_");
define('TODO_TABLE', TABLE_PREFIX . 'todo');



class Database {

    private $mysqli;
    

    function __construct() {        
        $this->mysqli = mysqli_connect("localhost", "root", "kupa", "todos");
		
        if (mysqli_connect_errno($this->mysqli)) {
            echo("Failed to connect to MySQL: " . mysqli_connect_error());
        }
		
        $this->createTables();
    }

    private function createTables() {
        $query = "CREATE TABLE IF NOT EXISTS `" . TODO_TABLE . "` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(256) NOT NULL,
                `isDone` int(11) NOT NULL,                
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	 $result = mysqli_query($this->mysqli, $query);
     if (!$result) {
            echo("Query failed select all people from database");
            printf("Error: %s\n" , mysqli_error($this->mysqli));
            return array();
        }
    }
	
	private function createTodo($row) {
        $userId = $row["id"];
        $name = $row["title"];
        $completed = $row["isDone"];      

        $user = new Todo();
		$user->id = $userId;
		$user->title = $name;
		$user->isDone = $completed;
		
        return $user;
    }
	
	public function getTodos(){		
        $result = mysqli_query($this->mysqli, "SELECT * FROM " . TODO_TABLE);
        if (!$result) {
            echo("Query failed select all people from database");
            echo("Error: %s\n" . mysqli_error($this->mysqli));
            return array();
        }
        $peopleList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $person = $this->createTodo($row);
            array_push($peopleList, $person);
        }
        mysqli_free_result($result);
        return $peopleList;    		
	}
	
	public function getTodo($id){
	$result = mysqli_query($this->mysqli, "SELECT * FROM " . TODO_TABLE. " WHERE id=$id");
        if (!$result) {
            echo("Query failed select all people from database");
            echo("Error: %s\n" . mysqli_error($this->mysqli));
            return array();
        }
        $peopleList = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $person = $this->createTodo($row);
            array_push($peopleList, $person);
        }
        mysqli_free_result($result);
        return $peopleList;
	}
	
	 public function addTodo($title, $isDone) {        
        $result = mysqli_query($this->mysqli, "INSERT INTO " . TODO_TABLE . " (title, isDone)
VALUES ('$title', '$isDone')");
        if (!$result) {
            printf("Query failed to add person to database");
            printf("Error: %s\n", mysqli_error($this->mysqli));
        }
    }
	
	public function updateTodo($id, $title, $isDone) {
        $query = "UPDATE " . TODO_TABLE . " SET title='$title',
                                        isDone='$isDone'                                        
                                        WHERE id=$id";

        $result = mysqli_query($this->mysqli, $query);
        if (!$result) {            
            printf("Error: %s\n", mysqli_error($this->mysqli));
        }
    }
	
   public function deleteTodo($id) {
        $result = mysqli_query($this->mysqli, "DELETE FROM " . TODO_TABLE . " WHERE `id`=$id");

        if (!$result) {
            printf("Query failed delete person from database, where id is $id");
            printf("Error: %s\n", mysqli_error($this->mysqli));
        }
    }


    public function __destruct() {
        mysqli_close($this->mysqli);
    }

}

?>
