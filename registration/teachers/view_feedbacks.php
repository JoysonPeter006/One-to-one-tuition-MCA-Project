<?php
include 'includes/header.php';
?>

<?php


$err_msg = $succ_msg = '';


$feedback_qry = "SELECT feedbacks.feedback_id,feedbacks.feedback,feedbacks.remarks_by_admin,student.fullname,courselist.course_name,teacher.te_name FROM feedbacks 
LEFT JOIN courselist on courselist.course_id = feedbacks.course_id
LEFT JOIN student on student.id = feedbacks.student_id
LEFT JOIN teacher on teacher.te_id = courselist.teacher_id where feedbacks.feedback_status = 2 and teacher.te_id=$teacher_id";

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
                                
                                <td><?= $feedbacks['remarks_by_admin'] ?></td>
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