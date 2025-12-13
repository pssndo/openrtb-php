<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.6');

$responseJson = '{
    "id": "test-request-123",
    "bidid": "bidresponse-67890",
    "seatbid": [{
        "seat": "advertiser-seat-1",
        "bid": [{
            "id": "bid-1",
            "impid": "1",
            "price": 1.25,
            "adid": "ad-123",
            "crid": "creative-456",
            "adm": "<a href=\\"%%CLICK_URL_ESC%%https://advertiser.com\\"><img alt="" src=\\"https://cdn.example.com/banner.jpg\\" width=\\"300\\" height=\\"250\\"/></a>",
            "w": 300,
            "h": 250,
            "burl": "https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}",
            "lurl": "https://dsp.example.com/loss?id=${AUCTION_ID}",
            "nurl": "https://dsp.example.com/nurl?id=${AUCTION_ID}",
            "adomain": ["advertiser.com"],
            "cat": ["IAB3-1"]
        }]
    }],
    "cur": "USD"
}';

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
