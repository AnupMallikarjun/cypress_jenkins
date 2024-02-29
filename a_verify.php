
<?php 
	include('config/db_connect.php');

	if(isset($_POST['reject'])){

		$id_to_update = mysqli_real_escape_string($conn, $_POST['status_id']);

		// query
		$sql_dec = "UPDATE application SET status='Rejected' WHERE app_id='$id_to_update'";

		if(mysqli_query($conn, $sql_dec)){
			header('Location: a_app.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}


	}

	if(isset($_POST['sanction'])){

		$id_to_update = mysqli_real_escape_string($conn, $_POST['status_id']);

		$sql_ver = "UPDATE application SET status='Sanctioned' WHERE app_id='$id_to_update'";

		if(mysqli_query($conn, $sql_ver)){
			header('Location: a_app.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}
	}

	if(isset($_POST['app_id'])){

		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_POST['app_id']);

		// make sql
		$sql = "SELECT * FROM application WHERE app_id = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
		$app = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

	}



?>

<!DOCTYPE html>
<html>

	<?php include('templates/a_header.php'); ?>

	<div class="container center blue lighten-4">
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

	<div class="container center">
		<form action="a_verify.php" method="POST">
				<input type="hidden" name="status_id" value="<?php echo $app['app_id']; ?>">
				<input type="submit" name="reject" value="Reject" class="btn brand z-depth-0">
				<input type="submit" name="sanction" value="Sanction" class="btn brand z-depth-0">
		</form>
	</div>

	<?php include('templates/footer.php'); ?>

</html>