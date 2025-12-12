<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\BidResponse;

echo "OpenRTB 3.0 - Processing Provider Response Example\n";
echo str_repeat('=', 50) . "\n\n";

echo "This example demonstrates receiving and processing\n";
echo "bid responses from SSP/Exchange providers using\n";
echo "the automatic fromArray() hydration method.\n\n";

// ============================================================================
// Example 1: Receiving a successful bid response from a provider
// ============================================================================
echo "--- Example 1: Successful Bid Response ---\n\n";

// Simulate receiving JSON response from provider (OpenRTB 3.0)
$jsonFromProvider = '{
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
                echo "    Item: " . $bid->getItem() . " (note: 'item' not 'impid' in v3)\n";
                echo "    Price: $" . $bid->getPrice() . " " . $bidResponse->getCur() . "\n";

                $deal = $bid->getDeal();
                if ($deal) {
                    echo "    Deal: " . $deal . "\n";
                }
            }
        }
    }
}

echo "\n";

// ============================================================================
// Example 2: No-bid response with NoBidReason enum
// ============================================================================
echo "--- Example 2: No-Bid Response with Enum ---\n\n";

$noBidJson = '{
    "id": "auction-v3-nobid",
    "nbr": 2
}';

$noBidData = json_decode($noBidJson, true);
$noBidResponse = BidResponse::fromArray($noBidData);

echo "Response ID: " . $noBidResponse->getId() . "\n";

// OpenRTB 3.0 uses NoBidReason enum
$nbr = $noBidResponse->getNbr();
if ($nbr) {
    echo "No-Bid Reason: " . $nbr->value . " (" . $nbr->name . ")\n";
}

$seatbids = $noBidResponse->getSeatbid();
if (!$seatbids || count($seatbids) > 0) {
    echo "No bids returned from provider.\n";
}

echo "\n";

// ============================================================================
// Example 3: Multi-item response
// ============================================================================
echo "--- Example 3: Multi-Item Response ---\n\n";

$multiItemJson = '{
    "id": "multi-item-auction",
    "cur": "GBP",
    "seatbid": [
        {
            "seat": "multi-seat",
            "bid": [
                {
                    "id": "bid-item-1",
                    "item": "item-1",
                    "price": 1.50
                },
                {
                    "id": "bid-item-2",
                    "item": "item-2",
                    "price": 2.25
                }
            ]
        }
    ]
}';

$multiData = json_decode($multiItemJson, true);
$multiResponse = BidResponse::fromArray($multiData);

echo "Response ID: " . $multiResponse->getId() . "\n";
echo "Currency: " . $multiResponse->getCur() . "\n";

$seatbids = $multiResponse->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    $bids = $seatbids[0]->getBid();
    if ($bids) {
        echo "Total Bids: " . count($bids) . "\n";
        foreach ($bids as $bid) {
            echo "  Item: " . $bid->getItem() . " - Price: " . $bid->getPrice() . " " . $multiResponse->getCur() . "\n";
        }
    }
}

echo "\n";

// ============================================================================
// Example 4: Real-world DSP endpoint integration
// ============================================================================
echo "--- Example 4: Real-World OpenRTB 3.0 DSP Integration ---\n\n";

echo "Typical OpenRTB 3.0 DSP endpoint:\n\n";
echo "<?php\n";
echo "use OpenRTB\\v3\\BidResponse;\n\n";
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
echo "            // Note: 'item' not 'impid' in OpenRTB 3.0\n";
echo "            \$itemId = \$bid->getItem();\n";
echo "            \$price = \$bid->getPrice();\n";
echo "            \$deal = \$bid->getDeal();\n";
echo "            \n";
echo "            // Store in database\n";
echo "            \$db->storeBid([\n";
echo "                'auction_id' => \$bidResponse->getId(),\n";
echo "                'item_id' => \$itemId,\n";
echo "                'price' => \$price,\n";
echo "                'currency' => \$bidResponse->getCur(),\n";
echo "                'deal_id' => \$deal,\n";
echo "            ]);\n";
echo "        }\n";
echo "    }\n";
echo "}\n\n";

echo "=== OpenRTB 3.0 Key Differences ===\n";
echo "✓ Uses 'item' instead of 'impid'\n";
echo "✓ NoBidReason is an Enum (not just int)\n";
echo "✓ Structured native ads\n";
echo "✓ All automatically hydrated with fromArray()\n";
echo "✓ Same simple API across all versions\n";
