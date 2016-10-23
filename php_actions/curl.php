<?php
	include 'connect.php';

    $stmt = $conn->prepare("SELECT subscription_id FROM subscriptions"); 
    $stmt->execute();
    
    $conn = null;
    
    $result = $stmt->fetchAll();
    $result_array = array();

    foreach($result as $key => $value) {
    	array_push($result_array, $result[$key]['subscription_id']);
    }


    // Curl to send to GCM
	$ch = curl_init();

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

	print_r($server_output);
	curl_close ($ch);