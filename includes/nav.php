<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">BetEx</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if(!logged_in()):?>
              <li class="active"><a href="index.php">Home</a></li>
              <li class="active"><a href="login.php">Login/Register</a></li>

            <?php endif; ?>

            <?php if(logged_in()):?>
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="admin.php">Admin</a></li>
              <li><a>Credit: <?php
                            $sql = "SELECT users.credit FROM users WHERE email = '".escape($_SESSION['email'])."'";
                            $result = query($sql);

                            confirm($result);
                            $row = fetch_array($result);
                            $contestID  = $row['credit'];
                            echo $contestID;

                             ?></a></li>
              <li><a href="credit.php">Top Up</a></li>
              <li><a href="logout.php">Logout</a></li>

            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>