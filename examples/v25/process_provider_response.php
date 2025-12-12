<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v25\BidResponse;

echo "OpenRTB 2.5 - Processing Provider Response Example\n";
echo str_repeat('=', 50) . "\n\n";

echo "This example demonstrates receiving and processing\n";
echo "bid responses from SSP/Exchange providers using\n";
echo "the automatic fromArray() hydration method.\n\n";

// ============================================================================
// Example 1: Receiving a successful bid response from a provider
// ============================================================================
echo "--- Example 1: Successful Bid Response ---\n\n";

// Simulate receiving JSON response from provider (e.g., Google Ad Manager, Xandr)
$jsonFromProvider = '{
    "id": "auction-12345",
    "bidid": "bid-response-67890",
    "cur": "USD",
    "seatbid": [
        {
            "seat": "advertiser-seat-1",
            "bid": [
                {
                    "id": "bid-1",
                    "impid": "imp-1",
                    "price": 3.25,
                    "adid": "ad-creative-456",
                    "nurl": "https://win.example.com/notify?price=${AUCTION_PRICE}",
                    "burl": "https://billing.example.com/bill?price=${AUCTION_PRICE}",
                    "lurl": "https://loss.example.com/notify?reason=${AUCTION_LOSS}",
                    "adm": "<div class=\"ad\">Premium Ad Content</div>",
                    "adomain": ["premium-advertiser.com"],
                    "cid": "campaign-789",
                    "crid": "creative-123",
                    "w": 728,
                    "h": 90,
                    "cat": ["IAB1-1", "IAB1-2"],
                    "attr": [1, 2, 3]
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
                echo "    Campaign ID: " . $bid->getCid() . "\n";

                $adomain = $bid->getAdomain();
                if ($adomain) {
                    echo "    Advertiser Domains: " . implode(', ', $adomain) . "\n";
                }

                echo "    Win Notice URL: " . $bid->getNurl() . "\n";
                echo "    Billing URL: " . $bid->getBurl() . "\n";
                echo "    Loss URL: " . $bid->getLurl() . "\n";
            }
        }
    }
}

echo "\n";

// ============================================================================
// Example 2: No-bid response
// ============================================================================
echo "--- Example 2: No-Bid Response ---\n\n";

$noBidJson = '{
    "id": "auction-54321",
    "nbr": 2
}';

$noBidData = json_decode($noBidJson, true);
$noBidResponse = BidResponse::fromArray($noBidData);

echo "Response ID: " . $noBidResponse->getId() . "\n";
echo "No-Bid Reason Code: " . $noBidResponse->getNbr() . "\n";

$seatbids = $noBidResponse->getSeatbid();
if (!$seatbids || count($seatbids) === 0) {
    echo "No bids returned from provider.\n";
}

echo "\n";

// ============================================================================
// Example 3: Response with extensions
// ============================================================================
echo "--- Example 3: Response with Provider Extensions ---\n\n";

$responseWithExtJson = '{
    "id": "auction-99999",
    "cur": "EUR",
    "seatbid": [
        {
            "seat": "seat-ext",
            "bid": [
                {
                    "id": "bid-ext-1",
                    "impid": "imp-1",
                    "price": 1.75,
                    "adm": "<div>Ad with extensions</div>",
                    "ext": {
                        "provider_tracking_id": "track-xyz-123",
                        "viewability_score": 0.92,
                        "brand_safety": "safe"
                    }
                }
            ]
        }
    ],
    "ext": {
        "processing_time_ms": 32,
        "datacenter": "eu-west-1",
        "debug_info": "auction_type=first_price"
    }
}';

$extData = json_decode($responseWithExtJson, true);
$responseWithExt = BidResponse::fromArray($extData);

echo "Response ID: " . $responseWithExt->getId() . "\n";

// Access response-level extensions
$responseExt = $responseWithExt->getExt();
if ($responseExt) {
    echo "\nResponse Extensions:\n";
    $extArray = $responseExt->toArray();
    foreach ($extArray as $key => $value) {
        echo "  $key: $value\n";
    }
}

// Access bid-level extensions
$seatbids = $responseWithExt->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    $bids = $seatbids[0]->getBid();
    if ($bids && count($bids) > 0) {
        $bidExt = $bids[0]->getExt();
        if ($bidExt) {
            echo "\nBid Extensions:\n";
            $bidExtArray = $bidExt->toArray();
            foreach ($bidExtArray as $key => $value) {
                echo "  $key: $value\n";
            }
        }
    }
}

echo "\n";

// ============================================================================
// Example 4: Real-world DSP endpoint integration
// ============================================================================
echo "--- Example 4: Real-World DSP Integration ---\n\n";

echo "Typical DSP endpoint code:\n\n";
echo "<?php\n";
echo "// Receive bid response from upstream SSP\n";
echo "\$jsonResponse = file_get_contents('php://input');\n";
echo "\$rawData = json_decode(\$jsonResponse, true);\n\n";
echo "// Automatic hydration\n";
echo "\$bidResponse = BidResponse::fromArray(\$rawData);\n\n";
echo "// Validate response\n";
echo "if (!\$bidResponse->getId()) {\n";
echo "    http_response_code(400);\n";
echo "    exit('Invalid response');\n";
echo "}\n\n";
echo "// Process bids\n";
echo "\$seatbids = \$bidResponse->getSeatbid();\n";
echo "if (\$seatbids && count(\$seatbids) > 0) {\n";
echo "    foreach (\$seatbids as \$seatbid) {\n";
echo "        foreach (\$seatbid->getBid() as \$bid) {\n";
echo "            // Store bid in database\n";
echo "            \$db->storeBid([\n";
echo "                'auction_id' => \$bidResponse->getId(),\n";
echo "                'bid_id' => \$bid->getId(),\n";
echo "                'price' => \$bid->getPrice(),\n";
echo "                'currency' => \$bidResponse->getCur(),\n";
echo "                'creative_id' => \$bid->getCrid(),\n";
echo "                'win_url' => \$bid->getNurl(),\n";
echo "            ]);\n";
echo "            \n";
echo "            // Send win notification if this bid wins\n";
echo "            if (\$shouldNotify) {\n";
echo "                \$winUrl = str_replace(\n";
echo "                    '${AUCTION_PRICE}',\n";
echo "                    (string)\$bid->getPrice(),\n";
echo "                    \$bid->getNurl()\n";
echo "                );\n";
echo "                file_get_contents(\$winUrl);\n";
echo "            }\n";
echo "        }\n";
echo "    }\n";
echo "}\n\n";

echo "=== Key Benefits ===\n";
echo "✓ Single line: BidResponse::fromArray(\$rawData)\n";
echo "✓ No manual object instantiation\n";
echo "✓ All nested objects automatically created\n";
echo "✓ Full type safety and IDE autocomplete\n";
echo "✓ Handles Collections automatically\n";
echo "✓ Handles Extensions automatically\n";
echo "✓ Works for all OpenRTB versions (2.5, 2.6, 3.0)\n";
