<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';
$s=0;

$joinedcourses_qry = "SELECT courses.course_id,courselist.course_name,teacher.te_name,courses.start_date
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where courses.course_status = 2 and courses.salary_status = 1";

$joinedcourses_records = mysqli_query($db, $joinedcourses_qry);





$paidcourses_qry = "SELECT courses.course_id,courselist.course_name,teacher.te_name,courses.start_date
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where courses.course_status = 2 and courses.salary_status = 2";

$paidcourses_records = mysqli_query($db, $paidcourses_qry);



?>

<div class="home-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php include 'includes/messages.php'; ?>



            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-10">

                <h4>Pending Salary section</h4>
                <table id="fa_datatable1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th>Start date</th>
                            <th>Due date</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($joinedcourses = mysqli_fetch_array($joinedcourses_records)) {
                            $course_id = $joinedcourses['course_id'];
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $joinedcourses['course_name'] ?></td>
                                <td><?= $joinedcourses['te_name'] ?></td>
                                <td><?= date("d-m-Y", strtotime($joinedcourses['start_date'])) ?></td>
                                <?php
                                
                                $string = date("d-m-Y", strtotime("+1 month", strtotime($joinedcourses['start_date'])));
                                //$string = $paidcourses['start_date'] ;
                                //$date = date('j', strtotime($string));
                                //$month = date('M', strtotime($string));
                                
                               ?>
                                <td><?= $string ?></td>

                                <td>
                                    <a href="fee_payment.php?id=<?php echo $course_id; ?>" class="btn btn-sm btn-primary"> Pay</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>


        <hr>

        
        <div class="row">
            <div class="col-md-10">

                <h4>Paid Salary section</h4>
                <table id="fa_datatable2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th>Start date</th>
                            <th>Due date</th>
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
                                <td><?= $paidcourses['te_name'] ?></td>
                                <td><?= date("d-m-Y", strtotime($paidcourses['start_date'])) ?></td>
                                
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

<?php
include 'includes/footer.php';
?>
<link href='../assets/datatables/jquery.dataTables.min.css' rel='stylesheet'>
<script src="../assets/datatables/jquery.dataTables.min.js"></script>

<style>
    hr{
        border: 5px solid #0a2558;
    }
</style>

<script>
    $(function() {

        $('#fa_datatable1').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $('#fa_datatable2').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>