<?php

require_once dirname(__FILE__) . '/../src/Evp/Notification/Autoloader.php';
Evp_Notification_Autoloader::register();

$params = array(
//    'cache.filePath' => '/tmp/evp.notifications.public-key.pem',  // provide file to write public key cache to
);

try {
    $notification = Evp_Notification_Container::create($params)->getRequestParser()->parseRequest($_POST);
    // Save $notification or process it somehow

    echo 'OK';
} catch (Evp_Notification_Exception $exception) {
    // Possibly log the exception
    // You can also just ignore the exceptions.
    // As status code would be 500 and no "OK" at the beginning of response in this case, the callback will be repeated

    // echo 'Error: ' . $exception;
}
