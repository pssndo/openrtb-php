<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('3.0');

$providerResponseJson = '{
    "id": "auction-v3-12345",
    "bidid": "bid-response-v3-67890",
    "cur": "USD",
    "seatbid": [
        {
            "seat": "advertiser-seat-v3",
            "bid": [
                {
                    "id": "bid-v3-1",
                    "item": "item-1",
                    "price": 5.50,
                    "deal": "deal-123"
                }
            ]
        }
    ]
}';

$response = $factory->createParser()->parseBidResponse($providerResponseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
