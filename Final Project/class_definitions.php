<?php
class User {
    // Link between all of the seperate tables.
    public $userID;
    
    // TABLE 1: Login Credentials
    public $username;
    public $password;
    
    // TABLE 2: School Data
    public $num_classes;
    public $gpa;
    public $major;
    
    // TABLE 3: Personal Data
    public $first_name;
    public $last_name;
    public $hobby;
    

    // Constructor
    function __construct($id, $uname, $pwd, $class_num, $gpa, $maj, $fname, $lname, $hobb) {
        $this->userID = $id;

        $this->username = $uname;
        $this->password = $pwd;

        $this->num_classes = $class_num;
        $this->gpa = $gpa;
        $this->major = $maj;

        $this->first_name = $fname;
        $this->last_name = $lname;
        $this->hobby =  $hobb;
    }
    

    // Methods
    function get_school_data() {
      return "Number of classes: " . $this->num_classes . ",    " . "Major: " . $this->major . ",    " . "GPA: " . $this->gpa;
    }
    
    function gpa_to_letter(){
        if ($this->gpa >= 4.0)
            return "A";
        elseif ($this->gpa >= 3.7)
            return "A-";
        
        elseif ($this->gpa >= 3.3)
            return "B+";
        elseif ($this->gpa >= 3.0)
            return "B";
        elseif ($this->gpa >= 2.7)
            return "B-";
        
        elseif ($this->gpa >= 2.3)
            return "C+";
        elseif ($this->gpa >= 2.0)
            return "C";
        elseif ($this->gpa >= 1.7)
            return "C-";
        
        elseif ($this->gpa >= 1.3)
            return "D+";
        elseif ($this->gpa >= 1.0)
            return "D";
        
        else
            return "F";
    }
    
    
    function gpa_to_percentage(){
        if ($this->gpa >= 4.0)
            return "93-100";
        elseif ($this->gpa >= 3.7)
            return "90-92";
        
        elseif ($this->gpa >= 3.3)
            return "87-89";
        elseif ($this->gpa >= 3.0)
            return "83-86";
        elseif ($this->gpa >= 2.7)
            return "80-82";
        
        elseif ($this->gpa >= 2.3)
            return "77-79";
        elseif ($this->gpa >= 2.0)
            return "73-76";
        elseif ($this->gpa >= 1.7)
            return "70-72";
        
        elseif ($this->gpa >= 1.3)
            return "67-69";
        elseif ($this->gpa >= 1.0)
            return "65-66";
        
        else
            return "Below 65";
    }
}


class DBConnection{
	public $conn;
	function __construct($servername = 'localhost', $user = 'root', $pass = '', $dbname = 'my_user_db'){
		$this->conn = new mysqli($servername, $user, $pass, $dbname);
		}
		
	function __destruct(){
		$this->conn->close();
		}
		
	function print_creds_by_id($myID){
		$sql = "SELECT * FROM user_credentials WHERE id=" . $myID;
		$result = $this->conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo "Username: " . $row["username"]. " --- Password: " . $row["password"]. "<br>";
			}
		
		else echo "0 results";
	}
	
	function print_school_data_by_id($myID){
		$sql = "SELECT * FROM user_school_data WHERE id=" . $myID;
		$result = $this->conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo "Number of Classes: " . $row["num_classes"]. " --- GPA: " . $row["gpa"]. " --- Major: " . $row["major"]. "<br>";
			}
		
		else echo "0 results";
	}
	
	function print_personal_data_by_id($myID){
		$sql = "SELECT * FROM user_personal_data WHERE id=" . $myID;
		$result = $this->conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo "Name: " . $row["fname"] . " " . $row["lname"] . " --- Hobby: " . $row["hobby"]. "<br>";
			}
		
		else echo "0 results";
	}
	
	function get_all_data_by_id($myID){
		//this is an array we will return with all information.
		$ret_value = [];
		
		//doing three seperate queries, adding to our return value each time
		$sql = "SELECT * FROM user_credentials WHERE id=" . $myID;
		$result = $this->conn->query($sql) or die($this->conn->error);
		$row = $result->fetch_assoc();
		$ret_value["username"] = $row["username"];
		$ret_value["password"] = $row["password"];
		
		
		$sql = "SELECT * FROM user_school_data WHERE id=" . $myID;
		$result = $this->conn->query($sql) or die($this->conn->error);
		$row = $result->fetch_assoc();
		$ret_value["num_classes"] = $row["num_classes"];
		$ret_value["gpa"] = $row["gpa"];
		$ret_value["major"] = $row["major"];

		
		$sql = "SELECT * FROM user_personal_data WHERE id=" . $myID;
		$result = $this->conn->query($sql) or die($this->conn->error);
		$row = $result->fetch_assoc();
		$ret_value["fname"] = $row["fname"];
		$ret_value["lname"] = $row["lname"];
		$ret_value["hobby"] = $row["hobby"];
	
		return $ret_value;
	}
	
	
	function get_names_based_on_hobby($myHobby){
		$ret_value = [];
		$sql = "SELECT * FROM user_personal_data WHERE hobby='" . $myHobby . "'";
		$result = $this->conn->query($sql) or die($this->conn->error);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($ret_value, $row["fname"] . " " . $row["lname"]);
				}
			}
		
		return $ret_value;
	}
	

	function get_names_based_on_major($myMajor){
		// first query to get ids
		$sql = "SELECT id FROM user_school_data WHERE major='" . $myMajor . "'";
		$result = $this->conn->query($sql) or die($this->conn->error);
		
		if ($result->num_rows > 0) {
			$myIDs = [];
			while($row = $result->fetch_assoc()) {
				array_push($myIDs, $row["id"]);
			}
		
			// So here, we have an array of id's that match the majors we are looking for.
			// With this in mind, we can build another query.
			$sql = "SELECT * FROM user_personal_data WHERE";
			$num_people = count($myIDs);
			for($i = 0; $i < $num_people; $i++){
				$sql .= " id=" . $myIDs[$i];

				// if we are not on the last element, keep adding 'OR' statements.
				if ($i < $num_people - 1){
					$sql .= " OR";
				}
			}

			// now that we have built the correct command, we execute it.
			$result = $this->conn->query($sql) or die($this->conn->error);
			if ($result->num_rows > 0) {
				$ret_value = [];
				while($row = $result->fetch_assoc()) {
					array_push($ret_value, $row["fname"] . " " . $row["lname"]);
				}
			}
		}

		return $ret_value;
	}

	// takes in a user object, inserts every item into database
	function insert_user(User $myUser = NULL){
		
		//making sure we arent inserting empty data into database
		if (isset($myUser)){
			$sql = "
			INSERT INTO user_credentials (id,username,password)
			VALUES (" . $myUser->userID . ", '" . $myUser->username . "', '" . $myUser->password . "');

			INSERT INTO user_school_data (id,num_classes,gpa,major)
			VALUES (" . $myUser->userID . ", " . $myUser->num_classes . ", " . $myUser->gpa . ", '" . $myUser->major . "');

			INSERT INTO user_personal_data (id,fname,lname,hobby)
			VALUES (" . $myUser->userID . ", '" . $myUser->first_name . "', '" . $myUser->last_name . "', '" . $myUser->hobby . "');";
			
			// running query
			if ($this->conn->multi_query($sql) === TRUE) return true;
			else{ 
				echo "Error filling table: " . $this->conn->error;
				return false;
				}
		}
		else return false;
	}
}


// testing classes below
/*
$ex = new User(12, "jtester", "secret1244", 5, 3.69, "Computer Science", "Johnny", "Test", "Gaming");
//$res = $ex->gpa_to_letter();


$db = new DBConnection();
$db->get_names_based_on_major("Computer Science");
//$db->get_school_data_by_id(1);
//$db->get_personal_data_by_id(1);
//$result = $db->insert_user($ex);

//echo var_dump($result);

echo "<br>All done.";
*/

?>