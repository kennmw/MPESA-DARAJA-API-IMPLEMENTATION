<?php
    $consumerKey = 'Paste Your Key Here from portal';
    $consumerSecret = 'Paste Your Key Here from portal';

    $headers = ['Content-Type|application/json; charset=utf8'];

    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init($access_token_url);
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
    #Initiating the transaction

    // Define the variables
    $initial_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $BusinessShortCode = 'Paste Your Bussiness Short Code';
    $Timestamp = date('YmdGis');
    $PartyA = 'Phone NUmber';
    $CallBackUrl = 'Call Back script url';
    $AccountReference = 'Write Your Word';
    $TransactionDesc = 'Give a description for your transactions';
    $Amount = 'Enter amount';
    $Passkey = 'Paste Your own password from portal';

    $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
    $sktheader = ['Content-Type:application/json', 'Authorization:Bearer '.$access_token];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initial_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $sktheader);

    $curl_post_data = array(
        // Request parameters
        'BusinessShortCode'=>$BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount'=>$Amount,
        'PartyA'=>$PartyA,
        'PartyB'=>$BusinessShortCode,
        'PhoneNumber'=>$PartyA,
        'CallBackURL'=>$CallBackUrl,
        'AccountReference'=>$AccountReference,
        'TransactionDesc'=>$TransactionDesc
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    print_r($curl_response);

?>