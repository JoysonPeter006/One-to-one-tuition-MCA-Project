<?php
include 'includes/header.php';
?>

<?php


$err_msg = $succ_msg = '';

if (isset($_POST['edit'])) {
    $feedback_id = $_POST['feedback_id'];
    $remarks_by_admin = $_POST['remarks_by_admin'];

    $err_msg .= (empty($feedback_id)) ? '<p>Please select a feedback</p>' : '';
    $err_msg .= (empty($remarks_by_admin)) ? '<p>Please enter any remarks</p>' : '';

    if (strlen($err_msg) == 0) {
        $update_feedback = "UPDATE feedbacks set remarks_by_admin = '$remarks_by_admin',feedback_status = 2 where feedback_id = $feedback_id";
        $update_result = mysqli_query($db, $update_feedback);

        if ($update_result)
            $succ_msg = "<p>Successfully added feedback</p>";
        else
            $err_msg = "<p>Could not add feedback</p>";
    }
}


$feedback_qry = "SELECT feedbacks.feedback_id,feedbacks.feedback,feedbacks.remarks_by_admin,student.fullname,courselist.course_name,teacher.te_name FROM feedbacks 
LEFT JOIN courselist on courselist.course_id = feedbacks.course_id
LEFT JOIN student on student.id = feedbacks.student_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id
where feedback_status=1";

$feedback_records = mysqli_query($db, $feedback_qry);


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
                <h4>Feedbacks</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th>Feedback</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($feedbacks = mysqli_fetch_array($feedback_records)) {
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $feedbacks['fullname'] ?></td>
                                <td><?= $feedbacks['course_name'] ?></td>
                                <td><?= $feedbacks['te_name'] ?></td>
                                <td><?= $feedbacks['feedback'] ?></td>
                                <td>

                                    <form method="post">
                                        <textarea name="remarks_by_admin" id="remarks_by_admin"><?= $feedbacks['remarks_by_admin'] ?></textarea>

                                        <input type="hidden" name="feedback_id" value="<?= $feedbacks['feedback_id'] ?>">
                                        <button class="btn btn-sm btn-primary" name="edit">Edit</button>
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