<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.6');

$responseJson = '{
    "id": "test-request-789",
    "nbr": 8
}';

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
