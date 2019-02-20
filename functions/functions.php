<?php 

function clean($clean){ //Ensure user input data does not include any wildcards

	return htmlentities($string);

}

function redirect($location){

	return header("Location: {$location}");

}

function set_message($message){ //set messages while in session

	if(!empty($message)){

		$_SESSION['message'] = $Message;

	} else {
		$message = "";
	}
}

function display_message(){ //Display message from session

	if(isset($_SESSION['message'])){

		echo $_SESSION['message'];

		unset($_SESSION['message']);
	}
}

 //Added security when using forms, using this to ensure form input is coming from specific user page
function token_generator(){ 

	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

	return token;
}

?>