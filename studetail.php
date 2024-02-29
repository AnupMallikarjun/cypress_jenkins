<?php 
	include('config/db_connect.php');

	session_start();

	// check GET request id param
	if($_SESSION['app_id']){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_SESSION['app_id']);

		// make sql
		$sql = "SELECT * FROM application WHERE app_id = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$app = mysqli_fetch_assoc($result);

	}

	session_unset();
	session_destroy();

?>

<!DOCTYPE html>
<html>

	<?php include('templates/logout.php'); ?>

	<div class="container center">
		<?php if($app): ?>
			<h4>Application ID&#58;<?php echo $app['app_id']; ?></h4>
			<p>Name&#58; <?php echo $app['s_name']; ?></p>
			<p>College Code&#58; <?php echo $app['c_code']; ?></p>
			<p>Aadhar&#58; <?php echo $app['aadhar']; ?></p>
			<p>USN&#58; <?php echo $app['reg_no']; ?></p>
			<p>Previous Year &#37;&#58; <?php echo $app['prev_year_perc']; ?></p>
			<h5>Status&#58; <?php echo $app['status']; ?></h5>

		<?php else: ?>
			<h5>No such student exists.</h5>
		<?php endif ?>
	</div>

	<?php include('templates/footer.php'); ?>

</html>