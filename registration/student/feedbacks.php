<?php
include 'includes/header.php';
?>

<?php

$course_qry = "SELECT teacher.te_name,courselist.* from courselist LEFT JOIN teacher on teacher.te_id = courselist.teacher_id LEFT JOIN courses on courses.courselist_id = courselist.course_id where courses.student_id = $student_id";
$course_records = mysqli_query($db, $course_qry);


$err_msg = $succ_msg = '';
if (isset($_POST['add'])) {
    $course_id = $_POST['course_id'];
    $feedback = $_POST['feedback'];

    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';
    $err_msg .= (empty($feedback)) ? '<p>Please enter something</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_feedback = "INSERT INTO feedbacks (student_id, course_id, feedback) VALUES ($student_id, $course_id, '$feedback');";
        $insert_result = mysqli_query($db, $insert_feedback);

        if ($insert_result)
            $succ_msg = "<p>Successfully added feedback</p>";
        else
            $err_msg = "<p>Could not add feedback</p>";
    }
}


$feedback_qry = "SELECT feedbacks.feedback,feedbacks.feedback_status,student.fullname,courselist.course_name,teacher.te_name FROM feedbacks 
LEFT JOIN courselist on courselist.course_id = feedbacks.course_id
LEFT JOIN student on student.id = feedbacks.student_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id where feedbacks.student_id = $student_id";

$feedback_records = mysqli_query($db, $feedback_qry);


?>

<div class="home-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php include 'includes/messages.php'; ?>


                <form method="post" action="">
                    <div class="form-group col-md-6">
                        <label for="inputName">Select course</label>
                        <select name="course_id" id="course_id" class="select2 form-control">
                            <?php while ($courses = mysqli_fetch_array($course_records)) { ?>
                                <option value="<?= $courses['course_id'] ?>"><?= $courses['course_name'] . ' - ' . $courses['te_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputName">Your feedback</label>
                        <textarea name="feedback" id="feedback" class="form-control" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-success" name="add">Add feedback</button>
                    </div>
                </form>



            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-10">
                <h4>Your Feedbacks history</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course & Teacher</th>
                            <th>Feedback</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($feedbacks = mysqli_fetch_array($feedback_records)) {
                            $feedback_status = ($feedbacks['feedback_status'] == 1) ? 'Pending' : 'Approved';
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $feedbacks['course_name'] . ' - ' . $feedbacks['te_name'] ?></td>
                                <td><?= $feedbacks['feedback'] ?></td>
                                <td><span class="badge"><?= $feedback_status ?></span></td>
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

        $('.select2').select2();

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