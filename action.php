<?php
session_start();
include 'connect.php';
if (isset($_POST['item_submit'])) {
	$name = $_POST['name'];
	$price = $_POST['price'];

	$query = "INSERT INTO item VALUES('','$name','$price',NOW())";
	mysql_query($query) or die('Query Error');

	header('location: data.php');
}

if (isset($_POST['item_edit'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$price = $_POST['price'];

	$query = "UPDATE item SET name='$name',price='$price' WHERE id='$id'";
	mysql_query($query);
}

if (isset($_POST['item_delete'])) {
	$id = $_POST['id'];

	$query = "DELETE FROM item WHERE id='$id'";
	mysql_query($query);
}

if (isset($_POST['submit_login'])) {
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	if (($user != 'admin') || ($pass != 'admin')) {
		die('Invalid username or password');
	}

	$_SESSION['login']='admin';
	header('location: data.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: data.php');
}