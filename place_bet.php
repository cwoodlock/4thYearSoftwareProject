<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

 
<div class="jumbotron">
	<h1><?php 
			if(isset($_POST['placeBetTeam1'])){
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

				$amount = $_POST['Team1BetAmount'];

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
</div>
<div>
	<form action="place_bet.php" method="post">
		<div class="container">
			<div class = "row">
				<div class="col-sm-3">
					<h1>Test</h1>
					Amount to Bet/Lay:
					<input class="form-control" type="number" name="Team1BetAmount" placeholder="amount" ">
					<input class="btn btn-success" type="submit" name="placeBetTeam1" value="Place Bet">
				</div>
			</div>
		</div>
	</form>
</div>
<?php include("includes/footer.php") ?>