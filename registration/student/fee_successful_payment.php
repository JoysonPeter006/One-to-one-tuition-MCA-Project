<?php

include 'includes/header.php';

$course_id = $_POST['course_id'];
$fee_qry = "Update courses set fee_status = 2 where course_id = $course_id";
$fee_result = mysqli_query($db, $fee_qry);

if($fee_result){
    $alert_msg = "Fees succesfully paid !!";
    $alert_type = "success";
}else{
    $alert_msg = "Something went wrong while paying,please contact the admin and take a screenshot";
    $alert_type = "error";
}


?>



<div class="home-content">
    <div class="container">
        <div class="row">

            
    <div class="alert alert-<?= $alert_type ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $alert_msg ?>
    </div>


</div>
</div>
</div>