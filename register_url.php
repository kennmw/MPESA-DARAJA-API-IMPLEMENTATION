<?php
    $consumerKey = 'Paste Your Own Key';
    $consumerSecret = 'Copy Your Own Key';

    $headers = ['Content-Type|application/json; charset=utf8'];

    // $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);

    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    $result = json_decode($result);
    $access_token = $result->access_token;
    // echo $access_token;
    curl_close($curl);

    $url = 'https://api.safaricom.co.ke/mpesa/c2b/vi/registerurl';
    // $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/vi/registerurl';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,array(
        'Content-Type:application/json', 'Authorization:Bearer '.$access_token
    ));

    // Custome Header

    $curl_post_data = array(
        'ShortCode'=>'Paste your short code',
        'ResponseType'=>'completed/ cancelled',// YOu can only have one option , either completed or cancelled
        'ConfirmationURL'=>'Paste your confirmation script public url',
        'ValidationURL'=>'Paste Your validation script public url '
    );


    $datastring = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $datastring);

    $curl_response = curl_exec($curl);

    print_r($curl_response);
    echo $curl_response;
    // If no error You'll receive a success message
?>