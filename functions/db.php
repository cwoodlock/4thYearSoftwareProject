<?php 

$conn = mysqli_connect('localhost', 'root', '', 'login_db');


function escape($string){ //This will escape the data

	global $conn;

	return mysqli_real_escape_string($conn, $string);
}

function query($query){ //Function to help with querying

	global $conn;

	return mysqli_query($conn, $query);
}

function confirm($result){ //Function to ensure data is ok

	global $conn;

	if(!$result){
		die("Query Failed" . mysqli_error($conn));
	}

}

function fetch_array($result){ //retrieve the data 

	global $conn;

	return mysqli_fetch_array($result);

}

?>