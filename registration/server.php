<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_student'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if(!(preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email)))
  { array_push($errors,"You haven't provided a valid email"); }
  if (empty($fullname)) { array_push($errors, "Fullname is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ((strlen($password_1) < 5) || (strlen($password_1) > 16))
  { array_push($errors,"Your password must be between 5 and 16 characters. Please type in a longer password");}
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM student WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO student (username, email,fullname, password) 
  			  VALUES('$username', '$email','$fullname', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
    $query2 = "SELECT * FROM student WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query2);
        $login_row = mysqli_fetch_assoc($results);
    $_SESSION['student_id'] = $login_row['id'];
  	$_SESSION['success'] = "You are now logged in";
  	header('location: student/studentdashboard.php');
  }
}


if (isset($_POST['login_student'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM student WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        $login_row = mysqli_fetch_assoc($results);

        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['student_id'] = $login_row['id'];
          $_SESSION['success'] = "You are now logged in";
          header('location: student/studentdashboard.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }


  // REGISTER USER
if (isset($_POST['reg_teacher'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $qualification = mysqli_real_escape_string($db, $_POST['qualification']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if(!(preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email)))
  { array_push($errors,"You haven't provided a valid email"); }
  if (empty($fullname)) { array_push($errors, "Fullname is required"); }
  if (empty($qualification)) { array_push($errors, "Qualification is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ((strlen($password_1) < 5) || (strlen($password_1) > 16))
  { array_push($errors,"Your password must be between 5 and 16 characters. Please type in a longer password");}
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM teacher WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO teacher (username, email,te_name,qualification, password) 
  			  VALUES('$username', '$email','$fullname','$qualification', '$password')";
  	mysqli_query($db, $query);
    $query2 = "SELECT * FROM teacher WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query2);
        $login_row = mysqli_fetch_assoc($results);
  	$_SESSION['username'] = $username;
    $_SESSION['teacher_id'] = $login_row['te_id'];
  	$_SESSION['success'] = "You are now logged in";
  	header('location: teachers/teacherdashboard.php');
  }
}


if (isset($_POST['login_teacher'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM teacher WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        $login_row = mysqli_fetch_assoc($results);

        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";
          $_SESSION['teacher_id'] = $login_row['te_id'];

          header('location: teachers/teacherdashboard.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  


if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";

          header('location: admin/admindashboard.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  
  ?>