<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.5');

$responseJson = '{
    "id": "request-12345",
    "seatbid": [{
        "seat": "seat-1",
        "bid": [{
            "id": "bid-1",
            "impid": "imp-1",
            "price": 3.50,
            "adm": "<div>Banner Ad</div>",
            "adomain": ["advertiser.com"],
            "crid": "creative-456",
            "w": 728,
            "h": 90
        }]
    }],
    "cur": "USD"
}';

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
