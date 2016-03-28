<!DOCTYPE html>
<head>
	<title>New User</title>
</head>
<body>
	<div class="wrapper">
		<h3>Add a new user</h3>
<?php
	if($this->session->flashdata('error')){
		echo "<div class='error'>" . $this->session->flashdata('error') . "</div>";
	}
	if($this->session->flashdata('confirm')){
		echo "<div class='confirm'>" . $this->session->flashdata('confirm') . "</div>";
	}
?>
		<a href="/dashboard/admin"><button class="btn_blue">Return to Dashboard</button></a>
		<form action="/users/admin_register" method="post">
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
	</div>
</body>
</html>