<?php

require 'class_definitions.php';

// If we get a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// First, default all values to null (technically not neccassary, just makes auto-complete easier)
	$myUserID = NULL;
	
	$myUname = NULL;
	$myPword = NULL;
	
	$myClassNum = NULL;
	$myGPA = NULL;
	$myMajor = NULL;
	
	$myFname = NULL;
	$myLname = NULL;
	$myHobby = NULL;
	

	// So for each variable, we check if it is set, otherwise we use a default value.
	if (isset($_POST["id"])) $myUserID = $_POST["id"];
	else $myUserID = 25;
	
	
	if (isset($_POST["uname"])) $myUname = $_POST["uname"];
	else $myUname = 'default1553';
	if (isset($_POST["pword"])) $myPword = $_POST["pword"];
	else $myPword = 'def_pass_4422';
	
	if (isset($_POST["class_num"])) $myClassNum = $_POST["class_num"];
	else $myClassNum = 5;
	if (isset($_POST["gpa"])) $myGPA = $_POST["gpa"];
	else $myGPA = 2.0;
	if (isset($_POST["major"])) $myMajor = $_POST["major"];
	else $myMajor = 'Computer Science';
	
	if (isset($_POST["fname"])) $myFname = $_POST["fname"];
	else $myFname = 'Default';
	if (isset($_POST["lname"])) $myLname = $_POST["lname"];
	else $myLname = 'Daniel';
	if (isset($_POST["hobby"])) $myHobby = $_POST["hobby"];
	else $myHobby = 'Nothing';
	
	
	//Here, we will fill the user class, then connect to the database, then send data that way
	$myUser = new User($myUserID, $myUname, $myPword, $myClassNum, $myGPA, $myMajor, $myFname, $myLname, $myHobby);
	
	//instantiate connection object
	$myConnection = new DBConnection();
	
	//get all info from the db based on the id
	$result = $myConnection->insert_user($myUser);
	
	//closing db connection and user, since we are done with it.
	unset($myConnection);
	unset($myUser);
	
	//if inserted successfully, send respone code accordingly
	if ($result === true){echo "Data Added Successfully."; http_response_code(200);} 
	
	//otherwise, tell user request was bad
	else { http_response_code(400); die(); }
}

// If we get a GET request:
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	
	// I set this up such that the user must type enter a query. I'll show the formats below:
	// api.php?id=<user input here>
	// api.php?hobby=<user input here>
	$myResponse = "";
	
	
	if (isset($_GET["id"])){
		
		//get the id, in a format easier to notate
		$myID = $_GET["id"];
		
		//instantiate connection object
		$myConnection = new DBConnection();
		
		//get all info from the db based on the id
		$result = $myConnection->get_all_data_by_id($myID);
		
		//closing db connection, since we are done with it.
		unset($myConnection);
		
		//printing result
		echo json_encode($result);
	}

	if (isset($_GET["hobby"])){
		
		//get the id, in a format easier to notate
		$myHobby = $_GET["hobby"];
		
		//instantiate connection object
		$myConnection = new DBConnection();
		
		//get all info from the db based on the id
		$result = $myConnection->get_names_based_on_hobby($myHobby);
		
		//closing db connection, since we are done with it.
		unset($myConnection);
		
		//printing result
		echo json_encode($result);
	}

	if (isset($_GET["major"])){
		
		//get the id, in a format easier to notate
		$myMajor = $_GET["major"];
		
		//instantiate connection object
		$myConnection = new DBConnection();
		
		//get all info from the db based on the id
		$result = $myConnection->get_names_based_on_major($myMajor);
		
		//closing db connection, since we are done with it.
		unset($myConnection);
		
		//printing result
		echo json_encode($result);
	}	
}

// If we somehow end up here
 else { http_response_code(405); die(); }

?>