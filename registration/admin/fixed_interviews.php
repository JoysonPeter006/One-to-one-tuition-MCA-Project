<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';

$pendingcourses_qry = "SELECT courses.interview_date,courses.interview_link,courses.course_id,courselist.experience,student.fullname,schedules.start_time,schedules.end_time,teacher.te_name,teacher.qualification,courselist.course_name
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where courses.course_status = 1 and courses.interview_status=3";


$pendingcourses_records = mysqli_query($db, $pendingcourses_qry);



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

                <h4>Upcoming Interviews</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Student</th>
                            <th>Teacher & Qualification</th>
                            <th>Schedule</th>
                            <th>Experience</th>
                            <th>Date</th>
                            <th>interview link</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($pendingcourses = mysqli_fetch_array($pendingcourses_records)) {
                        ?>
                        <?php
                        $date_now = new DateTime();
                        $date2    = new DateTime(date("d-m-Y", strtotime($pendingcourses['interview_date'])));
                        if($date2>=$date_now)
                        {?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $pendingcourses['course_name'] ?></td>
                                <td><?= $pendingcourses['fullname'] ?></td>
                                <td><?= $pendingcourses['te_name'] . ' - ' . $pendingcourses['qualification'] ?></td>
                                <td><?= $pendingcourses['start_time'] . ' - ' . $pendingcourses['end_time'] ?></td>
                                <td><?= $pendingcourses['experience'] ?></td>
                                <td><?= date("d-m-Y", strtotime($pendingcourses['interview_date'])) ?></td>
                                <td> <a class="btn btn-sm btn-primary" href="<?= $pendingcourses['interview_link'] ?>" target="_blank">Go to interview</a></td>
                            </tr>
                        <?php }} ?>
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