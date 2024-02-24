<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>E-commerce Database</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
	<div class="header1">
		<h2>Sign Up</h2>
	</div>

	<form method="post" action="register.php">
		<?php include('errors.php') ?>
		<div class="input-group">
			<label>Email:</label>
			<input type="email" name="email" required value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>First Name:</label>
			<input type="text" name="fname" required>
		</div>
		<div class="input-group">
			<label>Last Name:</label>
			<input type="text" name="lname" required>
		</div>
		<div class="input-group">
			<label>Phone No:</label>
			<input type="tel" name="phno" required>
		</div>
		<div class="input-group">
			<label>Passoword:</label>
			<input type="password" name="password" required>
		</div>
		<div class="input-group">
			<label>Confirm Password:</label>
			<input type="password" name="cpassword" required>
		</div>
		<div class="input-group">
			<label>Shipping Address:</label>
			<input type="text" name="sa" required>
		</div>
		<div class="input-group">
			<label>Billing Address:</label>
			<input type="text" name="ba">
		</div>
		<div class="input-group">
			<label>Country:</label>
			<input type="text" name="country" required>
		</div>
		<div class="input-group">
			<label>State:</label>
			<input type="text" name="state" required>
		</div>
		<div class="input-group">
			<label>City:</label>
			<input type="text" name="city" required>
		</div>
		<div class="input-group">
			<label>Street:</label>
			<input type="text" name="street" required>
		</div>
		<div class="input-group">
			<label>House No:</label>
			<input type="text" name="hno" required>
		</div>
		<div class="input-group">
			<label>Pin Code:</label>
			<input type="number" name="postal" required>
		</div>
		<div class="input-group">
			</center><button type="submit" name="register" class="btn">Register</button>
		</div>
		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
	</form>
</body>
</html>