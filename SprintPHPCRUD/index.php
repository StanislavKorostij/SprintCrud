<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP CRUD</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>

<body>
	<?php require_once 'processWorkers.php';
	require_once 'processProjects.php';
	$path = $_GET['path'] == '' ? 'workers' : $_GET['path'];
	?>

	<?php

	if (isset($_SESSION['message'])) : ?>

		<div class="alert alert-<?= $_SESSION['msg_type'] ?>">

			<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);
			?>

		</div>
	<?php endif; ?>

	<?php
	$mysqli = new mysqli('localhost', 'root', 'mysql', 'crud') or die(mysqli_error($mysqli));
	$resultWorkers = $mysqli->query("SELECT * FROM $path") or die($mysqli->error);
	$resultProjects = $mysqli->query("SELECT * FROM projects JOIN workers ON projects.id = workers.id WHERE projects.project = workers.project") or die($mysqli->error);
	?>
	<div style="width: 30%; margin: 0 auto;">
		<ul id="myTab" class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link" href="?path=workers">Workers</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="?path=projects">Projects</a>
			</li>
		</ul>
		<table class="border table align-middle table-striped table-hover">
			<thead>
				<tr>
					<th><?php ($_GET['path'] == 'projects') ? print 'Project' : print 'Name'; ?></th>
					<th><?php ($_GET['path'] == 'projects') ? print 'Name' : print 'Project'; ?></th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>
			<?php while ($row = $resultWorkers->fetch_assoc()) : ?>
				<tr>
					<td><?php ($_GET['path'] == 'projects') ? print $row['PROJECT'] : print $row['NAME']; ?></td>
					<td><?php ($_GET['path'] == 'projects') ? print $row['NAME'] : print $row['PROJECT'];  ?></td>
					<td>
						<a href="index.php?edit=<?php echo $row['ID']; ?>" class="btn btn-info">Edit</a>
						<a href="processWorkers.php?delete=<?php echo $row['ID']; ?>" class="btn btn-danger">Delete</a>
					</td>
				</tr>
			<?php endwhile; ?>
		</table>
	</div>

	<div style="width: 20%; margin: 0 auto;">
		<form action="<?php ($_GET['path'] == 'projects') ? 'processProjects.php' : 'processWorkers.php'  ?>" method="POST">
			<input type="hidden" name="id" value="<?php echo $id; ?>"></input>
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Enter your name">
			</div>
			<div class="form-group">
				<label>Project</label>
				<input type="text" name="project" class="form-control" value="<?php echo $project; ?>" placeholder="Enter your project">
			</div>
			<div class="form-group">
				<?php if ($update == true) : ?>
					<button type="submit" class="btn btn-info" name="update">Update</button>
				<?php else : ?>
					<button type="submit" class="btn btn-primary" name="save">Save</button>
				<?php endif; ?>
			</div>
		</form>
	</div>
</body>

</html>