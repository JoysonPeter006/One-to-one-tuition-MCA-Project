<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';
if (isset($_POST['approve'])) {
    $course_id = $_POST['course_id'];
    $link = $_POST['link'];
    $start_date= $_POST['shootdate'];
    $time = $_POST['time'];
    //$start_date = date("d M Y", $start_date_1);
    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';

    if (strlen($err_msg) == 0) {
        $update_course_link = "UPDATE courses set interview_link='$link' where course_id = $course_id";
        $update_result_link = mysqli_query($db, $update_course_link);
        $update_course_start = "UPDATE courses set interview_date='$start_date' where course_id = $course_id";
        $update_result_start = mysqli_query($db, $update_course_start);
        $update_course_time = "UPDATE courses set interview_time='$time' where course_id = $course_id";
        $update_result_time = mysqli_query($db, $update_course_time);
        $update_course_status = "UPDATE courses set interview_status=3 where course_id = $course_id";
        $update_result_status = mysqli_query($db, $update_course_status);
        if ($update_result)
            $succ_msg = "<p>Successfully added course</p>";
        else
            $err_msg = "<p>Could not add course</p>";
    }
}


$pendingcourses_qry = "SELECT courses.course_id,courselist.experience,student.fullname,schedules.start_time,schedules.end_time,teacher.te_name,teacher.qualification,courselist.course_name
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where courses.course_status = 1 and courses.interview_status=1";


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

                <h4>Pending Interviews</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Student</th>
                            <th>Teacher & Qualification</th>
                            <th>Schedule</th>
                            <th>Experience</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($pendingcourses = mysqli_fetch_array($pendingcourses_records)) {
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $pendingcourses['course_name'] ?></td>
                                <td><?= $pendingcourses['fullname'] ?></td>
                                <td><?= $pendingcourses['te_name'] . ' - ' . $pendingcourses['qualification'] ?></td>
                                <td><?= $pendingcourses['start_time'] . ' - ' . $pendingcourses['end_time'] ?></td>
                                <td><?= $pendingcourses['experience'] ?></td>

                                <td>
                                    <form method="post">
                                    <label for="inputName">Add interview link</label>
                                    <input type="text" name="link" id="link" class="form-control">
                    

                                        <input type="hidden" name="course_id" value="<?= $pendingcourses['course_id'] ?>">
<input type=hidden name=todo value="Start date">

<label for="shootdate">Date of interview:</label>
<input required type="date" name="shootdate" id="shootdate" title="Choose your desired date" min="<?php echo date('Y-m-d'); ?>"/>
<br>
<label for="inputName">Add interview time</label>
                                    <input type="text" name="time" id="time" class="form-control">

                                        <button class="btn btn-sm btn-success" name="approve">
                                            Approve
                                        </button>

                                       
                                    </form>
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