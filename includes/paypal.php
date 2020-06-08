<?php 

require 'paypal/autoload.php';

define('URL_SITIO', 'http://localhost/gdlwebcamp'); // define variable "super global"

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AXY9Gf_9hyEuotqEkgnEcS3h01KBRwDLokYeJApk4JfIqiKuiL4ypRPRomCVo8u4rm51Q44AX_ooTkVE', // ClienteID
        'EI0oJfUsIIHVXwwzLvKV3CQIXpKdvz1pJAcGqvq9wMLipE2hUeDjn4xHgMf96MofRSsIKuQdGwRqjM5H' // Secret
    )
);

