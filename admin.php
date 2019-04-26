<?php include("includes/header.php") ?>

  <?php include("includes/nav.php") ?>
  	<div class="jumbotron">
    			<h1 class="text-center">Your Bets</h1>
  	</div>

	<div class = "panel panel-success">
		<h4 class="text-center">
			<?php 
				if(logged_in()){
			  		$sql = "SELECT memberbets.betName, memberbets.betAmount, memberbets.betOdds
								FROM memberbets
  								JOIN users ON memberbets.usersID = users.id
								WHERE memberbets.usersID = users.id";

			  		$result = query($sql);
			  		confirm($result);

			  		if($result-> num_rows > 0){
			  			while ($row = $result-> fetch_assoc()) {
			  				echo '<table class="table">
									  <thead>
									    <tr>
									      <th scope="col"></th>
									      <th scope="col">Bet Name</th>
									      <th scope="col">Bet Amount</th>
									      <th scope="col">Bet Odds</th>
									    </tr>
									  </thead>
									  <tbody>
									    <tr>
									  	  <th scope="col"></th>
									      <td>'.$row['betName'].'</td>
									      <td>'.$row['betAmount'].'</td>
									      <td>'.$row['betOdds'].'</td>
									      
									    </tr>
									  </tbody>
									</table>';
								}
					}
				} else {
					redirect("index.php");
				}

			?>

		</h4>
	</div>

<?php include("includes/footer.php") ?>