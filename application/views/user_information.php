<!DOCTYPE html>
<head>
	<title>User Information</title>
</head>
<body>
	<div class="wrapper">
		<h3><?= $first_name . " " . $last_name ?></h3>
		<table id="info">
			<tbody>
				<tr>
					<td>Registered at:</td>
					<td><?= date('F jS, Y', strtotime($created_at)) ?></td>
				</tr>
				<tr>
					<td>User ID:</td>
					<td>#<?= $id ?></td>
				</tr>
				<tr>
					<td>Email Address</td>
					<td><?= $email ?></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td><?= $description ?></td>
				</tr>
			</tbody>
		</table>
		<h4>Leave a message for <?= $first_name ?></h4>
		<form class="leave_message" action="/message/leave_message" method="post">
			<textarea name="content" class="leave_message"></textarea>
			<input type="submit" class="btn_green" value="Post">
			<input type="hidden" name="profile_id" value="<?= $id ?>">
		</form>
		<?= $messages ?>
	</div>
</body>
</html>