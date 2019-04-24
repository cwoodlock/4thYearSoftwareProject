<?php include("includes/header.php") ?>

  <?php include("includes/nav.php") ?>




  <div class="jumbotron">
  <?php 
    display_message();
  ?>
    <h1 class="text-center"> Home</h1>
  </div>

  <?php 
			  		$sql = "SELECT team1, team2, odds_team1, odds_team2, lay_team1, lay_team2 FROM contest";

			  		$result = query($sql);
			  		confirm($result);

			  		if($result-> num_rows > 0){
			  			while ($row = $result-> fetch_assoc()) {
			  				echo '<div class = "row">
			  						<div class= "panel panel-primary">
			  							<div class= "panel-heading"><h3 	class="panel-title">'.$row['team1'].' Vs '.$row['team2'].'</h3></div>

				  						<div class= "body-panel">
					  						<table>
			       								<tr>
			       									<th>Team 1</th>
			       									<th>Team 2</th>
			       								</tr>
			       								<tr>
			       									<td>'.$row['team1'].'</td>
			       									<td>'.$row['team2'].'</td>
			       								</tr>
			       								<tr>
			       									<td>'.$row['odds_team1'].'</td>
			       									<td>'.$row['odds_team2'].'</td>
			       								</tr>
			       								<tr>
			       									<td>'.$row['lay_team1'].'</td>
			       									<td>'.$row['lay_team2'].'</td>
			       								</tr>

		       								</table>
		       								<a class="btn btn-success btn-lg" href="place_bet.php" role="button">Place Bet</a>
	       								</div>
       								</div>
       								</div>';
			  				
							



			  			}
			  		}
			  	?>



<?php include("includes/footer.php") ?>