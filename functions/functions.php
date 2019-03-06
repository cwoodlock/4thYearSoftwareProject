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
		$message = "Please click the link below to activate your account:

		http://localhost/4thYearSoftwareProject/activate.php?email=$email&code=$validation_code";

		$header = "From: noreply@betex.com";

		send_email($email, $subject, $message, $header);

		return true;
	}

}

function send_email($email, $subject, $message, $header){

	return mail($email, $subject, $message, $header);

}

function activate_user(){
	//Test URL http://localhost/4thYearSoftwareProject/activate.php?email=jsmith@gmail.com&code=441c10bb769d04ff03ee47c77ce6bd42
	if($_SERVER['REQUEST_METHOD'] == "GET"){

		if(isset($_GET['email'])) {

			//Get the variables for email and the validation code from the url
			$email = clean($_GET['email']);

			$validation_code = clean($_GET['code']);

			//SQL statement and confirm the validation
			$sql = "SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code = '".escape($_GET['code'])."' ";
			$result = query($sql);
			confirm($result);

			if(row_count($result) == 1) {
				//Set the user to the active state
				$sql2 = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."' AND validation_code = '".escape($validation_code)."' ";	
				$result2 = query($sql2);
				confirm($result2);

				//Set the message in session
				set_message("<p class='bg-success'>Your account has been activated please login</p>");

				//Redirect the user to login
				redirect("login.php");


			} else {
				
				set_message("<p class='bg-danger'>Sorry your account could not be activated </p>");

				redirect("login.php");


			}

			
		}
	}
}

function validate_user_login(){ //Function will validate the user when loging in

	$errors = [];

	$min = 3;
	$max = 20;

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$email = clean($_POST['email']);
		$password = clean($_POST['password']);
		$remember = isset($_POST['password']); //Checks for the remember me check box

		if(empty($email)) {
			$errors[] = "Email field cannot be empty";
		}

		if(empty($password)) {
			$errors[] = "Password field cannot be empty";
		}


		if(!empty($errors)){

			foreach ($errors as $error) {

				//Display validation error
				echo validation_error($error);			
			} 
		} else {
			if(login_user($email, $password, $remember)){
				redirect("admin.php");
			} else {
				echo validation_error("Your information was not correct");
			}
		}

	}
}

function login_user($email, $password, $remember){ //Function to log the user in by comparing what they enter to the database

	$sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active = 1";

	$result = query($sql);
	if(row_count($result) == 1){

		//Get the password from the database
		$row = fetch_array($result);
		$db_password = $row['password'];

		//de-crypt the hashed password from the database
		if(md5($password) == $db_password){

			if($remember == "on"){
				setcookie('email', $email, time() + 86400); //the cookie will expire after 1 day in secs
			}

			//Save email in the session
			$_SESSION['email'] = $email;

			return true;
		} else {
			return false;
		}

		return true;
	} else {
		return false;
	}

}

function logged_in(){ //This function will make sure that the user stays logged in when they log in

	if(isset($_SESSION['email']) || isset($_COOKIE['email'])){
		return true;
	} else {
		return false;
	}

}

function recover_password(){ //his fucntion will recover the password

}

?>