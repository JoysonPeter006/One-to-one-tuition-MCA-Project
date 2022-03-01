<?php
include 'includes/header.php';
?>

<?php

$err_msg = $succ_msg = '';
if (isset($_POST['approve'])) {
    $course_id = $_POST['course_id'];
    $link = $_POST['link'];
    $month=$_POST['month'];
    $dt=$_POST['dt'];
    $year=$_POST['year'];
    $start_date="$month-$dt-$year";
    $err_msg .= (empty($course_id)) ? '<p>Please select a course</p>' : '';

    if (strlen($err_msg) == 0) {
        $update_course = "UPDATE courses set course_status = 2 where course_id = $course_id";
        $update_result = mysqli_query($db, $update_course);
        $update_course_link = "UPDATE courses set class_link='$link' where course_id = $course_id";
        $update_result_link = mysqli_query($db, $update_course_link);
        $update_course_start = "UPDATE courses set start_date='$start_date' where course_id = $course_id";
        $update_result_start = mysqli_query($db, $update_course_start);
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
                                    <label for="inputName">Add link</label>
                                    <input type="text" name="link" id="link" class="form-control">
                    

                                        <input type="hidden" name="course_id" value="<?= $pendingcourses['course_id'] ?>">
<input type=hidden name=todo value="Start date">

<table border="0" cellspacing="0">
<h4>Start date</h4>
<tr><td  align=left  >   

Select Month<select name="month">
<option value='01'>January</option>
<option value='02'>February</option>
<option value='03'>March</option>
<option value='04'>April</option>
<option value='05'>May</option>
<option value='06'>June</option>
<option value='07'>July</option>
<option value='08'>August</option>
<option value='09'>September</option>
<option value='10'>October</option>
<option value='11'>November</option>
<option value='12'>December</option>
</select>



</td><td  align=left  >   

Date<select name="dt" >

<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
</select>


</td><td  align=left  >   
Year(yyyy)<input type="text" name="year" size="4" value="2022">

</table>
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