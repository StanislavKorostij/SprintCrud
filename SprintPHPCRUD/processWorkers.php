<?php

session_start();

$mysqli = new mysqli('localhost', 'root', 'mysql', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$project = '';

if (isset($_POST['save'])) {
	$name = $_POST['name'];
	$project = $_POST['project'];

	$mysqli->query("INSERT INTO workers (name, project) VALUES('$name', '$project')") or
		die($mysqli->error);

	$_SESSION['message'] = "New info has been saved!";
	$_SESSION['msg_type'] = "success";
}

if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$mysqli->query("DELETE FROM workers WHERE id=$id") or die($mysqli->error);
	$mysqli->query("DELETE FROM projects WHERE id=$id") or die($mysqli->error);

	header("location: index.php");

	$_SESSION['message'] = "Info has been deleted!";
	$_SESSION['msg_type'] = "danger";
}

if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$update = true;
	$result1 = $mysqli->query("SELECT * FROM workers WHERE id=$id") or die($mysqli->error);
	if (is_object($result)) {
		$row = $result->fetch_array();
		$name = $row['NAME'];
		$project = $row['PROJECT'];
	}
}

if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$project = $_POST['project'];

	$mysqli->query("UPDATE workers SET name='$name', project='$project' WHERE id=$id") or die($mysqli->error);

	$_SESSION['message'] = "Info has been updated!";
	$_SESSION['msg_type'] = "warning";

	header('location: index.php?path=workers');
}
