<!DOCTYPE html>
<head>
	<title>Admin Dashboard</title>
</head>
<body>
	<div class="wrapper">
		<h3>Manage Users</h3>
		<a href="/users/new"><button class="btn_blue">Add New</button></a>
		<table class="table talbe-striped table-hover table-condensed">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Created At</th>
				<th>User Level</th>
				<th>Actions</th>
			</thead>
			<tbody>
				<?= $table ?>
			</tbody>
		</table>
	</div>
</body>
</html>