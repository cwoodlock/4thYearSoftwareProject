<?php 

function clean($clean){ //Ensure user input data does not include any wildcards

	return htmlentities($clean);

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

function validation_error($error){

	echo '
			<div class="alert alert-danger" role="alert">
  				'.$error .' 
			</div>
		 ';

}

function email_exists($email){ //checks if email was used before

	$sql = "SELECT id FROM users WHERE email = '$email'";

	$result = query($sql);

	if(row_count($result) == 1){
		return true;
	} else {
		return false;
	}

}

function username_exists($username){ //checks if username was used before

	$sql = "SELECT id FROM users WHERE username = '$username'";

	$result = query($sql);

	if(row_count($result) == 1){
		return true;
	} else {
		return false;
	}

}

function validate_user_registration(){ //Function will validate the user

	$errors = [];

	$min = 3;
	$max = 20;

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$first_name = clean($_POST['first_name']);
		$last_name = clean($_POST['last_name']);
		$username = clean($_POST['username']);
		$email = clean($_POST['email']);
		$password = clean($_POST['password']);
		$confirm_password = clean($_POST['confirm_password']);

		if(strlen($first_name) < 3){
			
			$errors[] = "Your first name cannot be less than {$min} characters";
		}

		if(strlen($last_name) < 3){
			
			$errors[] = "Your last name cannot be less than {$min} characters";
		}

		if(strlen($username) < 3){
			
			$errors[] = "Your username cannot be less than {$min} characters";
		}

		if(strlen($first_name) > 20){
			
			$errors[] = "Your first name cannot be more than {$max} characters";
		}

		if(strlen($last_name) > 20){
			
			$errors[] = "Your last name cannot be more than {$max} characters";
		}

		if(strlen($username) > 20){
			
			$errors[] = "Your username cannot be more than {$max} characters";
		}

		if($password !== $confirm_password) {
			$errors[] = "Your passwords do not match";
		}

		if(email_exists($email)){

			$errors[] = "{$email} is already registered";

		}

		if(username_exists($username)){

			$errors[] = "{$username} is already registered";

		}

		if(!empty($errors)){

			foreach ($errors as $error) {

				//Display validation error
				echo validation_error($error);			
			}
		} else {

			if(register_user($first_name, $last_name, $username, $email, $password)){

				set_message("<p class='bg-success text-centre'> Please check your email or spam folder for activation link.</p>");

				//redirect to home page
				redirect("index.php");
			}
		}

	}
}

function register_user($first_name, $last_name, $username, $email, $password){

	$first_name = escape($first_name);
	$last_name = escape($last_name);
	$username = escape($username);
	$email = escape($email);
	$password = escape($password);

	if(email_exists($email)){
		return false;
	} else if(username_exists($username)){
		return false;
	} else {

		$password = md5($password); //hash password

		//Hash password to create validtion code
		$validation_code = md5($username + microtime());

		$sql = "INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
		$sql.="VALUES('$first_name','$last_name','$username','$email','$password','$validation_code', 0)"; //append query onto previous

		//Confirm the query
		$result = query($sql);
		confirm($result);

		$subject = "Activate Account";
		$message = "Please click the link below to activate your account;

		http://localhost/4thYearSoftwareProject/activate.phpemail=$email$code=$validation_code";

		$header = "From: noreply@betex.com";

		send_email($email, $subject, $message, $header);

		return true;
	}

}

function send_email($email, $subject, $message, $header){

	return mail($email, $subject, $message, $header);

}

?>