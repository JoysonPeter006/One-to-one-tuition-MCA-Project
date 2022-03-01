<?php

if(!isset($_GET['id']) || !is_numeric($_GET['id']) )
    header('location: payfee.php');

include 'includes/header.php';

$student_qry = "SELECT fullname,email from student where id  = $student_id";
$student_result = mysqli_query($db, $student_qry);

$student = mysqli_fetch_array($student_result);

$course_id = $_GET['id'];
$schedule_qry = "SELECT courselist.rate,schedules.start_time,schedules.end_time from courses LEFT JOIN courselist on courselist.course_id = courses.courselist_id LEFT JOIN schedules on schedules.schedule_id = courses.schedule where courses.course_id   = $course_id";
$schedule_result = mysqli_query($db, $schedule_qry);

$schedule = mysqli_fetch_array($schedule_result);

$start_time = $schedule['start_time'];
$end_time = $schedule['end_time'];

$interval = date('H',strtotime($end_time)) - date('H',strtotime($start_time));
$total_rate = $interval * $schedule['rate'] * 30 * 100;
?>


<div class="home-content">
    <div class="container">
        <div class="row">

<form action="fee_successful_payment.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="rzp_test_Y5xKE8cuGJJceb" // Enter the Test API Key ID generated from Dashboard → Settings → API Keys
    data-amount="<?= $total_rate ?>" // Amount is in currency subunits. Hence, 29935 refers to 29935 paise or ₹299.35.
    data-currency="INR"// You can accept international payments by changing the currency code. Contact our Support Team to enable International for your account
    data-buttontext="Click to pay your fees"
    data-name="WebEdu"
    data-description="Pay your fees !!"
    data-prefill.name=">"
    data-prefill.email="<?= $student['email'] ?>"
    data-theme.color="#0a2558"
></script>
<input type="hidden" custom="Hidden Element" name="hidden">
<input type="hidden" name="course_id" value="<?= $course_id ?>">

</form>

</div>
</div>
</div>

<style>
    .razorpay-payment-button{
        background-color: #46a7f5;
        color: white;
        border: none;
        padding: 16px;
    }
</style>