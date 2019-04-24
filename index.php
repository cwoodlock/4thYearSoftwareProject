<?php include("includes/header.php") ?>

  <?php include("includes/nav.php") ?>



<div>
  <div class="carousel slide" id=myCarousel data-ride="carousel" data-interval = "10000">
	  	<?php 
	    display_message();
	  	?>
    	<ol class = "carousel-indicators">
    		<li data-target="#myCarousel data-slide-to"0" class="active"></li>
    		<li data-target="#myCarousel data-slide-to"1"></li>
    		<li data-target="#myCarousel data-slide-to"2"></li>
    	</ol>
    	<div class="carousel-inner">
    		<div class="item active">
    			<img src="https://i.imgur.com/NokE99n.jpg" alt="Image 1">
    		</div>
    		<div class="item">
    			<img src="https://i.imgur.com/i2Wvh98.jpg" alt="Image 2">
    		</div>
    		<div class="item">
    			<img src="https://i.imgur.com/mBFIL1w.jpg" alt="Image 3">
    		</div>
    	</div>
    	<a href="#myCarousel" class="left carousel-control" role="button" data-slide="prev"></a>
    	<a href="#myCarousel" class="right carousel-control" role="button" data-slide="next"></a>
  </div>

  <div>
  <?php 
  	if(logged_in()){
			  		$sql = "SELECT contestID, team1, team2, odds_team1, odds_team2, lay_team1, lay_team2, odds_draw, lay_draw FROM contest";

			  		$result = query($sql);
			  		confirm($result);

			  		if($result-> num_rows > 0){
			  			while ($row = $result-> fetch_assoc()) {
			  				echo '<div>
			  					<div class = "row">
			  						<div class= "panel panel-success">
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
		       								<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">Place Bet/Lay</button>

												<!-- Modal -->
												<div id="myModal" class="modal fade" role="dialog">
												  <div class="modal-dialog">

												    <!-- Modal content-->
												    <div class="modal-content">
												      <div class="modal-header">
												        <button type="button" class="close" data-dismiss="modal">&times;</button>

												        <h4 class="modal-title">'.$row['team1'].' Vs. '.$row['team2'].'</h4>
												      </div>

												      <div class="modal-body">
												        <div class = "panel-body" >
														   	<div>
														      	'.$row['team1'].'
															      	<p>
																	  	<a class="btn btn-primary" data-toggle="collapse" href="#team1bet" role="button" aria-expanded="false" aria-controls="team1bet">
																	    '.$row['odds_team1'].'
																	  	</a>

																	  	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#team1lay" aria-expanded="false" aria-controls="team1lay">
																	    '.$row['lay_team1'].'
																	  	</button>
																	</p>
																	<div class="collapse" id="team1bet">
																	  <div class="card card-body">
																	    <div class="jumbotron" style = "padding: 5px 5px 5px;">
																			<p class="lead">
																				Bet Odds:
																			  	<input class="form-control" type="number" id="example-number-input" value="'.$row['odds_team1'].'">
																			  	Amount to Bet/Lay:
																			  	<input class="form-control" type="number" id="Team1-bet-amount" placeholder="amount" ">
																			    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
																			</p>
																		</div>
																	  </div>
																	</div>
																<div class="collapse" id="team1lay">
																	<div class="card card-body">
																	    <div class="jumbotron" style = "padding: 5px 5px 5px;">
																			<p class="lead">
																				Lay Odds:
																			  	<input class="form-control" type="number" id="example-number-input" value="'.$row['lay_team1'].'">
																			  	Amount to Bet/Lay:
																			  	<input class="form-control" type="number" id="Team1-lay-amount" placeholder="amount">
																			    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
																			</p>
																		</div>
																	</div>
																</div>
															</div>


														    <div>
														      	Draw
															      	<p>
																	  	<a class="btn btn-primary" data-toggle="collapse" href="#drawbet" role="button" aria-expanded="false" aria-controls="drawbet">
																	    '.$row['odds_draw'].'
																	  	</a>

																	  	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#drawlay" aria-expanded="false" aria-controls="drawlay">
																	   '.$row['lay_draw'].'
																	  	</button>
																	</p>
																	<div class="collapse" id="drawbet">
																	  <div class="card card-body">
																	    <div class="jumbotron" style = "padding: 5px 5px 5px;">
																			<p class="lead">
																				Bet Odds:
																			  	<input class="form-control" type="number" id="example-number-input" value="'.$row['odds_draw'].'">
																			  	Amount to Bet/Lay:
																			  	<input class="form-control" type="number" id="Draw-bet-amount" placeholder="amount">
																			    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
																			</p>
																		</div>
																	  </div>
																	</div>
																<div class="collapse" id="drawlay">
																	<div class="card card-body">
																	    <div class="jumbotron" style = "padding: 5px 5px 5px;">
																			<p class="lead">
																				Lay Odds:
																			  	<input class="form-control" type="number" id="example-number-input" value="'.$row['lay_draw'].'">
																			  	Amount to Bet/Lay:
																			  	<input class="form-control" type="number" id="Draw-lay-amount" placeholder="amount">
																			    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
																			</p>
																		</div>
																	</div>
																</div>
															</div>	


														    <div>
														      	'.$row['team2'].'
															      	<p>
																	  	<a class="btn btn-primary" data-toggle="collapse" href="#team2bet" role="button" aria-expanded="false" aria-controls="team2bet">
																	    '.$row['odds_team2'].'
																	  	</a>

																	  	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#team2lay" aria-expanded="false" aria-controls="team2lay">
																	    '.$row['lay_team2'].'
																	  	</button>
																	</p>
																	<div class="collapse" id="team2bet">
																	  <div class="card card-body">
																	    <div class="jumbotron" style = "padding: 5px 5px 5px;">
																			<p class="lead">
																				Bet Odds:
																			  	<input class="form-control" type="number" id="example-number-input" value="'.$row['odds_team2'].'">
																			  	Amount to Bet/Lay:
																			  	<input class="form-control" type="number" id="Team2-bet-amount" placeholder="amount">
																			    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
																			</p>
																		</div>
																	  </div>
																	</div>
																<div class="collapse" id="team2lay">
																	<div class="card card-body">
																	    <div class="jumbotron" style = "padding: 5px 5px 5px;">
																			<p class="lead">
																				Lay Odds:
																			  	<input class="form-control" type="number" id="example-number-input value="'.$row['lay_team2'].'"">
																			  	Amount to Bet/Lay:
																			  	<input class="form-control" type="number" id="Team2-lay-amount" placeholder="amount">
																			    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
																			</p>
																		</div>
																	</div>
																</div>
															</div>
														      
														   </div>
														</div>
												      </div>

												      
												    </div>

												  </div>
												</div>
	       								</div>
       								</div>
       								</div>
       								</div>';
       							
       							}
			  			}
			  		}
			  	?>
	</div>
</div>


<?php include("includes/footer.php") ?>