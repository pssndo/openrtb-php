<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('3.0');

$jsonRequest = '{
  "id": "test-request-123",
  "at": 2,
  "tmax": 150,
  "item": [
    {
      "id": "item-1"
    }
  ],
  "context": {
    "site": {
        "domain": "example.com"
    }
  }
}';

$request = $factory->createParser()->parseBidRequest($jsonRequest);

$validator = $factory->createValidator();
$validator->validateRequest($request);

if ($validator->hasErrors()) {
    $response = [
        'valid' => false,
        'errors' => $validator->getErrors()
    ];
} else {
    $response = [
        'valid' => true,
        'request_id' => $request->getId(),
        'items_count' => count($request->getItem()),
        'channel' => $request->getContext()->getSite() ? 'site' : 'app'
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
