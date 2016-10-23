<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "devcon_push_notification";
    $subscription_id = $_POST['subscription_id'];

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id FROM subscriptions WHERE subscription_id='$subscription_id'"); 
    $stmt->execute();

    $conn = null;
    echo count($stmt->fetchAll());
?>