<script src="jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="script.js" type="text/javascript"></script>

<?php
// // Get the required codes from the configuration file
$server = "127.0.0.1";
$username   = "andrewl";
$password   = "password";
$database	="user_db";


$con = new mysqli($server,$username,$password,$database);
if (!$con){
die('Could not connect: ' . mysqli_connect_error($con));
}


// // mysqli_select_db($con,$database);

// $tbl = "CREATE TABLE user_tbl 
// (
// PID INT NOT NULL AUTO_INCREMENT, 
// PRIMARY KEY(PID),
// FirstName VARCHAR(150),
// LastName VARCHAR(150),
// email VARCHAR(150),
// upassword VARCHAR(150),
// phone_number VARCHAR(15),
// address VARCHAR(255),
// twitter VARCHAR(150),
// facebook VARCHAR(150),
// googleplus VARCHAR(150),
// date VARCHAR(150)
// )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// // if (mysqli_query($con,$tbl)) {
//   // echo "Table persons created successfully";
// // } else {
//   // echo "Error creating table: " . mysqli_error($con);
// // }


// ?>