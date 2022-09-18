<?php
// PUT YOUR SERVER WEBHOOK HERE
$WEBHOOK_HERE = "";

// PASSWORD
$PASSWORD = "";

$MESSAGE = $_POST['message'];
$INPUT_PASSWORD = $_POST['password'];

if ($INPUT_PASSWORD == $PASSWORD) {
    $data = ['content' => $MESSAGE];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($WEBHOOK_HERE, false, $context);
    echo '<script>alert("Sent!")</script>';
} else {
    echo '<script>alert("not sent!")</script>';
}