<?php
include 'includes/header.php';

?>

<?php



$course_qry = 'SELECT teacher.te_name,teacher.qualification,courselist.* from courselist LEFT JOIN teacher on teacher.te_id = courselist.teacher_id where courselist.salary_status=1';
$course_records = mysqli_query($db, $course_qry);

$schedule_qry = 'SELECT * from schedules';
$schedule_records = mysqli_query($db, $schedule_qry);


$err_msg = $succ_msg = '';
if (isset($_POST['add'])) {
    $course_id = $_POST['course_id'];
    $schedule = $_POST['schedule'];
    $course_status = 1;

    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';
    $err_msg .= (empty($schedule)) ? '<p>Please select a time</p>' : '';

    $schedule_check_query = "SELECT teacher.* FROM courselist 
    LEFT JOIN teacher on teacher.te_id = courselist.teacher_id 
    LEFT JOIN courses on courses.courselist_id = courselist.course_id
    WHERE courselist.course_id = '$course_id' AND courses.schedule = '$schedule'";
    $result = mysqli_query($db, $schedule_check_query);
    $schedules = mysqli_fetch_assoc($result);
  
    if ($schedules) { // if user exists
       
            $err_msg .= '<p>selected time schedule is already engaged</p>';
            
        
    }
    else{

    if (strlen($err_msg) == 0) {
        $insert_course = "INSERT INTO courses (courselist_id, student_id,schedule, course_status) VALUES ($course_id,$student_id,$schedule,$course_status)";
        $insert_result = mysqli_query($db, $insert_course);

        if ($insert_result)
            $succ_msg = "<p>Successfully added course</p>";
        else
            $err_msg = "<p>Could not add course</p>";
    }}
}

$joinedcourses_qry = "SELECT courses.course_id,courselist.experience,schedules.start_time,schedules.end_time,teacher.te_name,teacher.qualification,courselist.course_name
from courses 
LEFT JOIN student on student.id = courses.student_id
LEFT JOIN courselist on courselist.course_id = courses.courselist_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
LEFT JOIN schedules on schedules.schedule_id = courses.schedule
where courses.student_id =  $student_id and courses.course_status = 1";

$joinedcourses_records = mysqli_query($db, $joinedcourses_qry);



?>

<div class="home-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php include 'includes/messages.php'; ?>


                <form method="post" action="">

                    <div class="form-group col-md-6">
                        <label for="inputName">Select course(teacher and rate/hour is given)</label>
                        <select name="course_id" id="course_id" class="select2 form-control">
                            <?php while ($courses = mysqli_fetch_array($course_records)) { ?>
                                <option value="<?= $courses['course_id'] ?>"><?= $courses['course_name'] . ' - ' . $courses['te_name'] . ' (' . $courses['qualification'] . ')      - Rs ' .$courses['rate'] ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputName">Select time</label>
                        <select name="schedule" id="schedule" class="form-control">
                            <?php while ($schedules = mysqli_fetch_array($schedule_records)) { ?>
                                <option value="<?= $schedules['schedule_id'] ?>"><?= $schedules['start_time'] . ' - ' . $schedules['end_time']  ?></option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="form-group col-md-12">
                        <button class="btn btn-success" name="add">Add course</button>
                    </div>
                </form>



            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-10">

                <h4>Your Pending Courses</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Teacher & Qualification</th>
                            <th>Schedule</th>
                            <th>Experience</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($joinedcourses = mysqli_fetch_array($joinedcourses_records)) {
                            $id = $joinedcourses['course_id'];
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $joinedcourses['course_name'] ?></td>
                                <td><?= $joinedcourses['te_name'] . ' - ' . $joinedcourses['qualification'] ?></td>
                                <td><?= $joinedcourses['start_time'] . ' - ' . $joinedcourses['end_time'] ?></td>
                                <td><?= $joinedcourses['experience'] ?></td>

                                <td>
                                    <a href="edit_courses.php?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="delete_courses.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete ?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <h5><center>Note: If your selected course and choosen teacher is not showing in Pending courses,it means the choosen teacher is not qualified well enough to teach this course or he/she may be engaged during the selected time period.So please choose a different teacher in that case</center</h5>

    </div>


</div>

<?php
include 'includes/footer.php';
?>
<link href='../assets/datatables/jquery.dataTables.min.css' rel='stylesheet'>
<script src="../assets/datatables/jquery.dataTables.min.js"></script>


<script>
    $('.select2').select2();

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