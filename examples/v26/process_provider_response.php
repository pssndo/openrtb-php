<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\BidResponse;

echo "OpenRTB 2.6 - Processing Provider Response Example\n";
echo str_repeat('=', 50) . "\n\n";

echo "This example demonstrates receiving and processing\n";
echo "bid responses from SSP/Exchange providers using\n";
echo "the automatic fromArray() hydration method.\n\n";

// ============================================================================
// Example 1: Receiving a successful bid response from a provider
// ============================================================================
echo "--- Example 1: Successful Bid Response ---\n\n";

// Simulate receiving JSON response from provider (e.g., Google Ad Manager, AppNexus)
$jsonFromProvider = '{
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

// Decode JSON to array
$rawData = json_decode($jsonFromProvider, true);

// Automatic hydration - creates all nested objects!
$bidResponse = BidResponse::fromArray($rawData);

// Process the response with full type safety
echo "Response ID: " . $bidResponse->getId() . "\n";
echo "Bid ID: " . $bidResponse->getBidid() . "\n";
echo "Currency: " . $bidResponse->getCur() . "\n\n";

$seatbids = $bidResponse->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    foreach ($seatbids as $seatbid) {
        echo "Seat: " . $seatbid->getSeat() . "\n";

        $bids = $seatbid->getBid();
        if ($bids) {
            foreach ($bids as $bid) {
                echo "  Bid #" . $bid->getId() . ":\n";
                echo "    Price: $" . $bid->getPrice() . " " . $bidResponse->getCur() . "\n";
                echo "    Size: " . $bid->getW() . "x" . $bid->getH() . "\n";
                echo "    Creative ID: " . $bid->getCrid() . "\n";

                // OpenRTB 2.6 notification URLs
                echo "    Win URL: " . $bid->getNurl() . "\n";
                echo "    Billing URL: " . $bid->getBurl() . "\n";
                echo "    Loss URL: " . $bid->getLurl() . "\n";
            }
        }
    }
}

echo "\n";

// ============================================================================
// Example 2: Multi-currency response
// ============================================================================
echo "--- Example 2: Multi-Currency Response ---\n\n";

$multiCurrencyJson = '{
    "id": "auction-eur-123",
    "cur": "EUR",
    "seatbid": [
        {
            "seat": "eu-seat",
            "bid": [
                {
                    "id": "bid-eur-1",
                    "impid": "imp-1",
                    "price": 2.25,
                    "adm": "<div>European Ad</div>"
                }
            ]
        }
    ]
}';

$eurData = json_decode($multiCurrencyJson, true);
$eurResponse = BidResponse::fromArray($eurData);

echo "Currency: " . $eurResponse->getCur() . "\n";
$seatbids = $eurResponse->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    $bids = $seatbids[0]->getBid();
    if ($bids && count($bids) > 0) {
        echo "Bid Price: " . $bids[0]->getPrice() . " " . $eurResponse->getCur() . "\n";
    }
}

echo "\n";

// ============================================================================
// Example 3: Real-world DSP endpoint integration
// ============================================================================
echo "--- Example 3: Real-World DSP Integration ---\n\n";

echo "Typical OpenRTB 2.6 DSP endpoint:\n\n";
echo "<?php\n";
echo "use OpenRTB\\v26\\BidResponse;\n\n";
echo "// Receive response from SSP\n";
echo "\$jsonResponse = file_get_contents('php://input');\n";
echo "\$rawData = json_decode(\$jsonResponse, true);\n\n";
echo "// Automatic hydration\n";
echo "\$bidResponse = BidResponse::fromArray(\$rawData);\n\n";
echo "// Process response\n";
echo "\$seatbids = \$bidResponse->getSeatbid();\n";
echo "if (\$seatbids && count(\$seatbids) > 0) {\n";
echo "    foreach (\$seatbids as \$seatbid) {\n";
echo "        foreach (\$seatbid->getBid() as \$bid) {\n";
echo "            // Access all bid properties with type safety\n";
echo "            \$price = \$bid->getPrice();\n";
echo "            \$winUrl = \$bid->getNurl();\n";
echo "            \$billingUrl = \$bid->getBurl();\n";
echo "            \$lossUrl = \$bid->getLurl();\n";
echo "            \n";
echo "            // Store in database\n";
echo "            \$db->storeBid([\n";
echo "                'price' => \$price,\n";
echo "                'win_url' => \$winUrl,\n";
echo "                'billing_url' => \$billingUrl,\n";
echo "                'loss_url' => \$lossUrl,\n";
echo "            ]);\n";
echo "        }\n";
echo "    }\n";
echo "}\n\n";

echo "=== OpenRTB 2.6 Features ===\n";
echo "✓ Enhanced notification URLs (nurl, burl, lurl)\n";
echo "✓ Improved privacy support\n";
echo "✓ Supply chain transparency\n";
echo "✓ All automatically hydrated with fromArray()\n";
