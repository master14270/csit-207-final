<?php

// This function prevents errors later
function clearStoredResults(){
    global $conn;

    do {
         if ($res = $conn->store_result()) {
           $res->free();
         }
        } while ($conn->more_results() && $conn->next_result());        

}

$servername = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'my_user_db';


// --------------- MAKING DB BELOW ---------------


// Create connection
$conn = new mysqli($servername, $user, $pass);

// Check connection, die if it failed.
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Create database
$sql = "CREATE DATABASE " . $dbname;
if ($conn->query($sql) === TRUE) echo "Database created successfully <br>";
else echo "Error creating database: " . $conn->error;

//closing this connection
$conn->close();

// --------------- MAKING TABLES BELOW ---------------


// Create new connection for making tables
$conn = new mysqli($servername, $user, $pass, $dbname);

// Setting up commands to make tables
$sql = "
CREATE TABLE user_credentials(
id INT(6) UNSIGNED PRIMARY KEY,
username varchar(30) NOT NULL,
password varchar(30) NOT NULL
);

CREATE TABLE user_school_data(
  id INT(6) UNSIGNED PRIMARY KEY,
  num_classes INT(2) NOT NULL,
  gpa FLOAT(2) NOT NULL,
  major varchar(30) NOT NULL
);

CREATE TABLE user_personal_data(
  id INT(6) UNSIGNED PRIMARY KEY,
  fname varchar(30) NOT NULL,
  lname varchar(30) NOT NULL,
  hobby varchar(30) NOT NULL
);";

// Create our 3 tables with the commands
if ($conn->multi_query($sql) === TRUE) echo "Tables created successfully <br>";
else echo "Error creating table: " . $conn->error;

// freeing up space to run new multi_query
clearStoredResults();


// --------------- FILLING TABLES BELOW ---------------


// Setting up commands to fill tables
$sql = "
INSERT INTO user_credentials (id,username,password)
VALUES (1, 'Ramesh243', 'secret123');

INSERT INTO user_school_data (id,num_classes,gpa,major)
VALUES (1, 5, 3.2, 'Liberal Arts');

INSERT INTO user_personal_data (id,fname,lname,hobby)
VALUES (1, 'Ramesh', 'Ahmedabad', 'gaming');



INSERT INTO user_credentials (id,username,password)
VALUES (2, 'Jack5522', 'supersecret31');

INSERT INTO user_school_data (id,num_classes,gpa,major)
VALUES (2, 3, 1.2, 'Liberal Arts');

INSERT INTO user_personal_data (id,fname,lname,hobby)
VALUES (2, 'Jack', 'Daniels', 'drinking');



INSERT INTO user_credentials (id,username,password)
VALUES (3, 'Stinky411', 'dirtydan12');

INSERT INTO user_school_data (id,num_classes,gpa,major)
VALUES (3, 4, 2.5, 'Culinary Arts');

INSERT INTO user_personal_data (id,fname,lname,hobby)
VALUES (3, 'Stinky', 'Pete', 'coding');



INSERT INTO user_credentials (id,username,password)
VALUES (4, 'smit9141', 'nope!');

INSERT INTO user_school_data (id,num_classes,gpa,major)
VALUES (4, 5, 3.57, 'Computer Science');

INSERT INTO user_personal_data (id,fname,lname,hobby)
VALUES (4, 'Jessie', 'Smith', 'coding');
";

// Filling our 3 tables with the commands
if ($conn->multi_query($sql) === TRUE) echo "Tables filled successfully <br>";
else echo "Error filling table: " . $conn->error;

// Closing connection, we are all done!
$conn->close();

echo "Everything is all set!<br>";

?>