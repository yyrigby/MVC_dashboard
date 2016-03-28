<!DOCTYPE html>
<head>
	<title>Signin Page</title>
</head>
<body>
	<div class="wrapper">
		<h3>Sign in</h3>
<?php
	if($this->session->flashdata('error')){
		echo "<div class='error'>" . $this->session->flashdata('error') . "</div>";
	}
?>
		<form action="/users/signin" method="post">
			<label>Email Address:</label>
			<input type="text" name="email">
			<label>Password:</label>
			<input type="password" name="password">
			<input type="submit" class="btn_green" value="Sign In">
		</form>
		<a href="/register">Don't have an account? Register.</a>
	</div>
</body>
</html>