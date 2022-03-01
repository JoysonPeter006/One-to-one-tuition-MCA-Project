<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" href="assets/css/style1.css">
</head>
    
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
<div class="loginBox"> <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
    <h3>Register as a Teacher</h3>	
	<form action="registerteacher.php" method="post">
  	<?php include('errors.php'); ?>
        <div class="inputBox"> 
					<input id="username" type="text" name="username" placeholder="Username"> 
					<input id="email" type="text" name="email" placeholder="Email">
					<input id="fullname" type="text" name="fullname" placeholder="Full Name"> 
          <input id="qualification" type="text" name="qualification" placeholder="qualification"> 
					<input id="password" type="password" name="password_1" placeholder="Password">
					<input id="con_password" type="password" name="password_2" placeholder="Confirm Password">
			
		 </div> <input type="submit" name="reg_teacher" value="Sign Up">
    </form>
    <div class="text-center">
        <p style="color: #59238F;"><a href="loginteacher.php">Back to login page</a></p>
    </div>
  </form>
</body>
</html>