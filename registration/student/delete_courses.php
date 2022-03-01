<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id']))
    header('location: add_courses.php');


include 'includes/header.php';
?>

<?php

$course_id = $_GET['id'];




$delete_course = "Delete from courses where course_id = $course_id";
$delete_result = mysqli_query($db, $delete_course);


header('location: add_courses.php');



?>
