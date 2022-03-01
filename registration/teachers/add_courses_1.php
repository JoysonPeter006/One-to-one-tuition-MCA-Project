<?php
include 'includes/header.php';
?>

<?php

$course_qry = 'SELECT teacher.te_name,teacher.qualification,courselist.* from courselist LEFT JOIN teacher on teacher.te_id = courselist.teacher_id';
$course_records = mysqli_query($db, $course_qry);

$schedule_qry = 'SELECT * from schedules';
$schedule_records = mysqli_query($db, $schedule_qry);


$err_msg = $succ_msg = '';
if(isset($_POST['add']))
{    
     
 $file = rand(1000,100000).".jpeg";
 $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="../uploads/";
 move_uploaded_file($file_loc,$folder.$file);


 $course_name = $_POST['course_name'];
    $experience = $_POST['experience'];
    $rate = $_POST['rate'];
    $experience_file = $file;
    $course_status = 1;

    $err_msg .= (empty($course_name)) ? '<p>Please enter a course</p>' : '';
    $err_msg .= (empty($experience)) ? '<p>Please enter a experience</p>' : '';
    $err_msg .= (empty($rate)) ? '<p>Please enter a rate per hour</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_course = "INSERT INTO courselist (course_name,experience, teacher_id,rate,salary_status,experience_file) VALUES ('$course_name','$experience',$teacher_id,$rate,2,'$experience_file')";
        $insert_result = mysqli_query($db, $insert_course);

        if ($insert_result)
            $succ_msg = "<p>Successfully added course</p>";
        else
            $err_msg = "<p>Could not add course</p>";
    }
}
// if (isset($_POST['add_old'])) {
//     $course_name = $_POST['course_name'];
//     $experience = $_POST['experience'];
//     $rate = $_POST['rate'];
//     $course_status = 1;
//     $salary_status = 2;

//     $err_msg .= (empty($course_name)) ? '<p>Please enter a course</p>' : '';
//     $err_msg .= (empty($experience)) ? '<p>Please enter a experience</p>' : '';
//     $err_msg .= (empty($rate)) ? '<p>Please enter a rate per hour</p>' : '';

//     if (strlen($err_msg) == 0) {
//         $insert_course = "INSERT INTO courselist (course_name,experience, teacher_id,rate,salary_status,file,type,size) VALUES ('$course_name','$experience',$teacher_id,$rate,$salary_status,'$file','$file_type','$file_size')";
//         $insert_result = mysqli_query($db, $insert_course);

//         if ($insert_result)
//             $succ_msg = "<p>Successfully added course</p>";
//         else
//             $err_msg = "<p>Could not add course</p>";
//     }
// }

$joinedcourses_qry = "SELECT * from courselist where teacher_id = $teacher_id";

$joinedcourses_records = mysqli_query($db, $joinedcourses_qry);



?>

<div class="home-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php include 'includes/messages.php'; ?>


                <form method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="inputName">Course name</label>
                        <input type="text" name="course_name" id="course_name" class="form-control">
                        
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputName">Course experience</label>
                        <input type="text" name="experience" id="experience" class="form-control">
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputName">Rate per hour</label>
                        <input type="text" name="rate" id="rate" class="form-control">
                        
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputName">Add course experience id</label>
                    <input type="file" name="file" /><br>
                        
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

                <h4>Your Added Courses</h4>
                <table id="fa_datatable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Experience</th>
                            <th>Rate per hour</th>
                            
                            <th>ID</th>

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
                                <td><?= $joinedcourses['experience'] ?></td>
                                <td><?= $joinedcourses['rate'] ?></td>
                                <td> 
                                    <a target="_blank" href="../uploads/<?= $joinedcourses['experience_file'] ?>">View</a>
                                 </td>
                               
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div><br>
        <h5><center>Note: Provide the rate per hour within the range 200 and 500</center</h5>

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