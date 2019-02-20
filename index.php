<?php include("includes/header.php") ?>

  <?php include("includes/nav.php") ?>




  <div class="jumbotron">
    <h1 class="text-center"> Home Page</h1>
  </div>

  <?php 

  	$sql = "SELECT * FROM users"; //get data from database
  	$result = query($sql);	//assign it to a variable result

  	confirm($result);	//confirm the data is ok

  	$row = fetch_array($result);	//get it in array format

  	echo $row['username'];

  ?>

<?php include("includes/footer.php") ?>