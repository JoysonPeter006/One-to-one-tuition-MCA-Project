<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id']))
    header('location: add_courses.php');


include 'includes/header.php';
?>

<?php

$id = $_GET['id'];
$joinedcourses_qry = "SELECT * from courses where course_id =  $id";


$joinedcourses_records = mysqli_query($db, $joinedcourses_qry);
$joined_courses = mysqli_fetch_array($joinedcourses_records);


$course_qry = 'SELECT teacher.te_name,teacher.qualification,courselist.* from courselist LEFT JOIN teacher on teacher.te_id = courselist.teacher_id';
$course_records = mysqli_query($db, $course_qry);

$schedule_qry = 'SELECT * from schedules';
$schedule_records = mysqli_query($db, $schedule_qry);


$err_msg = $succ_msg = '';
if (isset($_POST['edit'])) {
    $course_id = $_POST['course_id'];
    $courselist_id = $_POST['courselist_id'];
    $schedule = $_POST['schedule'];
    $course_status = 1;

    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';
    $err_msg .= (empty($schedule)) ? '<p>Please select a time</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_course = "UPDATE courses set courselist_id = $courselist_id,schedule=$schedule where course_id = $course_id";
        $insert_result = mysqli_query($db, $insert_course);

        if ($insert_result)
            $succ_msg = "<p>Successfully updated course</p>";
        else
            $err_msg = "<p>Could not update course</p>";
    }
}


?>

<div class="home-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php include 'includes/messages.php'; ?>


                <form method="post" action="">

                <input type="hidden" name="course_id" value="<?= $id ?>">

                    <div class="form-group col-md-6">
                        <label for="inputName">Select course</label>
                        <select name="courselist_id" id="courselist_id" class="select2 form-control">
                            <?php while ($courses = mysqli_fetch_array($course_records)) { ?>
                                <option <?= ($joined_courses['courselist_id'] == $courses['course_id']) ? 'selected' : ''; ?> value="<?= $courses['course_id'] ?>"><?= $courses['course_name'] . ' - ' . $courses['te_name'] . ' (' . $courses['qualification'] . ')' ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputName">Select time</label>
                        <select name="schedule" id="schedule" class="form-control">
                            <?php while ($schedules = mysqli_fetch_array($schedule_records)) { ?>
                                <option <?= ($joined_courses['schedule'] == $schedules['schedule_id']) ? 'selected' : ''; ?> value="<?= $schedules['schedule_id'] ?>"><?= $schedules['start_time'] . ' - ' . $schedules['end_time']  ?></option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="form-group col-md-12">
                        <button class="btn btn-success" name="edit">Update course</button>
                    </div>
                </form>



            </div>
        </div>

        <hr>



    </div>


</div>

<?php
include 'includes/footer.php';
?>
<link href='../assets/datatables/jquery.dataTables.min.css' rel='stylesheet'>
<script src="../assets/datatables/jquery.dataTables.min.js"></script>


<script>
    $('.select2').select2();
</script>