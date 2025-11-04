<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\Factory\ProviderRegistry;

/**
 * SSP Integration Example
 *
 * This demonstrates how an SSP (Supply Side Platform) sends bid requests
 * to multiple DSP partners and processes their responses.
 *
 * Flow:
 * 1. Receive ad request from publisher
 * 2. Build bid requests for each DSP partner
 * 3. Send requests to DSPs (simulated here)
 * 4. Parse and validate responses
 * 5. Select winning bid
 */

echo "=== SSP Integration Example ===\n\n";

// ============================================================================
// Configuration: Register your DSP partners and their OpenRTB versions
// ============================================================================

$registry = ProviderRegistry::getInstance();
$registry->registerBatch([
    'dsp_partner_a' => '3.0',  // Uses OpenRTB 3.0
    'dsp_partner_b' => '2.6',  // Uses OpenRTB 2.6
    'dsp_partner_c' => '2.6',
]);

// ============================================================================
// Step 1: Receive ad request from publisher
// ============================================================================

echo "Step 1: Publisher Ad Request\n";
echo str_repeat('-', 60) . "\n";

$publisherRequest = [
    'placement_id' => 'banner-300x250-sidebar',
    'site' => [
        'domain' => 'publisher.com',
        'page' => 'https://publisher.com/article/tech-news'
    ],
    'device' => [
        'ua' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'ip' => '203.0.113.45'
    ],
    'size' => [
        'width' => 300,
        'height' => 250
    ],
    'floor_price' => 1.50,
];

echo "Received request for placement: {$publisherRequest['placement_id']}\n";
echo "Floor price: \${$publisherRequest['floor_price']}\n";
echo "Size: {$publisherRequest['size']['width']}x{$publisherRequest['size']['height']}\n\n";

// ============================================================================
// Step 2 & 3: Build and send bid requests to DSP partners
// ============================================================================

echo "Step 2: Sending Bid Requests to DSP Partners\n";
echo str_repeat('=', 60) . "\n\n";

$dspPartners = [
    'dsp_partner_a',
    'dsp_partner_b',
    'dsp_partner_c',
];

$bidResponses = [];

foreach ($dspPartners as $dspName) {
    echo "DSP: {$dspName}\n";
    echo str_repeat('-', 40) . "\n";

    try {
        // Create factory for this DSP's OpenRTB version
        $factory = OpenRTBFactory::forProvider($dspName);
        $version = $factory->getVersion();

        echo "OpenRTB Version: {$version}\n";

        // Build request based on version
        $requestBuilder = $factory->createRequestBuilder();
        $requestId = 'ssp-req-' . uniqid('', true);

        if ($version === '3.0') {
            // Build OpenRTB 3.0 request
            $request = $requestBuilder
                ->setId($requestId)
                ->setTmax(100)
                ->addItem(
                    (new \OpenRTB\v3\Impression\Item())
                        ->setId('item-1')
                        ->setQty(1)
                        ->setFlr($publisherRequest['floor_price'])
                        ->setFlrcur('USD')
                        ->setSpec(
                            (new \OpenRTB\v3\Impression\Spec())
                                ->setPlacement(
                                    (new \OpenRTB\v3\Placement\Placement())
                                        ->setTagid($publisherRequest['placement_id'])
                                        ->setDisplay(
                                            (new \OpenRTB\v3\Placement\DisplayPlacement())
                                                ->setW($publisherRequest['size']['width'])
                                                ->setH($publisherRequest['size']['height'])
                                        )
                                )
                        )
                )
                ->setContext(
                    (new \OpenRTB\v3\Context\Context())
                        ->setSite(
                            (new \OpenRTB\v3\Context\Site())
                                ->setDomain($publisherRequest['site']['domain'])
                                ->setPage($publisherRequest['site']['page'])
                        )
                        ->setDevice(
                            (new \OpenRTB\v3\Context\Device())
                                ->setUa($publisherRequest['device']['ua'])
                                ->setIp($publisherRequest['device']['ip'])
                        )
                )();

        } else {
            // Build OpenRTB 2.6 request
            $request = $requestBuilder
                ->setId($requestId)
                ->setTmax(100)
                ->addImp(
                    (new \OpenRTB\v26\Impression\Imp())
                        ->setId('imp-1')
                        ->setBanner(
                            (new \OpenRTB\v26\Impression\Banner())
                                ->setW($publisherRequest['size']['width'])
                                ->setH($publisherRequest['size']['height'])
                                ->setPos(1)
                        )
                )
                ->setSite(
                    (new \OpenRTB\v26\Context\Site())
                        ->setDomain($publisherRequest['site']['domain'])
                        ->setPage($publisherRequest['site']['page'])
                )
                ->setDevice(
                    (new \OpenRTB\v26\Context\Device())
                        ->setUa($publisherRequest['device']['ua'])
                        ->setIp($publisherRequest['device']['ip'])
                )();
        }

        $requestJson = $request->toJson();
        echo "Request size: " . strlen($requestJson) . " bytes\n";

        // Simulate sending HTTP request to DSP
        // In production: $responseJson = sendHttpPost("https://{$dspName}.com/bid", $requestJson);
        $responseJson = simulateDspResponse($dspName, $version, $requestId);

        if ($responseJson) {
            // Parse DSP response
            $parser = $factory->createParser();
            $response = $parser->parseBidResponse($responseJson);

            // Extract bid information
            $seatbids = $response->getSeatbid();
            if ($seatbids && count($seatbids) > 0) {
                $bids = $seatbids[0]->getBid();
                if ($bids && count($bids) > 0) {
                    $bid = $bids[0];
                    $bidPrice = $bid->getPrice();

                    if ($bidPrice && $bidPrice >= $publisherRequest['floor_price']) {
                        $bidResponses[$dspName] = [
                            'dsp' => $dspName,
                            'bid_id' => $bid->getId(),
                            'price' => $bidPrice,
                            'version' => $version,
                        ];
                        echo "✓ Received bid: \${$bidPrice}\n";
                    } else {
                        echo "✗ Bid below floor price\n";
                    }
                } else {
                    echo "✗ No bids in response\n";
                }
            } else {
                echo "✗ No seat bids in response\n";
            }
        } else {
            echo "✗ No response from DSP\n";
        }

    } catch (\Exception $e) {
        echo "✗ Error: {$e->getMessage()}\n";
    }

    echo "\n";
}

// ============================================================================
// Step 4: Select winning bid
// ============================================================================

echo "Step 3: Selecting Winning Bid\n";
echo str_repeat('=', 60) . "\n";

if (empty($bidResponses)) {
    echo "No valid bids received - serving default ad\n";
} else {
    // Select highest bid
    usort($bidResponses, function ($a, $b) {
        return $b['price'] <=> $a['price'];
    });

    $winner = $bidResponses[0];

    echo "Winner: {$winner['dsp']}\n";
    echo "Bid Price: \${$winner['price']}\n";
    echo "Bid ID: {$winner['bid_id']}\n";
    echo "OpenRTB Version: {$winner['version']}\n";
    echo "\nAll bids received:\n";

    foreach ($bidResponses as $bid) {
        echo "  - {$bid['dsp']}: \${$bid['price']}\n";
    }
}

echo "\n=== SSP Integration Example Complete ===\n";

// ============================================================================
// Helper function to simulate DSP responses
// ============================================================================

function simulateDspResponse(string $dspName, string $version, string $requestId): string
{
    // Simulate different bid prices from different DSPs
    $bidPrices = [
        'dsp_partner_a' => 2.50,
        'dsp_partner_b' => 2.75,
        'dsp_partner_c' => 2.25,
    ];

    $price = $bidPrices[$dspName] ?? 2.00;

    if ($version === '3.0') {
        // OpenRTB 3.0 response format
        return json_encode([
            'id' => $requestId,
            'bidid' => 'resp-' . uniqid('', true),
            'cur' => 'USD',
            'seatbid' => [
                [
                    'seat' => "{$dspName}-seat",
                    'bid' => [
                        [
                            'id' => 'bid-' . uniqid('', true),
                            'item' => 'item-1',
                            'price' => $price,
                            'media' => [
                                'ad' => [
                                    'adomain' => ['advertiser.com'],
                                    'display' => [
                                        'banner' => [
                                            'img' => 'https://cdn.advertiser.com/ad.jpg',
                                            'w' => 300,
                                            'h' => 250,
                                            'link' => [
                                                'url' => 'https://advertiser.com/product'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

// OpenRTB 2.6 response format
    return json_encode([
        'id' => $requestId,
        'bidid' => 'resp-' . uniqid('', true),
        'cur' => 'USD',
        'seatbid' => [
            [
                'seat' => "{$dspName}-seat",
                'bid' => [
                    [
                        'id' => 'bid-' . uniqid('', true),
                        'impid' => 'imp-1',
                        'price' => $price,
                        'adm' => '<a href="https://advertiser.com"><img src="https://cdn.advertiser.com/ad.jpg" alt=""/></a>',
                        'adid' => 'creative-123',
                        'w' => 300,
                        'h' => 250,
                    ]
                ]
            ]
        ]
    ], JSON_THROW_ON_ERROR);
}
