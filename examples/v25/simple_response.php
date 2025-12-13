<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.5');

$responseJson = '{
    "id": "request-123",
    "seatbid": [{
        "seat": "advertiser-1",
        "bid": [{
            "id": "bid-1",
            "impid": "imp-1",
            "price": 2.50,
            "adm": "<div>Ad Markup</div>",
            "crid": "creative-123",
            "w": 300,
            "h": 250
        }]
    }],
    "cur": "USD"
}';

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
