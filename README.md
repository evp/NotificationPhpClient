#NotificationPhpClient

##What is NotificationPhpClient?

This is a library for [webtopay.com Notification API][1]. It allows you to easily check sign and parse the callback request
from webtopay.com about funds in your account. You have to set-up notifications in "Account settings" page on
webtopay.com to get the notifications.

##Installation

###Cloning
* Use `git clone https://github.com/evp/NotificationPhpClient.git` to copy the NotificationPhpClient directory to your
project directory.
* Add the following code to your PHP file where you intend to check notification callbacks:

```php
   require_once '/path/to/NotificationPhpClient/src/Evp/Notification/Autoloader.php';
   Evp_Notification_Autoloader::register();
```

This will ensure that all of the library's classes are properly loaded.
Make sure you change the 'path/to' to the actual path of the NotificationPhpClient.

###Composer

* Add `"paysera/notification-php-client": "dev-master"` dependency to composer.json file.
* Execute `composer install` in your project directory.

##Using the library

```php
$notification = Evp_Notification_Container::create()->getRequestParser()->parseRequest($_POST);
```

`Evp_Notification_Container::create` method is used for fluent interface, you can create container by using `new` keyword.

`Evp_Notification_RequestParser::parseRequest` method returns instance of `Evp_Notification_Entity_OperationNotification`,
which provides interface for getting the data from callback.
You can use method `Evp_Notification_RequestParser::parseRequestToArray` to get all passed parameters as an array
if you prefer.

You can customize the parameters and services by providing optional array parameter when creating `Evp_Notification_Container`.

Each time when callback is parsed and signature is checked, public key is requested from webtopay.com server. To cache
public key, provide parameter `cache.filePath` to container. For example:

```php
$container = new Evp_Notification_Container(array(
    'cache.filePath' => '/tmp/evp.notifications.public-key.php',
));
```

Be aware that this file *must* be in a safe place that no other script or third party could overwrite it. Otherwise
security can be breached by replacing the public key.
If there is no cache available, file is not readable or sign is invalid with cached key, public key will be downloaded
from webtopay.com and saved to cache.


Notification API requires that response code would be 200 and content would start with "OK". Library does not provide
any method to give this kind of response.

If signature check does not pass or some other issue occurs, library throws an exception. You can process those
exceptions by catching them:

```php
try {
    $notification = Evp_Notification_Container::create()->getRequestParser()->parseRequest($_POST);
    // process $notification somehow
    echo 'OK';
} catch (Evp_Notification_Exception $exception) {
    // log $exception somehow
    // do not respond 'OK' if you want that callback would be repeated after some time
    echo 'Error: ' . $exception;
}
```


##Running tests

Run `phpunit` in the base directory.

[1]: https://www.mokejimai.lt/dokumentacija.html
