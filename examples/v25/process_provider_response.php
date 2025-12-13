<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.5');

// Simulate provider response
$providerResponseJson = '{
    "id": "auction-12345",
    "seatbid": [{
        "seat": "advertiser-seat-1",
        "bid": [{
            "id": "1",
            "impid": "imp-1",
            "price": 4.50,
            "adm": "<div>Your Ad Here</div>",
            "crid": "creative-001",
            "w": 728,
            "h": 90,
            "nurl": "https://win.example.com/notify?price=${AUCTION_PRICE}"
        }]
    }],
    "cur": "USD"
}';

// Parse response
$response = $factory->createParser()->parseBidResponse($providerResponseJson);

// Access bid data
foreach ($response->getSeatbid() as $seatbid) {
    foreach ($seatbid->getBid() as $bid) {
        echo "Bid ID: " . $bid->getId() . "\n";
        echo "Price: $" . $bid->getPrice() . "\n";
        echo "Size: " . $bid->getW() . "x" . $bid->getH() . "\n";
        echo "Win URL: " . $bid->getNurl() . "\n";
    }
}
