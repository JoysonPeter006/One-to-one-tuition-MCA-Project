<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';


$joinedcourses_qry = "SELECT courses.course_id,student.fullname,schedules.start_time,schedules.end_time,teacher.te_name,teacher.qualification,courselist.course_name
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where  courses.course_status = 2 and teacher.te_id=$teacher_id";

$joinedcourses_records = mysqli_query($db, $joinedcourses_qry);



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

                <h4>Active classes</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Student</th>
                            <th>Teacher & Qualification</th>
                            <th>Schedule</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($joinedcourses = mysqli_fetch_array($joinedcourses_records)) {
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $joinedcourses['course_name'] ?></td>
                                <td><?= $joinedcourses['fullname'] ?></td>
                                <td><?= $joinedcourses['te_name'] . ' - ' . $joinedcourses['qualification'] ?></td>
                                <td><?= $joinedcourses['start_time'] . ' - ' . $joinedcourses['end_time'] ?></td>

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


<script>
    $(function() {

        $('#fa_datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>