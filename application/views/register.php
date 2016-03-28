<!DOCTYPE html>
<head>
	<title>Register</title>
</head>
<body>
	<div class="wrapper">
		<h3>Register</h3>
<?php
	if($this->session->flashdata('error')){
		echo "<div class='error'>" . $this->session->flashdata('error') . "</div>";
	}
?>
		<form action="/users/register" method="post">
			<label>Email Address:</label>
			<input type="text" name="email">
			<label>First Name:</label>
			<input type="text" name="first_name">
			<label>Last Name:</label>
			<input type="text" name="last_name">
			<label>Password:</label>
			<input type="password" name="password">
			<label>Password Confirmation:</label>
			<input type="password" name="confirm_password">
			<input type="submit" class="btn_green" value="Create">
		</form>
		<a href="/signin">Already have an account? Login.</a>
	</div>
</body>
</html>