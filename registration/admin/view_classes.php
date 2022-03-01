<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';
if (isset($_POST['add'])) {
    $course_id = $_POST['course_id'];

    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_course = "INSERT INTO courses (courselist_id, student_id) VALUES ($course_id,$student_id)";
        $insert_result = mysqli_query($db, $insert_course);

        if ($insert_result)
            $succ_msg = "<p>Successfully added course</p>";
        else
            $err_msg = "<p>Could not add course</p>";
    }
}

$joinedcourses_qry = "SELECT courses.course_id,student.fullname,schedules.start_time,schedules.end_time,teacher.te_name,teacher.qualification,courselist.course_name
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where  courses.course_status = 2";

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

                <h4>Enrolled Courses</h4>
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