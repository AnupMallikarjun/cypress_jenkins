
<?php

	include('config/db_connect.php');

	$c_code = $c_password = $c_name = '';
	$errors = array('c_code' => '', 'c_password' => '', 'c_name' => '', 'query' => '');

	// if pressed Delete
	if(isset($_POST['delete'])){

		// check c_code
		if(empty($_POST['c_code'])){
			$errors['c_code'] = 'College Code is required';
		} else {
			$c_code = $_POST['c_code'];
		}

		if(!(array_filter($errors))){
			// escape sql chars
			$c_code = mysqli_real_escape_string($conn, $_POST['c_code']);

			// query to delete
			$sql = "DELETE FROM college WHERE c_code='$c_code'";

			// check whether query executed successfully
			if(mysqli_query($conn, $sql)){
				// Do nothing for now
			} else{
				$errors['query'] = 'Unable to delete: ' . mysqli_error($conn);
			}
		}
	}

	// if pressed Add
	if(isset($_POST['add'])){

		// check c_code
		if(empty($_POST['c_code'])){
			$errors['c_code'] = 'College Code is required';
		} else {
			$c_code = $_POST['c_code'];
		}

		// check c_password
		if(empty($_POST['c_password'])){
			$errors['c_password'] = 'Password is required';
		} else {
			$c_password = $_POST['c_password'];
		}

		// check c_name
		if(empty($_POST['c_name'])){
			$errors['c_name'] = 'College Name is required';
		} else {
			$c_name = $_POST['c_name'];
		}

		// Check for errors
		if(array_filter($errors)){
			//print errors in the form
		} else {
			// escape sql chars
			$c_code = mysqli_real_escape_string($conn, $_POST['c_code']);
			$c_name = mysqli_real_escape_string($conn, $_POST['c_name']);
			$c_password = mysqli_real_escape_string($conn, $_POST['c_password']);

			// query to insert into college
			$sql = "INSERT INTO college VALUES ('$c_code','$c_name','$c_password')";

			// check whether the query executed without any error
			if(mysqli_query($conn, $sql)){
				// Do nothing
			} else{
				$errors['query'] = 'Unable to insert: ' . mysqli_error($conn);
			}
		}

	}

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/logout.php'); ?>

	<section class="container blue black-text">
		<h4 class="center"><b>Edit College</b></h4>

		<form class="blue lighten-4" action="a_college.php" method="POST">
			<label style="color:blue">College Code</label>
			<input type="text" name="c_code" value="<?php echo htmlspecialchars($c_code); ?>">
			<div class="red-text"><?php echo $errors['c_code']; ?></div>
			<label style="color:blue">c_Password</label>
			<input type="password" name="c_password" value="<?php echo htmlspecialchars($c_password); ?>">
			<div class="red-text"><?php echo $errors['c_password']; ?></div>
			<label style="color:blue">College Name</label>
			<input type="text" name="c_name" value="<?php echo htmlspecialchars($c_name); ?>">
			<div class="red-text"><?php echo $errors['c_name']; ?></div>

			<div class="center">
				<input type="submit" name="add" value="Add" class="btn brand z-depth-0">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>