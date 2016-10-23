<?php
    include 'connect.php';

    $subscription_id = $_POST['subscription_id'];

    $stmt = $conn->prepare("SELECT id FROM subscriptions WHERE subscription_id='$subscription_id'"); 
    $stmt->execute();

    $conn = null;

    header('Content-Type: text/html; charset=utf-8');
    echo count($stmt->fetchAll());