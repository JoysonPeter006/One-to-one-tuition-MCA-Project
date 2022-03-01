<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';
$s=0;
$paidcourses_qry = "SELECT courses.course_id,courselist.course_name,student.fullname,courses.start_date
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where courses.course_status = 2 and courses.salary_status = 2 and teacher.te_id=$teacher_id";

$paidcourses_records = mysqli_query($db, $paidcourses_qry);



?>
<div class="home-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php include 'includes/messages.php'; ?>



            </div>
        </div>
<div class="row">
            <div class="col-md-10">

                <h4>Paid Salary section</h4>
                <table id="fa_datatable2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>student</th>
                            <th>Start date</th>
                            <th>Paid date</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($paidcourses = mysqli_fetch_array($paidcourses_records)) {
                            $course_id = $paidcourses['course_id'];
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $paidcourses['course_name'] ?></td>
                                <td><?= $paidcourses['fullname'] ?></td>
                                <td><?= $paidcourses['start_date'] ?></td>
                                <?php
                                
                                $string = date("d-m-Y", strtotime("+1 month", strtotime($paidcourses['start_date'])));
                                //$string = $paidcourses['start_date'] ;
                                //$date = date('j', strtotime($string));
                                //$month = date('M', strtotime($string));
                                
                               ?>
                                <td><?= $string ?></td>
                                

                                <td>
                                    <a class="btn btn-sm btn-success"> Paid</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>


</div>