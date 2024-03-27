<?php

// Livebox credentials
$username = 'admin';
$password = 'Dh3F64H3';

// Livebox API endpoint URLs
$baseURL = 'http://192.168.1.1/sysbus/';
$loginURL = $baseURL . 'NMC/login';
$logoutURL = $baseURL . 'logout';
$addPortForwardURL = $baseURL . 'NMC/Firewall/PortForwarding/add';
$deletePortForwardURL = $baseURL . 'NMC/Firewall/PortForwarding/delete';

// Port forwarding rule parameters
$rule = [
    'enabled' => true,
    'protocol' => 'TCP',
    'external_port' => '8080',
    'internal_port' => '80',
    'internal_client' => '192.168.1.100',
    'comment' => 'Port Forwarding Rule',
];

// Function to make HTTP POST requests
function makeRequest($url, $data, $username, $password) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$username:$password")
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Login to Livebox
$response ="{".substr(makeRequest($loginURL, [], $username, $password), 1)."}";
$responseData = json_decode($response, true);

echo json_encode($responseData);

if ($responseData['status'] === 'ok') {
    // Add port forwarding rule
    $addResponse = makeRequest($addPortForwardURL, $rule, $username, $password);
    $addResponseData = json_decode($addResponse, true);
    
    // Remove port forwarding rule (for demonstration purpose)
    // $deleteResponse = makeRequest($deletePortForwardURL, ['forwarding_id' => $addResponseData['forwarding_id']], $username, $password);
    // $deleteResponseData = json_decode($deleteResponse, true);

    // Logout from Livebox
    makeRequest($logoutURL, [], $username, $password);
    
    // Output response
    echo "Port forwarding rule added successfully.\n";
    // echo "Port forwarding rule removed successfully.\n";
} else {
    echo "Failed to login to Livebox.\n";
}