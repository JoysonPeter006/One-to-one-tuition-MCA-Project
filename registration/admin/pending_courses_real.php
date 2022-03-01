<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';
if (isset($_POST['approve'])) {
    $course_id = $_POST['course_id'];

    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';

    if (strlen($err_msg) == 0) {
        $update_course = "UPDATE courses set course_status = 2 where course_id = $course_id";
        $update_result = mysqli_query($db, $update_course);

        if ($update_result)
            $succ_msg = "<p>Successfully added course</p>";
        else
            $err_msg = "<p>Could not add course</p>";
    }
}

if (isset($_POST['disapprove'])) {
    $course_id = $_POST['course_id'];

    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';

    if (strlen($err_msg) == 0) {
        $update_course = "UPDATE courses set course_status = 3 where course_id = $course_id";
        $update_result = mysqli_query($db, $update_course);

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
where courses.course_status = 1";

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

                <h4>Pending Courses</h4>
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

                                        <input type="hidden" name="course_id" value="<?= $pendingcourses['course_id'] ?>">
                                        <button class="btn btn-sm btn-success" name="approve">
                                            Approve
                                        </button>

                                        <button class="btn btn-sm btn-danger" name="disapprove">
                                            Disapprove
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