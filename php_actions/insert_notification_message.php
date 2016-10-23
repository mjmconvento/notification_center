<?php
	
	include 'connect.php';

	$title = $_POST['title'];
	$body = $_POST['body'];
	$url = $_POST['url'];

	$subscription_id = $_POST['subscription_id'];

	$sql = "INSERT INTO notifications (subscription_id, title, body, url) 
		VALUES ('$subscription_id', '$title', '$body', '$url')";

	$conn->exec($sql);
	$conn = null;

    // Curl to send to GCM
	$ch = curl_init();

	$result_array = array($subscription_id);
	$values = array(
	    'registration_ids' => $result_array
	);

	$params = json_encode($values);

	curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

	$headers = array();
	$headers[] = "Authorization: key=AIzaSyCi_F0BEmUI8jpUwctG4lg8p3Ei6aAq2JA";
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$server_output = curl_exec($ch);

	curl_close ($ch);

	header('Status: 200 OK');
	echo 1;

	