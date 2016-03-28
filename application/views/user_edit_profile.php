<!DOCTYPE html>
<head>
	<title>Edit Profile</title>
</head>
<body>
	<div class="wrapper">
		<h3>Edit Profile</h3>
		<div class="edit_box">
			<h5>Edit Information</h5>
<?php
			if($this->session->flashdata('error_info') == TRUE){
				echo "<div class='error'>" . $this->session->flashdata('error_info') . "</div>";
			}
			if($this->session->flashdata('confirm_info') == TRUE){
				echo "<div class='confirm'>" . $this->session->flashdata('confirm_info') . "</div>";
			}
?>
			<form action="/users/edit_info" method="post">
				<label>Email Address:</label>
				<input type="text" name="email" value="<?= $this->session->userdata('email') ?>">
				<label>First Name:</label>
				<input type="text" name="first_name" value="<?= $this->session->userdata('first_name') ?>">
				<label>Last Name:</label>
				<input type="text" name="last_name" value="<?= $this->session->userdata('last_name') ?>">
				<input type="submit" class="btn_green" value="Save">
				<input type="hidden" name="edit_type" value="info">
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
			<form action="/users/update_password" method="post">
				<label>Password:</label>
				<input type="password" name="password">
				<label>Password Confirmation:</label>
				<input type="password" name="confirm_password">
				<input type="submit" class="btn_green" value="Update Password">
				<input type="hidden" name="edit_type" value="password">
			</form>
		</div>
		<div class="edit_description_box">
			<h5>Edit Description</h5>
<?php
			if($this->session->flashdata('confirm_description')){
				echo "<div class='confirm'>" . $this->session->flashdata('confirm_description') . "</div>";
			}
?>
			<form class="description" action="/users/edit_description" method="post">
				<textarea name="description" id="description"><?= $this->session->userdata('description') ?></textarea>
				<input type="submit" class="btn_green" value="Save">
				<input type="hidden" name="edit_type" value="description">
			</form>
		</div>
	</div>
</body>
</html>