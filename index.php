<?php

	include('config/db_connect.php');

	$phno = $password = $c_code = $s_name = $aadhar = $reg_no = $prev_year_perc = $ifsc = $acc_no = $b_name = '';
	$errors = array('phno' => '', 'password' => '', 'c_code' => '', 's_name' => '',
					'aadhar' => '', 'reg_no' => '', 'prev_year_perc' => '',
					'ifsc' => '', 'acc_no' => '', 'b_name' => '');

	if(isset($_POST['submit'])){
		
		// check Phone Number
		if(empty($_POST['phno'])){
			$errors['phno'] = 'Phone Number is required';
		} else{
			$phno = $_POST['phno'];
		}

		// check Password
		if(empty($_POST['password'])){
			$errors['password'] = 'Password is required';
		} else{
			$password = $_POST['password'];
		}

		// check college code
		if(empty($_POST['c_code'])){
			$errors['c_code'] = 'College code is required';
		} else{
			$c_code = $_POST['c_code'];
		}

		// check student name
		if(empty($_POST['s_name'])){
			$errors['s_name'] = 'Student name is required';
		} else{
			$s_name = $_POST['s_name'];
		}

		// check aadhar
		if(empty($_POST['aadhar'])){
			$errors['aadhar'] = 'Aadhar Number is required';
		} elseif (strlen($aadhar = $_POST['aadhar']) != 12) {
			$errors['aadhar'] = 'Please enter 12 digit Number';
		} else{
			$aadhar = $_POST['aadhar'];
		}

		// check Reg no
		if(empty($_POST['reg_no'])){
			$errors['reg_no'] = 'USN is required';
		} else{
			$reg_no = $_POST['reg_no'];
		}

		// check prev year perc
		if(empty($_POST['prev_year_perc'])){
			$errors['prev_year_perc'] = 'Required';
		} else{
			$prev_year_perc = $_POST['prev_year_perc'];
		}

		// check ifsc
		if(empty($_POST['ifsc'])){
			$errors['ifsc'] = 'IFSC code is required';
		} else{
			$ifsc = $_POST['ifsc'];
		}

		// check acc_no
		if(empty($_POST['acc_no'])){
			$errors['acc_no'] = 'Account Number is required';
		} else{
			$acc_no = $_POST['acc_no'];
		}

		// check b_name
		if(empty($_POST['b_name'])){
			$errors['b_name'] = 'Bank Name is required';
		} else{
			$b_name = $_POST['b_name'];
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$phno = mysqli_real_escape_string($conn, $_POST['phno']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$c_code = mysqli_real_escape_string($conn, $_POST['c_code']);
			$s_name = mysqli_real_escape_string($conn, $_POST['s_name']);
			$aadhar = mysqli_real_escape_string($conn, $_POST['aadhar']);
			$reg_no = mysqli_real_escape_string($conn, $_POST['reg_no']);
			$prev_year_perc = mysqli_real_escape_string($conn, $_POST['prev_year_perc']);
			$ifsc = mysqli_real_escape_string($conn, $_POST['ifsc']);
			$acc_no = mysqli_real_escape_string($conn, $_POST['acc_no']);
			$b_name = mysqli_real_escape_string($conn, $_POST['b_name']);
			$app_id = time();

			// query to insert student
			$sql = "INSERT INTO student VALUES ('$app_id', '$phno', '$password')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

			$sql = "INSERT INTO application VALUES('$app_id', '$c_code', '$s_name', '$aadhar', '$reg_no', '$prev_year_perc', 'Application Submitted')";

			if(mysqli_query($conn, $sql)){
				
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

			$sql = "INSERT INTO bank_detail VALUES('$app_id', '$ifsc', '$acc_no', '$b_name')";

			if(mysqli_query($conn, $sql)){
				// success
				session_start();
				$_SESSION['app_id'] = $app_id;
				header('Location: studetail.php');
			} else {
				echo 'query error: ' . mysqli_error($conn);
			}
			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container black-text">
		<h4 class="center">STUDENT Sign up</h4>
		<form class="blue lighten-4" action="index.php" method="POST">
			<label style="color:blue">Phone Number</label>
			<input type="text" name="phno" value="<?php echo htmlspecialchars($phno) ?>">
			<div class="red-text"><?php echo $errors['phno']; ?></div>
			<label style="color:blue">Password</label>
			<input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
			<div class="red-text"><?php echo $errors['password']; ?></div>
			<label style="color:blue">College Code</label>
			<input type="text" name="c_code" value="<?php echo htmlspecialchars($c_code) ?>">
			<div class="red-text"><?php echo $errors['c_code']; ?></div>
			<label style="color:blue">Student Name</label>
			<input type="text" name="s_name" value="<?php echo htmlspecialchars($s_name) ?>">
			<div class="red-text"><?php echo $errors['s_name']; ?></div>
			<label style="color:blue">Aadhar ID [ only numbers ]</label>
			<input type="text" name="aadhar" value="<?php echo htmlspecialchars($aadhar) ?>">
			<div class="red-text"><?php echo $errors['aadhar']; ?></div>
			<label style="color:blue">USN</label>
			<input type="text" name="reg_no" value="<?php echo htmlspecialchars($reg_no) ?>">
			<div class="red-text"><?php echo $errors['reg_no']; ?></div>
			<label style="color:blue">Previous Year Percentage</label>
			<input type="text" name="prev_year_perc" value="<?php echo htmlspecialchars($prev_year_perc) ?>">
			<div class="red-text"><?php echo $errors['prev_year_perc']; ?></div>
			<label style="color:blue">IFSC</label>
			<input type="text" name="ifsc" value="<?php echo htmlspecialchars($ifsc) ?>">
			<div class="red-text"><?php echo $errors['ifsc']; ?></div>
			<label style="color:blue">Account Number</label>
			<input type="text" name="acc_no" value="<?php echo htmlspecialchars($acc_no) ?>">
			<div class="red-text"><?php echo $errors['acc_no']; ?></div>
			<label style="color:blue">Bank Name</label>
			<input type="text" name="b_name" value="<?php echo htmlspecialchars($b_name) ?>">
			<div class="red-text"><?php echo $errors['b_name']; ?></div>
			
			

			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>