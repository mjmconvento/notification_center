<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "devcon_push_notification";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


    $subscription_id = 'ceUNbi0GC6A:APA91bEyQbednnuxOfk9Z4UARW2uGFaJeQAN4zdOPUx0hrdYkEB_sC6FsVV-6Vv8A_onAgQnnl71CjR5W4MhmmJMjloc3T9hoCT8QANdWHBcdaFU_XCHgBiRhs9XcDEtAehqiVgS-6Ad';
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE subscription_id='$subscription_id' 
    	ORDER BY id DESC LIMIT 1"); 
    $stmt->execute();

    $stmt = $stmt->fetch(PDO::FETCH_ASSOC);


    $conn = null;

    $data = array();
    // array_push($data, $stmt);



	header('Content-type: application/json');
	echo json_encode($stmt);