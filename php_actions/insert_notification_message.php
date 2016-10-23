<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "devcon_push_notification";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

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

	// "https://updates.push.services.mozilla.com/wpush/v1/gAAAAABYDIqsyKQnKT4-j3xUex_XsCSu4C6_utHZROFNtwtilrHTdV0xIKUGqFdVjQpciuf_ajLPcR5dS6GE7YqusfYqPoK8k3g1xHIr9IIuwetWQ1Ho3xUqI_WoOi0bdcPP8emfSNuw"1main.js:110:9



	$params = json_encode($values);

	// curl_setopt($ch, CURLOPT_URL, "https://updates.push.services.mozilla.com/update/gAAAAABYDIqsyKQnKT4-j3xUex_XsCSu4C6_utHZROFNtwtilrHTdV0xIKUGqFdVjQpciuf_ajLPcR5dS6GE7YqusfYqPoK8k3g1xHIr9IIuwetWQ1Ho3xUqI_WoOi0bdcPP8emfSNuw");

	curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

	$headers = array();
	$headers[] = "Authorization: key=AIzaSyCi_F0BEmUI8jpUwctG4lg8p3Ei6aAq2JA";
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$server_output = curl_exec($ch);

	// print_r($server_output);
	curl_close ($ch);

	echo $subscription_id;

	