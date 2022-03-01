<?php
include 'includes/header.php';
?>

<?php
$err_msg = $succ_msg = '';
if (isset($_POST['edit'])) {
    $course_id = $_POST['course_id'];
    $salary_by_admin = $_POST['salary_by_admin'];

    $err_msg .= (empty($course_id)) ? '<p>Please select a feedback</p>' : '';
    $err_msg .= (empty($salary_by_admin)) ? '<p>Please enter any remarks</p>' : '';

    if (strlen($err_msg) == 0) {
        $update_salary = "UPDATE courselist set rate = '$salary_by_admin',salary_status=1 where course_id = $course_id and salary_status=2";
        $update_result = mysqli_query($db, $update_salary);

        if ($update_result)
            $succ_msg = "<p>Successfully added salary</p>";
        else
            $err_msg = "<p>Could not add salary</p>";
    }
}

$joinedcourses_qry = "SELECT courselist.*,teacher.te_name from courselist left join teacher on teacher.te_id=courselist.teacher_id where courselist.salary_status=2";
$joinedcourses_records = mysqli_query($db, $joinedcourses_qry);
?>

<div class="home-content">
<div class="container">
<div class="row">
            <div class="col-md-10">

                <h4>Added Courses by Teachers</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Teacher name</th>
                            <th>Experience</th>
                            <th>Rate per hour</th>
                            <th>Action</th>

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
                                <td><?= $joinedcourses['te_name'] ?></td>
                                <td><?= $joinedcourses['experience'] ?></td>
                                <td><?= $joinedcourses['rate'] ?></td>
                                <td>

                                    <form method="post">
                                        <textarea name="salary_by_admin" id="salary_by_admin"><?= $joinedcourses['rate'] ?></textarea>

                                        <input type="hidden" name="course_id" value="<?= $joinedcourses['course_id'] ?>">
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