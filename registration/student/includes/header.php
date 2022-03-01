<?php
session_start();


if (isset($_GET['logout'])) {
    session_destroy();
    //unset($_SESSION['username']);
    header("location: ../loginstudent.php");
}


if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../loginstudent.php');
}


$student_id = $_SESSION['student_id'];
$db = mysqli_connect('localhost', 'root', '', 'registration');


?>
<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Student | Dashboard </title>
    <link rel="stylesheet" href="../assets/css/styledashboard.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../assets/css/select2.min.css">
    <script src="../assets/js/select2.min.js"></script>

</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            
            <span class="logo_name">WebEdu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="enrolled_courses.php">
                    <!-- <i class='bx bx-box'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Enrolled courses</span>
                </a>
            </li>
            <li>
                <a href="class_link.php">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Class links</span>
                </a>
            </li>
            <li>
                <a href="add_courses.php">
                    <!-- <i class='bx bx-pie-chart-alt-2'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Add course</span>
                </a>
            </li>
            <li>
                <a href="feedbacks.php">
                    <!-- <i class='bx bx-coin-stack'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Add feedback</span>
                </a>
            </li>
            <li>
            <a href="payfee.php">
                <!-- <a href="../../../registration/payment-using-paytm-php-master2/index.php"> -->
                    <!-- <i class='bx bx-book-alt'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Pay fee</span>
                </a>
            </li>
            <li>
                <!--
          <a href="#">
            <i class='bx bx-user' ></i>
            <span class="links_name">Team</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-message' ></i>
            <span class="links_name">Messages</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-heart' ></i>
            <span class="links_name">Favrorites</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-cog' ></i>
            <span class="links_name">Setting</span>
          </a>
        </li>-->
            <li class="log_out">
                <a href="studentdashboard.php?logout='1'">
                    <i class='bx bx-log-out'></i>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <span class="links_name">Logout</span>
                    <?php endif ?>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard</span>
            </div>
            <!--<div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>-->
            <div class="profile-details">
                <!--<img src="images/profile.jpg" alt="">-->
                <?php if (isset($_SESSION['username'])) : ?>
                    <span class="admin_name"><?php echo $_SESSION['username']; ?></span>
                    <!--<i class='bx bx-chevron-down' ></i>-->
                <?php endif ?>
            </div>
        </nav>