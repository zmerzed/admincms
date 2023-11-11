<?php 
$mainSID = 'AC442c3f897147a382c1f606a9fdef3119';
$id = $mainSID;
$secret = '8ca934f16a68981a5700ff2020826db0';
$url = "https://api.twilio.com/2010-04-01/Accounts/AC442c3f897147a382c1f606a9fdef3119/Messages.json";
$digits = '123';
$to = '+639945181366'; // twilio trial verified number
$from = '+12516470370';
$body = 'abing code: ' . $digits;
$data = array (
    'From' => $from,
    'To' => $to,
    'Body' => $body,
);
$post = http_build_query($data);
$x = curl_init($url );
curl_setopt($x, CURLOPT_POST, true);
curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($x, CURLOPT_USERPWD, "$id:$secret");
curl_setopt($x, CURLOPT_POSTFIELDS, $post);
$y = curl_exec($x);
print_r($y);
curl_close($x);


// "Low stock level: ProductName, ID: recordID