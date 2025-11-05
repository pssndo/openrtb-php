<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\Factory\ProviderRegistry;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;

/**
 * Example: Complete bidding workflow for AdTech company
 *
 * This demonstrates how to handle bid requests to multiple exchanges
 * that use different OpenRTB versions
 */

// ============================================================================
// Step 1: Setup - Configure your provider mappings
// ============================================================================

$registry = ProviderRegistry::getInstance();
$registry->registerBatch([
    'epom' => '3.0',
    'dianomi' => '2.6',
    'rubicon' => '2.6',
    'appnexus' => '2.5', // Will map to 2.6
]);

// ============================================================================
// Step 2: Simulate incoming ad request from your client
// ============================================================================

$incomingAdRequest = [
    'placement_id' => 'banner-300x250',
    'user_id' => 'user-12345',
    'device_type' => 'mobile',
    'floor_price' => 1.50,
];

// ============================================================================
// Step 3: Determine which exchanges to bid with
// ============================================================================

$clientExchanges = [
    ['name' => 'epom', 'timeout' => 100],
    ['name' => 'dianomi', 'timeout' => 150],
];

echo "Processing ad request for placement: {$incomingAdRequest['placement_id']}\n";
echo "Sending bid requests to: " . implode(', ', array_column($clientExchanges, 'name')) . "\n\n";

// ============================================================================
// Step 4: Send bid requests to each exchange
// ============================================================================

$bidResponses = [];

foreach ($clientExchanges as $exchange) {
    $exchangeName = $exchange['name'];
    echo str_repeat('=', 60) . "\n";
    echo "Exchange: {$exchangeName}\n";
    echo str_repeat('=', 60) . "\n";

    try {
        // Create factory for this specific exchange
        $factory = OpenRTBFactory::forProvider($exchangeName);
        $version = $factory->getVersion();

        echo "OpenRTB Version: {$version}\n";

        // Build request based on OpenRTB version
        if ($version === '3.0') {
            $response = sendBidRequestV3($factory, $incomingAdRequest, $exchange);
        } else {
            $response = sendBidRequestV26($factory, $incomingAdRequest, $exchange);
        }

        if ($response) {
            $bidResponses[$exchangeName] = $response;
            echo "✓ Received bid response\n";
        } else {
            echo "✗ No bid\n";
        }

    } catch (Exception $e) {
        echo "✗ Error: {$e->getMessage()}\n";
    }

    echo "\n";
}

// ============================================================================
// Step 5: Select winning bid
// ============================================================================

echo str_repeat('=', 60) . "\n";
echo "Selecting winning bid\n";
echo str_repeat('=', 60) . "\n";

$winningBid = selectWinningBid($bidResponses);

if ($winningBid) {
    echo "Winner: {$winningBid['exchange']}\n";
    echo "Price: \${$winningBid['price']}\n";
    echo "Creative: {$winningBid['creative']}\n";
} else {
    echo "No winning bid - returning default ad\n";
}

// ============================================================================
// Helper functions
// ============================================================================

/**
 * Build and send OpenRTB 3.0 bid request
 */
function sendBidRequestV3(OpenRTBFactory $factory, array $adRequest, array $exchange): ?array
{
    $builder = $factory->createRequestBuilder();

    // Build OpenRTB 3.0 request
    $request = $builder
        ->setId('req-' . uniqid('', true))
        ->setTmax($exchange['timeout'])
        ->addItem(
            (new Item())
                ->setId('item-1')
                ->setQty(1)
                ->setFlr($adRequest['floor_price'])
                ->setFlrcur('USD')
                ->setSpec(
                    (new Spec())
                        ->setPlacement(
                            (new Placement())
                                ->setTagid($adRequest['placement_id'])
                                ->setDisplay(
                                    (new DisplayPlacement())
                                        ->setW(300)
                                        ->setH(250)
                                )
                        )
                )
        )();

    $requestJson = $request->toJson();
    echo "Request sent: " . strlen($requestJson) . " bytes\n";

    // Simulate API call to exchange
    $responseJson = simulateExchangeResponse($exchange['name'], '3.0', $request->getId());

    // Parse response
    $parser = $factory->createParser();
    $response = $parser->parseBidResponse($responseJson);

    // Extract bid information
    $seatbids = $response->getSeatbid();
    if ($seatbids && count($seatbids) > 0) {
        $bids = $seatbids[0]->getBid();
        if ($bids && count($bids) > 0) {
            $bid = $bids[0];
            return [
                'exchange' => $exchange['name'],
                'price' => $bid->getPrice(),
                'creative' => 'OpenRTB 3.0 Bid',
                'bid_id' => $bid->getId(),
            ];
        }
    }

    return null;
}

/**
 * Build and send OpenRTB 2.6 bid request
 */
function sendBidRequestV26(OpenRTBFactory $factory, array $adRequest, array $exchange): ?array
{
    $builder = $factory->createRequestBuilder();

    // Build OpenRTB 2.6 request
    $request = $builder
        ->setId('req-' . uniqid('', true))
        ->setTmax($exchange['timeout'])
        ->addImp(
            (new Imp())
                ->setId('imp-1')
                ->setBanner(
                    (new Banner())
                        ->setW(300)
                        ->setH(250)
                )
        )();

    $requestJson = $request->toJson();
    echo "Request sent: " . strlen($requestJson) . " bytes\n";

    // Simulate API call to exchange
    $responseJson = simulateExchangeResponse($exchange['name'], '2.6', $request->getId());

    // Parse response
    $parser = $factory->createParser();
    $response = $parser->parseBidResponse($responseJson);

    // Extract bid information
    $seatbids = $response->getSeatbid();
    if ($seatbids && count($seatbids) > 0) {
        $bids = $seatbids[0]->getBid();
        if ($bids && count($bids) > 0) {
            $bid = $bids[0];
            return [
                'exchange' => $exchange['name'],
                'price' => $bid->getPrice(),
                'creative' => $bid->getAdm() ?? 'N/A',
                'bid_id' => $bid->getId(),
            ];
        }
    }

    return null;
}

/**
 * Simulate exchange response (in real code, this would be an HTTP request)
 */
function simulateExchangeResponse(string $exchange, string $version, string $requestId): string
{
    // Simulate different bid prices from different exchanges
    $prices = [
        'epom' => 2.50,
        'dianomi' => 2.75,
        'rubicon' => 2.25,
    ];

    $price = $prices[$exchange] ?? 2.00;

    if ($version === '3.0') {
        return json_encode([
            'id' => $requestId,
            'seatbid' => [
                [
                    'seat' => "{$exchange}-seat",
                    'bid' => [
                        [
                            'id' => 'bid-' . uniqid('', true),
                            'item' => 'item-1',
                            'price' => $price,
                            'adm' => "<html lang='en'><body>Ad from {$exchange}</body></html>",
                        ]
                    ]
                ]
            ]
        ]);
    }

    return json_encode([
        'id' => $requestId,
        'seatbid' => [
            [
                'seat' => "{$exchange}-seat",
                'bid' => [
                    [
                        'id' => 'bid-' . uniqid('', true),
                        'impid' => 'imp-1',
                        'price' => $price,
                        'adm' => "<html lang='en'><body>Ad from {$exchange}</body></html>",
                    ]
                ]
            ]
        ]
    ]);
}

/**
 * Select the highest paying bid
 */
function selectWinningBid(array $bidResponses): ?array
{
    $maxPrice = 0;
    $winner = null;

    foreach ($bidResponses as $bid) {
        if ($bid['price'] > $maxPrice) {
            $maxPrice = $bid['price'];
            $winner = $bid;
        }
    }

    return $winner;
}
