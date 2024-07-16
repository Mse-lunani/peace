<?php
header("content-type:Application/json");
include_once 'token.php';
function create_order(){
$token = get_token();
$token = $token->access_token;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v2/checkout/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
    "intent": "CAPTURE",
    "purchase_units": [
        {
            "items": [
                {
                    "name": "Donate",
                    "description": "Donate",
                    "quantity": "1",
                    "unit_amount": {
                        "currency_code": "USD",
                        "value": "100.00"
                    }
                }
            ],
            "amount": {
                "currency_code": "USD",
                "value": "100.00",
                "breakdown": {
                    "item_total": {
                        "currency_code": "USD",
                        "value": "100.00"
                    }
                }
            }
        }
    ],
    "application_context": {
        "return_url": "https://example.com/return",
        "cancel_url": "https://example.com/cancel"
    }
}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Prefer: return=representation',
            'PayPal-Request-Id: '.bin2hex(random_bytes(7)),
            'Authorization: Bearer '.$token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

}

create_order();