<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "devcon_push_notification";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	
	$subscription_id = $_POST['subscription_id'];

	if ($_POST['action'] == 'subscribe') {
		$sql = "INSERT INTO subscriptions (subscription_id) VALUES ('$subscription_id')";
	} elseif ($_POST['action'] == 'unsubscribe') {
		$sql = "DELETE FROM subscriptions WHERE subscription_id='$subscription_id'";
	} 

	$conn->exec($sql);

	$conn = null;
	echo true;

	