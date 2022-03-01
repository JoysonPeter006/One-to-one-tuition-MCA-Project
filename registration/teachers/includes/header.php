<?php
session_start();


if (isset($_GET['logout'])) {
    session_destroy();
    //unset($_SESSION['username']);
    header("location: ../loginteacher.php");
}


if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../loginteacher.php');
}


$teacher_id = $_SESSION['teacher_id'];
$db = mysqli_connect('localhost', 'root', '', 'registration');


?>
<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Teacher | Dashboard </title>
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
            <i class='bx bxl-c-plus-plus'></i>
            <span class="logo_name">WebEdu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="active_classes.php">
                    <!-- <i class='bx bx-box'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Active classes</span>
                </a>
            </li>
            <li>
                <a href="class_link.php">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Class links</span>
                </a>
            </li>
            <li>
                <a href="add_courses_1.php">
                    <!-- <i class='bx bx-pie-chart-alt-2'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Add courses</span>
                </a>
            </li>
            <li>
                <a href="view_feedbacks.php">
                    <!-- <i class='bx bx-coin-stack'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">View feedbacks</span>
                </a>
            </li>
            <li>
                <a href="viewsalary.php">
                    <!-- <i class='bx bx-book-alt'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">View salary</span>
                </a>
            </li>
            <li>
            <a href="pendinginterview.php">
                    <!-- <i class='bx bx-book-alt'></i> -->
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Interview</span>
                </a>
            </li>
           
            <li class="log_out">
                <a href="teacherdashboard.php?logout='1'">
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