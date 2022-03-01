<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" href="assets/css/style1.css">
</head>
<body>
<div class="loginBox"> <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
    <h3>Login in as a admin</h3>
    <form method="post">
    <?php include('errors.php'); ?>
        <div class="inputBox"> 
			<input id="username" type="text" name="username" placeholder="Username"> 
			<input id="password" type="password" name="password" placeholder="Password"> 
			<input type="submit" class="btn" name="login_admin">Login</button>
		</div>
  		

    </form> <a href="http://localhost/indextemp.html">Go to homepage<br> </a>
    
</div>
</body>
</html>