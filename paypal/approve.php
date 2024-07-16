<?php
header("content-type:Application/json");
include_once 'token.php';
function complete_order($id){
    $token = get_token();
    $token = $token->access_token;


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v2/checkout/orders/'.$id.'/capture',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Prefer: return=representation',
            'PayPal-Request-Id: 16ece72e-9072-4952-9871-e130ecddc9ec',
            'Authorization: Bearer '.$token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

}
if(isset($_GET['id'])){
    complete_order($_GET['id']);
}