<?php

$server_key = 'SB-Mid-server-1AQBUbGNAeZ4TFAGWlJllRJn';

$is_production = false;

$api_url = $is_production ? 
'https://api.midtrans.com/v2/transactions' : 
'https://api.sandbox.midtrans.com/v2/transactions';

If(!strpos($_SERVER['REQUEST_URI'], '/charge')) {
    http_response_code(404);
    echo 'Direct access not allowed'; exit();
};

if($_SERVER['REQUEST_METHOD'] == 'POST') {

   http_response_code(404);
   echo 'Page not found'; exit();
};

$request_body = chargeAPI($api_url, $request_body, $server_key);

http_response_code($charge_result['http_code']);
echo $charge_result['body'];

function chargeAPI($api_url, $request_body, $server_key)
{
    $ch = curl_init();
    $curl_option = array(
        CURLOPT_URL => $api_url,
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic '.base64_encode($server_key)
        ),
        CURLOPT_POSTFIELDS => $request_body
    );

    curl_setopt_array($ch, $curl_option);
    $result = array(
        'body' => curl_exec($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
    );

    return $result;
}