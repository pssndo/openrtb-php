<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('3.0');

$responseJson = '{
    "id": "test-request-123",
    "bidid": "bidresponse-67890",
    "seatbid": [{
        "seat": "advertiser-seat-1",
        "bid": [{
            "id": "bid-1",
            "item": "1",
            "price": 1.25,
            "cid": "campaign123",
            "burl": "https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}",
            "lurl": "https://dsp.example.com/loss?id=${AUCTION_ID}",
            "media": {
                "ad": {
                    "id": "ad123",
                    "adomain": ["advertiser.com"],
                    "cat": ["IAB3-1"],
                    "secure": 1,
                    "display": {
                        "banner": {
                            "img": "https://cdn.example.com/ads/banner.jpg",
                            "w": 300,
                            "h": 250
                        }
                    }
                }
            }
        }]
    }],
    "cur": "USD"
}';

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
