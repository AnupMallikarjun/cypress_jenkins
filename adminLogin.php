<?php

	include('config/db_connect.php');

	$u_name = $password = '';
	$errors = array('u_name' => '', 'password' => '');

	if(isset($_POST['submit'])){
		
		// check college code
		if(empty($_POST['u_name'])){
			$errors['u_name'] = 'Username is required';
		} else{
			$u_name = $_POST['u_name'];
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
			$u_name = mysqli_real_escape_string($conn, $_POST['u_name']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);

			// create sql
			$sql1 = "SELECT password from admin WHERE u_name ='$u_name'";
			$sql2 = "SELECT u_name from admin WHERE u_name='$u_name'";

			// get the query result for password
			$pass = mysqli_query($conn, $sql1);
			$c_user = mysqli_query($conn, $sql2);

			// fetch result in array format
			$pass_arr = mysqli_fetch_assoc($pass);
			$c_user_arr = mysqli_fetch_assoc($c_user);

			// check u_name
			if ($c_user_arr['u_name'] != $u_name) {
				$errors['u_name'] = 'No user found';
			}

			// check password
			if ($pass_arr['password'] == $password){
				header('Location: a_app.php');
			} else {
				$errors['password'] = 'Wrong Password';
			}

			// close sql connection
			mysqli_free_result($pass);
			mysqli_free_result($c_user);
			mysqli_close($conn);
		
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container black-text">
		<h4 class="center">Administrator</h4>
		<form class="blue lighten-4" action="adminLogin.php" method="POST">
			<label style="color:blue">Username</label>
			<input type="text" name="u_name" value="<?php echo htmlspecialchars($u_name) ?>">
			<div class="red-text"><?php echo $errors['u_name']; ?></div>
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