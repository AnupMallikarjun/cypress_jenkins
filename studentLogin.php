<?php

	include('config/db_connect.php');

	$app_id = $password = '';
	$errors = array('app_id' => '', 'password' => '');

	if(isset($_POST['submit'])){
		
		// check Phone Number
		if(empty($_POST['app_id'])){
			$errors['app_id'] = 'Application ID is required';
		} else{
			$app_id = $_POST['app_id'];
		}

		// check Password
		if(empty($_POST['password'])){
			$errors['password'] = 'Password is required';
		} else{
			$password = $_POST['password'];
		}


		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$app_id = mysqli_real_escape_string($conn, $_POST['app_id']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);

			// create sql
			$sql = "SELECT S_password from student WHERE app_id='$app_id'";

			// get the query result
			$result = mysqli_query($conn, $sql);

			// fetch result in array format
			$pass = mysqli_fetch_assoc($result);	

			if ($pass['S_password'] == $password){
				session_start();
				$_SESSION['app_id'] = $app_id;
				header('Location: studetail.php');
			} else {
				$errors['password'] = 'Wrong Password';
			}


			mysqli_free_result($result);
			mysqli_close($conn);
		
			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container black-text">
		<h4 class="center">Student Login</h4>
		<form class="blue lighten-4" action="studentLogin.php" method="POST">
			<label style="color:blue">Application ID</label>
			<input type="text" name="app_id" value="<?php echo htmlspecialchars($app_id) ?>">
			<div class="red-text"><?php echo $errors['app_id']; ?></div>
			<label style="color:blue">Password</label>
			<input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
			<div class="red-text"><?php echo $errors['password']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>