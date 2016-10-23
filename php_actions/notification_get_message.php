<?php
	include 'connect.php';

    $subscription_id = $_GET['subscription_id'];
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE subscription_id='$subscription_id' 
    	ORDER BY id DESC LIMIT 1"); 
    $stmt->execute();

    $stmt = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = null;
    $data = array();

	header('Content-type: application/json');
	echo json_encode($stmt);