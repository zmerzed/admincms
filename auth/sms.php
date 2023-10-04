<?php 
$mainSID = 'AC9d90ba895ec331d0dbbce37d88eee992';
$id = $mainSID;
$secret = 'a1fbbc55e186ebd9380be07ee7520b3f';
$url = "https://api.twilio.com//2010-04-01/Accounts/{$mainSID}/Messages";
$digits = '123';
$to = '+639233980986'; // twilio trial verified number
$from = '+19288772240';
$body = 'Remz Your verification code: ' . $digits;
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
curl_close($x);
