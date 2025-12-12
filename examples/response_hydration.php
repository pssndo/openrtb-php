<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\v25\BidResponse as BidResponseV25;
use OpenRTB\v26\BidResponse as BidResponseV26;
use OpenRTB\v3\BidResponse as BidResponseV3;

echo "=== OpenRTB Response Hydration Demo ===\n\n";
echo "This demonstrates automatic object hydration from raw provider responses.\n";
echo "No need to manually set each field - just pass the raw data!\n\n";

// ============================================================================
// OpenRTB 2.5 Example
// ============================================================================
echo "--- OpenRTB 2.5 Response Hydration ---\n";

// Simulate a raw response from a provider (like from json_decode($response, true))
$rawResponseV25 = [
    'id' => 'bid-response-123',
    'bidid' => 'bid-id-456',
    'cur' => 'USD',
    'seatbid' => [
        [
            'seat' => 'advertiser-1',
            'bid' => [
                [
                    'id' => 'bid-1',
                    'impid' => 'imp-1',
                    'price' => 2.50,
                    'adid' => 'ad-123',
                    'nurl' => 'https://example.com/win',
                    'adm' => '<div>Ad Creative</div>',
                    'adomain' => ['example.com'],
                    'cid' => 'campaign-1',
                    'crid' => 'creative-1',
                    'w' => 300,
                    'h' => 250,
                    'cat' => ['IAB1-1', 'IAB1-2'],
                    'attr' => [1, 2, 3],
                ],
            ],
        ],
    ],
    'ext' => [
        'custom_field' => 'custom_value',
    ],
];

// Automatic hydration - all nested objects are created!
$bidResponse25 = BidResponseV25::fromArray($rawResponseV25);

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
echo "--- OpenRTB 2.6 Response Hydration ---\n";

$rawResponseV26 = [
    'id' => 'bid-response-v26',
    'bidid' => 'bid-v26-123',
    'cur' => 'EUR',
    'seatbid' => [
        [
            'seat' => 'advertiser-2',
            'bid' => [
                [
                    'id' => 'bid-2',
                    'impid' => 'imp-2',
                    'price' => 3.75,
                    'adm' => '<vast>...</vast>',
                    'crid' => 'creative-2',
                    'w' => 640,
                    'h' => 480,
                ],
            ],
        ],
    ],
];

$bidResponse26 = BidResponseV26::fromArray($rawResponseV26);

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
echo "--- OpenRTB 3.0 Response Hydration (with Enum) ---\n";

$rawResponseV3 = [
    'id' => 'bid-response-v3',
    'bidid' => 'bid-v3-456',
    'cur' => 'GBP',
    'seatbid' => [
        [
            'seat' => 'advertiser-3',
            'bid' => [
                [
                    'id' => 'bid-3',
                    'item' => 'item-1',
                    'price' => 5.00,
                    'deal' => 'deal-123',
                ],
            ],
        ],
    ],
];

$bidResponse3 = BidResponseV3::fromArray($rawResponseV3);

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

$rawNoBidResponse = [
    'id' => 'no-bid-response',
    'nbr' => 2, // NoBidReason enum value (e.g., 2 = Technical Error)
];

$noBidResponse = BidResponseV3::fromArray($rawNoBidResponse);

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
echo "\$jsonResponse = file_get_contents('php://input');\n";
echo "\$rawData = json_decode(\$jsonResponse, true);\n\n";
echo "// Automatic hydration - that's it!\n";
echo "\$bidResponse = BidResponseV25::fromArray(\$rawData);\n\n";
echo "// Access all fields with full type safety\n";
echo "\$seatbids = \$bidResponse->getSeatbid();\n";
echo "foreach (\$seatbids as \$seatbid) {\n";
echo "    foreach (\$seatbid->getBid() as \$bid) {\n";
echo "        echo \$bid->getPrice();\n";
echo "        echo \$bid->getCrid();\n";
echo "    }\n";
echo "}\n\n";

echo "=== Benefits ===\n";
echo "✓ No manual object creation\n";
echo "✓ No manual field setting\n";
echo "✓ Automatic nested object hydration\n";
echo "✓ Handles Collections automatically\n";
echo "✓ Handles Enums automatically\n";
echo "✓ Works with all OpenRTB versions (2.5, 2.6, 3.0)\n";
echo "✓ Full type safety and IDE autocomplete\n";
echo "✓ Still supports toArray()/toJson() for serialization\n";
