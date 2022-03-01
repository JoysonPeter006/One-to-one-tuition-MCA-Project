<?php

	// Connect to database
	$con = mysqli_connect("localhost","root","","registration");
	
	// mysqli_connect("servername","username","password","database_name")

	// Get all the categories from category table
	$sql = "SELECT * FROM courselist";
	$all_categories = mysqli_query($con,$sql);

	// The following code checks if the submit button is clicked
	// and inserts the data in the database accordingly
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">	
</head>
<body>
	<form method="POST"><!--
		<label>select your course:</label>
		<input type="text" name="Product_name" required>--><br>
		<label>select your course:</label>
		<select name="Category">
			<?php
				// use a while loop to fetch data
				// from the $all_categories variable
				// and individually display as an option
				while ($category = mysqli_fetch_array(
						$all_categories,MYSQLI_ASSOC)):;
			?>
				<option value="<?php echo $category["course_id"];
					// The value we usually set is the primary key
				?>">
				<option value="<?php echo $category["course_name"];
						// To show the category name to the user
					?>
				</option>
			<?php
				endwhile;
				// While loop must be terminated
			?>
		</select>
		<br>
		<input type="submit" value="submit" name="submit">
        

        <?php
        if(isset($_POST['submit']))
	{
		?><div class="home-content">
      <center>
      <table border="2">
  <tr>
    <td>te_id</td>
    <td>name</td>
  </tr><?php
		// Store the Category ID in a "id" variable
		$course = mysqli_real_escape_string($con,$_POST['Category']);
		//echo $course;
		// Creating an insert query using SQL syntax and
		// storing it in a variable.
		$sql_search ="select te_id,te_name from teacher where course='".$course."'";
		//$sql_search ="select te_id,te_name from teacher where course1='".$course."' or course2='".$course."' or course3='".$course."'";
		while($data = mysqli_fetch_array($sql_search))
{
?>
  <tr>
    <td><?php echo $data['te_id']; ?></td>
    <td><?php echo $data['te_name']; ?></td>
  </tr>	
<?php
}}
?>
</table>
</center>
	
	</form>
	<br>
</body>
</html>
