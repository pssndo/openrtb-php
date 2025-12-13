<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.6');

$providerResponseJson = '{
    "id": "auction-v26-12345",
    "bidid": "bid-response-v26-67890",
    "cur": "USD",
    "seatbid": [
        {
            "seat": "advertiser-seat-v26",
            "bid": [
                {
                    "id": "bid-v26-1",
                    "impid": "imp-v26-1",
                    "price": 4.75,
                    "adid": "ad-v26-456",
                    "nurl": "https://win.example.com/v26/notify?price=${AUCTION_PRICE}",
                    "burl": "https://billing.example.com/v26/bill?price=${AUCTION_PRICE}",
                    "lurl": "https://loss.example.com/v26/notify?reason=${AUCTION_LOSS}",
                    "adm": "<VAST version=\"3.0\"><Ad>...</Ad></VAST>",
                    "adomain": ["video-advertiser.com"],
                    "cid": "campaign-v26-789",
                    "crid": "creative-v26-123",
                    "w": 1920,
                    "h": 1080
                }
            ],
            "group": 0
        }
    ]
}';

$response = $factory->createParser()->parseBidResponse($providerResponseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
