# Logic4 PHP
This package is slim wrapper around the Logic4 API. It's an opinionated integration that uses Saloon as a client/wrapper and handles general tasks like authentication. 

# How to use
```php

// Set configuration 
$connector = new \Wndr\Logic4\Connectors\Logic4Connector();
$connector->setAdministrationId('xx')
->setCompanyKey('xx')
->setPrivateKey('xx')
->setPublicKey('xx')
->setUsername('xx')
->setPassword('xx')
->authenticate($connector->getAccessToken())

// Create request
$request = new \Wndr\Logic4\Requests\Orders\GetOrders([
    'Id' => 'xx',
    'TakeRecords' => 1
]);

// Get results
$response = $connector->send($request)->json();
```
