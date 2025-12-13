<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

echo "=== Real-World Provider Integration Examples ===\n\n";

// ============================================================================
// Example 1: Receiving Response from an SSP/Exchange (OpenRTB 2.5)
// ============================================================================
echo "--- Example 1: Processing SSP Response (OpenRTB 2.5) ---\n\n";

// Simulating receiving a response from an SSP like Google Ad Manager, Xandr, etc.
$jsonResponseFromSSP = <<<'JSON'
{
    "id": "auction-12345",
    "bidid": "bid-67890",
    "cur": "USD",
    "seatbid": [
        {
            "seat": "advertiser-seat-1",
            "bid": [
                {
                    "id": "1",
                    "impid": "1",
                    "price": 4.50,
                    "adid": "ad-creative-789",
                    "nurl": "https://win.example.com/notify?price=${AUCTION_PRICE}",
                    "adm": "<div>Your Ad Here</div>",
                    "adomain": ["example-advertiser.com"],
                    "cid": "campaign-123",
                    "crid": "creative-456",
                    "w": 728,
                    "h": 90
                }
            ]
        }
    ]
}
JSON;

// Parse using Factory pattern - clean and simple!
$factory = new OpenRTBFactory('2.5');
$bidResponse = $factory->createParser()->parseBidResponse($jsonResponseFromSSP);

// Process the response with full type safety
echo "Auction ID: " . $bidResponse->getId() . "\n";
echo "Currency: " . $bidResponse->getCur() . "\n";

$seatbids = $bidResponse->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    foreach ($seatbids as $seatbid) {
        echo "\nSeat: " . $seatbid->getSeat() . "\n";

        $bids = $seatbid->getBid();
        if ($bids) {
            foreach ($bids as $bid) {
                echo "  Bid ID: " . $bid->getId() . "\n";
                echo "  Price: $" . $bid->getPrice() . "\n";
                echo "  Size: " . $bid->getW() . "x" . $bid->getH() . "\n";
                echo "  Win Notice URL: " . $bid->getNurl() . "\n";

                // Process the ad markup
                $adMarkup = $bid->getAdm();
                if ($adMarkup) {
                    echo "  Ad Markup: " . substr($adMarkup, 0, 50) . "...\n";
                }
            }
        }
    }
}

echo "\n";

// ============================================================================
// Example 2: Multi-Version Support in the Same Application
// ============================================================================
echo "--- Example 2: Supporting Multiple OpenRTB Versions ---\n\n";

function processProviderResponse(string $jsonResponse, string $version): void
{
    // Use Factory pattern for all versions
    $factory = new OpenRTBFactory($version);
    $bidResponse = $factory->createParser()->parseBidResponse($jsonResponse);

    echo "Version $version Response:\n";
    echo "  Response ID: " . $bidResponse->getId() . "\n";
    echo "  Currency: " . $bidResponse->getCur() . "\n";

    $seatbids = $bidResponse->getSeatbid();
    if ($seatbids && count($seatbids) > 0) {
        $bids = $seatbids[0]->getBid();
        if ($bids && count($bids) > 0) {
            echo "  First Bid Price: " . $bids[0]->getPrice() . "\n";
        }
    }
    echo "\n";
}

// Process v2.5 response
$v25Response = '{"id":"resp-v25","cur":"USD","seatbid":[{"seat":"s1","bid":[{"id":"b1","impid":"i1","price":2.5}]}]}';
processProviderResponse($v25Response, '2.5');

// Process v2.6 response
$v26Response = '{"id":"resp-v26","cur":"EUR","seatbid":[{"seat":"s2","bid":[{"id":"b2","impid":"i2","price":3.0}]}]}';
processProviderResponse($v26Response, '2.6');

// Process v3.0 response
$v3Response = '{"id":"resp-v3","cur":"GBP","seatbid":[{"seat":"s3","bid":[{"id":"b3","item":"item1","price":1.75}]}]}';
processProviderResponse($v3Response, '3.0');

// ============================================================================
// Example 3: Error Handling and No-Bid Responses
// ============================================================================
echo "--- Example 3: Handling No-Bid Responses ---\n\n";

$noBidJson = '{"id":"no-bid-123","nbr":2}';
$factory3 = new OpenRTBFactory('3.0');
$noBidObj = $factory3->createParser()->parseBidResponse($noBidJson);

echo "No-Bid Response ID: " . $noBidObj->getId() . "\n";
$nbr = $noBidObj->getNbr();
if ($nbr) {
    echo "No-Bid Reason Code: " . $nbr->value . " (" . $nbr->name . ")\n";
}

$seatbids = $noBidObj->getSeatbid();
if (!$seatbids || count($seatbids) === 0) {
    echo "No bids received.\n";
}

echo "\n";

// ============================================================================
// Example 4: Working with Extensions
// ============================================================================
echo "--- Example 4: Provider-Specific Extensions ---\n\n";

$responseWithExt = <<<'JSON'
{
    "id": "auction-ext-123",
    "cur": "USD",
    "seatbid": [
        {
            "seat": "seat-1",
            "bid": [
                {
                    "id": "bid-1",
                    "impid": "imp-1",
                    "price": 3.25,
                    "ext": {
                        "provider_tracking_id": "track-xyz-789",
                        "custom_metrics": {
                            "viewability_score": 0.85,
                            "brand_safety_score": 0.92
                        }
                    }
                }
            ]
        }
    ],
    "ext": {
        "processing_time_ms": 45,
        "datacenter": "us-east-1"
    }
}
JSON;

$responseWithExtensions = $factory->createParser()->parseBidResponse($responseWithExt);

echo "Response ID: " . $responseWithExtensions->getId() . "\n";

// Access response-level extensions
$responseExt = $responseWithExtensions->getExt();
if ($responseExt) {
    echo "Response Extensions:\n";
    $extArray = $responseExt->toArray();
    echo "  Processing Time: " . ($extArray['processing_time_ms'] ?? 'N/A') . " ms\n";
    echo "  Datacenter: " . ($extArray['datacenter'] ?? 'N/A') . "\n";
}

// Access bid-level extensions
$seatbids = $responseWithExtensions->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    $bids = $seatbids[0]->getBid();
    if ($bids && count($bids) > 0) {
        $bid = $bids[0];
        $bidExt = $bid->getExt();
        if ($bidExt) {
            echo "\nBid Extensions:\n";
            $bidExtArray = $bidExt->toArray();
            echo "  Provider Tracking ID: " . ($bidExtArray['provider_tracking_id'] ?? 'N/A') . "\n";
            if (isset($bidExtArray['custom_metrics'])) {
                echo "  Viewability Score: " . $bidExtArray['custom_metrics']['viewability_score'] . "\n";
                echo "  Brand Safety Score: " . $bidExtArray['custom_metrics']['brand_safety_score'] . "\n";
            }
        }
    }
}

echo "\n";

// ============================================================================
// Example 5: Integration Pattern for DSP/SSP Endpoint
// ============================================================================
echo "--- Example 5: Typical DSP Endpoint Integration ---\n\n";

echo "Typical DSP endpoint code:\n\n";
echo "<?php\n";
echo "use OpenRTB\\Factory\\OpenRTBFactory;\n\n";
echo "// Receive bid response from upstream SSP\n";
echo "\$jsonResponse = file_get_contents('php://input');\n\n";
echo "// Detect version (you might have this in your routing/config)\n";
echo "\$version = \$_SERVER['HTTP_X_OPENRTB_VERSION'] ?? '2.5';\n\n";
echo "// Parse response using Factory pattern\n";
echo "\$factory = new OpenRTBFactory(\$version);\n";
echo "\$bidResponse = \$factory->createParser()->parseBidResponse(\$jsonResponse);\n\n";
echo "// Process with full type safety\n";
echo "\$seatbids = \$bidResponse->getSeatbid();\n";
echo "foreach (\$seatbids as \$seatbid) {\n";
echo "    foreach (\$seatbid->getBid() as \$bid) {\n";
echo "        // Store bid in database\n";
echo "        \$db->storeBid([\n";
echo "            'id' => \$bid->getId(),\n";
echo "            'price' => \$bid->getPrice(),\n";
echo "            'creative_id' => \$bid->getCrid(),\n";
echo "            'win_url' => \$bid->getNurl(),\n";
echo "        ]);\n";
echo "        \n";
echo "        // Send win notification if needed\n";
echo "        if (\$shouldNotify) {\n";
echo "            \$winUrl = str_replace('\${AUCTION_PRICE}', \$bid->getPrice(), \$bid->getNurl());\n";
echo "            file_get_contents(\$winUrl);\n";
echo "        }\n";
echo "    }\n";
echo "}\n";
echo "\n";

echo "=== Key Benefits ===\n";
echo "✓ Factory pattern: \$factory->createParser()->parseBidResponse(\$json)\n";
echo "✓ Version-agnostic approach\n";
echo "✓ No manual object instantiation needed\n";
echo "✓ All nested objects automatically created\n";
echo "✓ Full type safety for IDE autocomplete\n";
echo "✓ Works identically across all versions (2.5, 2.6, 3.0)\n";
echo "✓ Handles Collections, Enums, and Extensions automatically\n";
echo "✓ Clean, maintainable code\n";
