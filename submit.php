<?php

$message = '
You have received a contact for submission:

Name: '.$_POST['name'].'
Email: '.$_POST['email'].'

';

/*
mail(
    'email@address.com',
    'Contact form Submission',
    $message
);
*/

$apiKey = 'YOUR_BREVO_API_KEY_HERE';

$curl = curl_init();

$data = json_encode([
    'sender' => [
        'email' => 'email@address.com',
        'name' => 'Enter Name Here',
    ],
    'to' => [
        [
            'email' => 'email@address.com',
            'name' => 'Enter Name Here'
        ]
    ],
    'subject' => 'Contact form Submission',
    'htmlContent' => $message
]);

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.brevo.com/v3/smtp/email",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "api-key: " . $apiKey,
        "content-type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}

header('Location: thankyou.html');