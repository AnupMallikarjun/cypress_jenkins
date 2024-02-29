
<?php

	include('config/db_connect.php');

	$app_id = $password = $feedback = $ratings = '';
	$errors = array('app_id' => '', 'password' => '', 'feedback' => '', 'ratings' => '');

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

		// check feedback
		if(empty($_POST['feedback'])){
			$errors['feedback'] = 'Feedback cannot be empty';
		} else{
			$feedback = $_POST['feedback'];
		}

		// check ratings
		if(empty($_POST['ratings'])){
			$errors['ratings'] = 'Ratings cannot be empty';
		} else{
			$ratings = $_POST['ratings'];
		}


		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$app_id = mysqli_real_escape_string($conn, $_POST['app_id']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
			$ratings = mysqli_real_escape_string($conn, $_POST['ratings']);
			$ratings = intval($ratings);

			// query to retrieve password
			$sql = "SELECT S_password from student WHERE app_id='$app_id'";

			// get the query result
			$result = mysqli_query($conn, $sql);

			// fetch result in array format
			$pass = mysqli_fetch_assoc($result);	

			// verify entered password
			if ($pass['S_password'] == $password){
				// query to insert feedback
				$sql = "INSERT INTO feedback VALUES ('$app_id','$feedback', $ratings)";

				if (mysqli_query($conn, $sql)){
					header('Location: index.php');
				} else {
					// $errors['query'] = 'Failed to insert feedback';
				}

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
		<h4 class="center"><b>Feedback</b></h4>
		<form class="blue lighten-4" action="feedback.php" method="POST">
			<label style="color:blue">Application ID</label>
			<input type="text" name="app_id" value="<?php echo htmlspecialchars($app_id); ?>">
			<div class="red-text"><?php echo $errors['app_id']; ?></div>
			<label style="color:blue">Password</label>
			<input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
			<div class="red-text"><?php echo $errors['password']; ?></div>
			<label style="color:blue">Feedback</label>
			<input type="text" name="feedback" value="<?php echo htmlspecialchars($feedback); ?>">
			<div class="red-text"><?php echo $errors['feedback']; ?></div>
			<label style="color:blue">Ratings [out of 10]</label>
			<input type="number" name="ratings" min="1" max="10" value="<?php echo htmlspecialchars($ratings); ?>">
			<div class="red-text"><?php echo $errors['ratings']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>