<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login student</title>
  <link rel="stylesheet" href="assets/css/style1.css">
</head>
<body>
<div class="loginBox"> <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
    <h3>Sign in as a student</h3>
    <form action="loginstudent.php" method="post">
    <?php include('errors.php'); ?>
        <div class="inputBox"> 
			<input id="username" type="text" name="username" placeholder="Username"> 
			<input id="password" type="password" name="password" placeholder="Password"> 
			<input type="submit" class="btn" name="login_student">Login</button>
		</div>
  		

    </form> <a href="http://localhost/indextemp.html">Back to homepage<br> </a>
    <div class="text-center">
        <p style="color: #59238F;"><a href="registerstudent.php">Sign-Up</a></p>
    </div>
</div>
</body>
</html>