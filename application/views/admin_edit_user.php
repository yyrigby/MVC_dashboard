<!DOCTYPE html>
<head>
	<title>Edit User</title>
</head>
<body>
	<div class="wrapper">
		<h3>Edit user #<?= $id ?></h3>
		<a href="/dashboard/admin"><button class="btn_blue">Return to Dashboard</button></a>
		<div class="edit_box">
			<h5>Edit Information</h5>
<?php
			if($this->session->flashdata('error_info')){
				echo "<div class='error'>" . $this->session->flashdata('error_info') . "</div>";
			}
			if($this->session->flashdata('confirm_info')){
				echo "<div class='confirm'>" . $this->session->flashdata('confirm_info') . "</div>";
			}
?>
			<form action="/admin/edit_info" method="post">
				<label>Email Address:</label>
				<input type="text" name="email" value="<?= $email ?>">
				<label>First Name:</label>
				<input type="text" name="first_name" value="<?= $first_name ?>">
				<label>Last Name:</label>
				<input type="text" name="last_name" value="<?= $last_name ?>">
				<label>User Level:</label>
				<select name="user_level" class="dropdown">
					<option value="9" <?php if($user_level==9){echo "selected";}?>>Admin</option>
					<option value="1" <?php if($user_level==1){echo "selected";}?>>Normal</option>
				</select>
				<input type="submit" class="btn_green" value="Save">
				<input type="hidden" name="user_id" value="<?= $id ?>">
			</form>
		</div>
		<div class="edit_box">
			<h5>Change Password</h5>
<?php
			if($this->session->flashdata('error_password')){
				echo "<div class='error'>" . $this->session->flashdata('error_password') . "</div>";
			}
			if($this->session->flashdata('confirm_password')){
				echo "<div class='confirm'>" . $this->session->flashdata('confirm_password') . "</div>";
			}
?>
			<form action="/admin/update_password" method="post">
				<label>Password:</label>
				<input type="password" name="password">
				<label>Password Confirmation:</label>
				<input type="password" name="confirm_password">
				<input type="submit" class="btn_green" value="Update Password">
				<input type="hidden" name="user_id" value="<?= $id ?>">
			</form>
		</div>
	</div>
</body>
</html>