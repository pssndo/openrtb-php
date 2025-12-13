<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

echo "=== OpenRTB Response Parsing Demo ===\n\n";
echo "This demonstrates automatic response parsing from raw provider JSON responses.\n";
echo "Use the Factory pattern with parser for clean, version-agnostic code!\n\n";

// ============================================================================
// OpenRTB 2.5 Example
// ============================================================================
echo "--- OpenRTB 2.5 Response Parsing ---\n";

// Simulate a raw JSON response from a provider
$jsonResponseV25 = <<<'JSON'
{
    "id": "bid-response-123",
    "bidid": "bid-id-456",
    "cur": "USD",
    "seatbid": [
        {
            "seat": "advertiser-1",
            "bid": [
                {
                    "id": "bid-1",
                    "impid": "imp-1",
                    "price": 2.50,
                    "adid": "ad-123",
                    "nurl": "https://example.com/win",
                    "adm": "<div>Ad Creative</div>",
                    "adomain": ["example.com"],
                    "cid": "campaign-1",
                    "crid": "creative-1",
                    "w": 300,
                    "h": 250,
                    "cat": ["IAB1-1", "IAB1-2"],
                    "attr": [1, 2, 3]
                }
            ]
        }
    ],
    "ext": {
        "custom_field": "custom_value"
    }
}
JSON;

// Parse using Factory pattern - all nested objects are created automatically!
$factory25 = new OpenRTBFactory('2.5');
$bidResponse25 = $factory25->createParser()->parseBidResponse($jsonResponseV25);

echo "Response ID: " . $bidResponse25->getId() . "\n";
echo "Bid ID: " . $bidResponse25->getBidid() . "\n";
echo "Currency: " . $bidResponse25->getCur() . "\n";

$seatbids = $bidResponse25->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    $seatbid = $seatbids[0];
    echo "Seat: " . $seatbid->getSeat() . "\n";

    $bids = $seatbid->getBid();
    if ($bids && count($bids) > 0) {
        $bid = $bids[0];
        echo "Bid Price: " . $bid->getPrice() . "\n";
        echo "Impression ID: " . $bid->getImpid() . "\n";
        echo "Creative ID: " . $bid->getCrid() . "\n";
        echo "Size: " . $bid->getW() . "x" . $bid->getH() . "\n";

        $adomain = $bid->getAdomain();
        if ($adomain) {
            echo "Advertiser Domains: " . implode(', ', $adomain) . "\n";
        }
    }
}

// Can still convert back to array/JSON
echo "\nJSON Output:\n";
echo json_encode($bidResponse25->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// ============================================================================
// OpenRTB 2.6 Example
// ============================================================================
echo "--- OpenRTB 2.6 Response Parsing ---\n";

$jsonResponseV26 = <<<'JSON'
{
    "id": "bid-response-v26",
    "bidid": "bid-v26-123",
    "cur": "EUR",
    "seatbid": [
        {
            "seat": "advertiser-2",
            "bid": [
                {
                    "id": "bid-2",
                    "impid": "imp-2",
                    "price": 3.75,
                    "adm": "<vast>...</vast>",
                    "crid": "creative-2",
                    "w": 640,
                    "h": 480
                }
            ]
        }
    ]
}
JSON;

$factory26 = new OpenRTBFactory('2.6');
$bidResponse26 = $factory26->createParser()->parseBidResponse($jsonResponseV26);

echo "Response ID: " . $bidResponse26->getId() . "\n";
echo "Currency: " . $bidResponse26->getCur() . "\n";

$seatbids26 = $bidResponse26->getSeatbid();
if ($seatbids26 && count($seatbids26) > 0) {
    $bids26 = $seatbids26[0]->getBid();
    if ($bids26 && count($bids26) > 0) {
        echo "Bid Price: " . $bids26[0]->getPrice() . " " . $bidResponse26->getCur() . "\n";
    }
}
echo "\n";

// ============================================================================
// OpenRTB 3.0 Example with Enum
// ============================================================================
echo "--- OpenRTB 3.0 Response Parsing (with Enum) ---\n";

$jsonResponseV3 = <<<'JSON'
{
    "id": "bid-response-v3",
    "bidid": "bid-v3-456",
    "cur": "GBP",
    "seatbid": [
        {
            "seat": "advertiser-3",
            "bid": [
                {
                    "id": "bid-3",
                    "item": "item-1",
                    "price": 5.00,
                    "deal": "deal-123"
                }
            ]
        }
    ]
}
JSON;

$factory3 = new OpenRTBFactory('3.0');
$bidResponse3 = $factory3->createParser()->parseBidResponse($jsonResponseV3);

echo "Response ID: " . $bidResponse3->getId() . "\n";
echo "Currency: " . $bidResponse3->getCur() . "\n";

$seatbids3 = $bidResponse3->getSeatbid();
if ($seatbids3 && count($seatbids3) > 0) {
    $bids3 = $seatbids3[0]->getBid();
    if ($bids3 && count($bids3) > 0) {
        echo "Bid Price: " . $bids3[0]->getPrice() . " " . $bidResponse3->getCur() . "\n";
        echo "Deal: " . $bids3[0]->getDeal() . "\n";
    }
}
echo "\n";

// ============================================================================
// No-Bid Response Example (OpenRTB 3.0)
// ============================================================================
echo "--- No-Bid Response (OpenRTB 3.0) ---\n";

$noBidJson = <<<'JSON'
{
    "id": "no-bid-response",
    "nbr": 2
}
JSON;

$noBidResponse = $factory3->createParser()->parseBidResponse($noBidJson);

echo "Response ID: " . $noBidResponse->getId() . "\n";
$nbr = $noBidResponse->getNbr();
if ($nbr) {
    echo "No-Bid Reason: " . $nbr->value . " (" . $nbr->name . ")\n";
}
echo "\n";

// ============================================================================
// Real-world usage example
// ============================================================================
echo "=== Real-World Usage ===\n\n";
echo "// Receive response from provider\n";
echo "\$jsonResponse = file_get_contents('php://input');\n\n";
echo "// Parse using Factory pattern\n";
echo "\$factory = new OpenRTBFactory('2.5');\n";
echo "\$bidResponse = \$factory->createParser()->parseBidResponse(\$jsonResponse);\n\n";
echo "// Access all fields with full type safety\n";
echo "\$seatbids = \$bidResponse->getSeatbid();\n";
echo "foreach (\$seatbids as \$seatbid) {\n";
echo "    foreach (\$seatbid->getBid() as \$bid) {\n";
echo "        echo \$bid->getPrice();\n";
echo "        echo \$bid->getCrid();\n";
echo "    }\n";
echo "}\n\n";

echo "=== Benefits ===\n";
echo "✓ Clean Factory pattern usage\n";
echo "✓ Version-agnostic parsing\n";
echo "✓ No manual object creation\n";
echo "✓ Automatic nested object hydration\n";
echo "✓ Handles Collections automatically\n";
echo "✓ Handles Enums automatically\n";
echo "✓ Works with all OpenRTB versions (2.5, 2.6, 3.0)\n";
echo "✓ Full type safety and IDE autocomplete\n";
echo "✓ Still supports toArray()/toJson() for serialization\n";
