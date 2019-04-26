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

function display_message(){ //Display message from the session


	if(isset($_SESSION['message'])) {


		echo $_SESSION['message'];

		unset($_SESSION['message']);

	}



}

 //Added security when using forms, using this to ensure form input is coming from specific user page
function token_generator(){ 

	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

	return $token;
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

	if($_SERVER['REQUEST_METHOD'] == "POST"){ //post request

		if(isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']){

			$email = clean($_POST['email']);

			if(email_exists($email)){

				$validation_code = md5($email + microtime());

				//Cookie so that webpage isn't available all the time
				setcookie('temp_access_code', $validation_code, time()+ 60);

				$sql = "UPDATE users SET validation_code = '".escape($validation_code)."' WHERE email = '".escape($email)."' ";
				$result = query($sql);
				confirm($result);

				$subject = "Please reset your password";
				$message = " Here is your password reset code {$validation_code}

				Click here to reset ypur password http://localhost/4thYearSoftwareProject/code.php?email=$email&code=$validation_code
				";
				$headers = "From: noreply@betex.com";

				if(!send_email($email, $subject, $message, $headers)){
					
					echo validation_error("Email could not be sent ");

				}

				set_message("<p class='bg-success'>Please check your email or spam folder for a password reset code</p>");
				redirect("index.php");

			} else {
				echo validation_error("This email does not exist");
			}
		} else {
		//If the token isnt set redirect to index
		}

 
		if(isset($_POST['cancel_submit'])) {

			redirect("login.php");
		}
	}
} 

function validation_code(){//Function to use the validation code for recovery
	//Check if cookoe is set for temp access
	if(isset($_COOKIE['temp_access_code'])){
		//Validation to makes sure requests are correct
		if(!isset($_GET['email']) && !isset($_GET['code'])){
			redirect("index.php");
		} else if(empty($_GET['email']) || empty($_GET['code'])){
			redirect("index.php");
		} else{
			if(isset($_POST['code'])){
				$email = clean($_GET['email']);

				$validation_code = clean($_POST['code']);

				$sql = "SELECT id FROM users WHERE validation_code = '".escape($validation_code)."' AND email = '".escape($email)."'";
					$result = query($sql);

				if(row_count($result) == 1) {

						setcookie('temp_access_code', $validation_code, time()+ 900);

						redirect("reset.php?email=$email&code=$validation_code");


				} else {
					echo validation_error("Sorry wrong validation code");
				}
			}
		}

	} else {
		set_message("<p class='bg-danger'>Sorry your validation cookie was expired</p>");
		redirect("recover.php");
	}
}

function password_reset(){ //Function to reset the password

	if(isset($_COOKIE['temp_access_code'])){

		if(isset($_GET['email']) && isset($_GET['code'])){

			if(isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){

				if($_POST['password'] === $_POST['confirm_password']){

					$updated_password = md5($_POST['password'] );
					
					$sql = "UPDATE users SET password = '".escape($_POST['updated_password']."', validation_code = 0 WHERE email = '".escape($_GET['email'])."' ");
					query($sql);

					set_message("<p class='bg-success'>Your password has been updated please login</p>");
					redirect("login.php");
				}
			}
		} 

	} else {
			set_message("<p class='bg-danger text-centre'>Sorry your cookie has expired</p> ");
			redirect('recover.php');
		}
}

function getTeam1(){
	$sql = "SELECT * FROM contest";
	$result = query($sql);

	confirm($result);
	$row = fetch_array($result);
	echo $row['team1'];
}

function getTeam2(){
	$sql = "SELECT * FROM contest";
	$result = query($sql);

	confirm($result);
	$row = fetch_array($result);
	echo $row['team2'];
}

function getOddsTeam1(){
	$sql = "SELECT * FROM contest";
	$result = query($sql);

	confirm($result);
	$row = fetch_array($result);
	echo $row['odds_team1'];
}

function getOddsTeam2(){
	$sql = "SELECT * FROM contest";
	$result = query($sql);

	confirm($result);
	$row = fetch_array($result);
	echo $row['odds_team2'];
}

function getOddsDraw(){
	$sql = "SELECT * FROM contest";
	$result = query($sql);

	confirm($result);
	$row = fetch_array($result);
	echo $row['odds_draw'];
}

function displayCredit(){
	//$sql = "SELECT * FROM users WHERE id = '".$_GET['id']."'";
	//$result = query($sql);

	//confirm($result);
	//$row = fetch_array($result);
	//var_dump($result);
	//$email = $_SESSION['id'];
	//echo $email;
	//if(isset($_SESSION['id'])){
	//get sesssion id for access to tables pk.
		//$id = $_SESSION['id'];
		//$query = "SELECT credit FROM `users` WHERE email = '".escape($_SESSION['email'])."'";
		//$result = query($sql);
		//$row = fetch_array($result);
		//amount = $row['credit'];
		//echo $amount;
	//}
}

function topUp(){
	$conn = mysqli_connect('localhost', 'root', '', 'login_db');
    if(isset($_POST['topup-submit'])){
      $amount = $_POST['amount'];

      $sql = "UPDATE users SET credit= $amount WHERE email = '".escape($_SESSION['email'])."'";
      if ($conn->query($sql) === TRUE) {
        redirect("index.php");
      } else {
        echo "Error updating record: " . $conn->error;
      }

      $conn->close();
  }
}

function placeBet(){
	$sql = "SELECT contest.contestID, contest.team1, contest.odds_team1 FROM contest";
	$result = query($sql);

	confirm($result);
	$row = fetch_array($result);


	$sql1 = "SELECT users.id, users.email FROM users WHERE email = '".escape($_SESSION['email'])."'";
	$result1 = query($sql1);

	confirm($result1);
	$row1 = fetch_array($result1);

	$contestID 	= $row['contestID'];
	$team1 		= $row['team1'];
	$odds_team1 = $row['odds_team1'];

	$userID 	= $row1['id'];
	$email 		= $row1['email'];

	$amount = $row['odds_team1'];

	echo $contestID, ' ' , $team1, ' ' , $odds_team1, ' ' , $userID, ' ' , $email;

	$sql3 = 	"INSERT INTO memberBets 
		    	SET contestID= '".$contestID."',
		      	usersID= '".$userID."',
		      	betName= '".$team1."',
		      	betAmount= '".$amount."',
		      	betOdds= '".$odds_team1."'		    
		    ";
	$result3 = query($sql3);

	confirm($result3);

	echo 'Success';
}




?>