<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

 
	<div class = "panel panel-default" style = "padding: 0px 00px 10px;">
	   <div class = "panel-heading">
	      <h3 class = "panel-title">
	         <?php getTeam1(); ?> vs <?php getTeam2(); ?>
	      </h3>
	   </div>
	   
	   <div class = "panel-body" >
	   	<div>
	      	<?php getTeam1(); ?>
		      	<p>
				  	<a class="btn btn-primary" data-toggle="collapse" href="#team1bet" role="button" aria-expanded="false" aria-controls="team1bet">
				    <?php getOddsTeam1(); ?>
				  	</a>

				  	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#team1lay" aria-expanded="false" aria-controls="team1lay">
				    Team 1 Lay
				  	</button>
				</p>
				<div class="collapse" id="team1bet">
				  <div class="card card-body">
				    <div class="jumbotron" style = "padding: 5px 5px 5px;">
						<p class="lead">
							Bet Odds:
						  	<input class="form-control" type="number" id="example-number-input" value="<?php getOddsTeam1(); ?>">
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
						  	<input class="form-control" type="number" id="example-number-input">
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
				    <?php getOddsDraw(); ?>
				  	</a>

				  	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#drawlay" aria-expanded="false" aria-controls="drawlay">
				    Draw Lay
				  	</button>
				</p>
				<div class="collapse" id="drawbet">
				  <div class="card card-body">
				    <div class="jumbotron" style = "padding: 5px 5px 5px;">
						<p class="lead">
							Bet Odds:
						  	<input class="form-control" type="number" id="example-number-input" value="<?php getOddsDraw(); ?>">
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
						  	<input class="form-control" type="number" id="example-number-input">
						    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
						</p>
					</div>
				</div>
			</div>
		</div>	


	    <div>
	      	<?php getTeam2(); ?>
		      	<p>
				  	<a class="btn btn-primary" data-toggle="collapse" href="#team2bet" role="button" aria-expanded="false" aria-controls="team2bet">
				    <?php getOddsTeam2(); ?>
				  	</a>

				  	<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#team2lay" aria-expanded="false" aria-controls="team2lay">
				    Team 2 Lay
				  	</button>
				</p>
				<div class="collapse" id="team2bet">
				  <div class="card card-body">
				    <div class="jumbotron" style = "padding: 5px 5px 5px;">
						<p class="lead">
							Bet Odds:
						  	<input class="form-control" type="number" id="example-number-input" value="<?php getOddsTeam2(); ?>">
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
						  	<input class="form-control" type="number" id="example-number-input">
						    <a class="btn btn-success btn-lg" href="#" role="button">Place Bet</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	      
	   </div>
	</div>
<?php include("includes/footer.php") ?>