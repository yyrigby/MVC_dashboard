<!DOCTYPE html>
<head>
	<title>User Dashboard</title>
</head>
<body>
	<div class="wrapper">
		<h3 class="inline-block">All Users</h3>
		<table class="table talbe-striped table-hover table-condensed">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Created At</th>
				<th>User Level</th>
			</thead>
			<tbody>
				<?= $table ?>
			</tbody>
	</div>
</body>
</html>