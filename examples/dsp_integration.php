<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\Factory\ProviderRegistry;

/**
 * DSP Integration Example
 *
 * This demonstrates how a DSP (Demand Side Platform) receives bid requests
 * from SSPs and responds with bids using the Factory pattern.
 *
 * Flow:
 * 1. Receive incoming bid request JSON from SSP
 * 2. Parse and validate the request
 * 3. Evaluate if we want to bid
 * 4. Build and return bid response
 */

echo "=== DSP Integration Example ===\n\n";

// ============================================================================
// Configuration: Register your SSP partners and their OpenRTB versions
// ============================================================================

$registry = ProviderRegistry::getInstance();
$registry->registerBatch([
    'epom' => '3.0',
    'dianomi' => '2.6',
    'rubicon' => '2.6',
    'google' => '2.6',
]);

// ============================================================================
// Scenario 1: Handle incoming bid request from Epom (OpenRTB 3.0)
// ============================================================================

echo "Scenario 1: Epom Bid Request (OpenRTB 3.0)\n";
echo str_repeat('-', 60) . "\n";

// Simulate incoming bid request from Epom
$epomRequestJson = json_encode([
    'id' => 'epom-req-12345',
    'tmax' => 100,
    'item' => [
        [
            'id' => 'item-1',
            'qty' => 1,
            'flr' => 1.50,
            'flrcur' => 'USD',
            'spec' => [
                'placement' => [
                    'tagid' => 'banner-300x250',
                    'display' => [
                        'w' => 300,
                        'h' => 250,
                    ]
                ]
            ]
        ]
    ],
    'context' => [
        'site' => [
            'domain' => 'example.com',
            'page' => 'https://example.com/article'
        ],
        'device' => [
            'ua' => 'Mozilla/5.0...',
            'ip' => '192.168.1.1'
        ]
    ]
]);

// Create factory for Epom
$factory = OpenRTBFactory::forProvider('epom');
echo "Using OpenRTB version: {$factory->getVersion()}\n";

// Parse incoming request
$parser = $factory->createParser();
$request = $parser->parseBidRequest($epomRequestJson);

echo "Request ID: {$request->getId()}\n";
echo "Timeout: {$request->getTmax()}ms\n";

$items = $request->getItem();
if ($items && count($items) > 0) {
    $item = $items[0];
    echo "Item ID: {$item->getId()}\n";
    echo "Floor Price: \${$item->getFlr()}\n";
}

// Validate request
$validator = $factory->createValidator();
if ($factory->getVersion() === '3.0') {
    $validator->validateRequest($request);
} else {
    $validator->validateBidRequest($request);
}

if ($validator->hasErrors()) {
    echo "Invalid request: " . $validator->getFirstError() . "\n";
    // Return no-bid response
    exit;
}

// Decision logic: Do we want to bid?
$bidPrice = 2.50; // Our bid price
$itemFloorPrice = $items[0]->getFlr();

if ($bidPrice < $itemFloorPrice) {
    echo "Our bid (\${$bidPrice}) is below floor (\${$itemFloorPrice}) - No bid\n\n";

    // Build no-bid response
    $responseBuilder = $factory->createResponseBuilder($request->getId());
    $responseBuilder->setNobid();
    $response = $responseBuilder();

    echo "Response JSON:\n";
    echo json_encode($response->toArray(), JSON_PRETTY_PRINT) . "\n\n";
} else {
    echo "Bidding \${$bidPrice} (floor: \${$itemFloorPrice})\n";

    // Build bid response using v3 structures
    $seatbid = (new \OpenRTB\v3\Bid\Seatbid())
        ->setSeat('my-dsp-seat')
        ->addBid(
            (new \OpenRTB\v3\Bid\Bid())
                ->setId('bid-' . uniqid('', true))
                ->set('item', 'item-1')  // Use generic set() for item field
                ->setPrice($bidPrice)
                ->setMedia(
                    (new \OpenRTB\v3\Bid\Media())
                        ->setAd(
                            (new \OpenRTB\v3\Bid\Ad())
                                ->setAdomain(['advertiser.com'])
                                ->setDisplay(
                                    (new \OpenRTB\v3\Bid\Display())
                                        ->setBanner(
                                            (new \OpenRTB\v3\Bid\Display\Banner())
                                                ->setImg('https://cdn.example.com/ad.jpg')
                                                ->setW(300)
                                                ->setH(250)
                                                ->setLink(
                                                    (new \OpenRTB\v3\Bid\Link())
                                                        ->setUrl('https://advertiser.com/click')
                                                )
                                        )
                                )
                        )
                )
        );

    $responseBuilder = $factory->createResponseBuilder($request->getId());
    $response = (new \OpenRTB\v3\BidResponse())
        ->setId($request->getId())
        ->setBidid('resp-' . uniqid('', true))
        ->setCur('USD')
        ->setSeatbid([$seatbid]);

    echo "Response JSON:\n";
    echo json_encode($response->toArray(), JSON_PRETTY_PRINT) . "\n\n";
}

// ============================================================================
// Scenario 2: Handle incoming bid request from Dianomi (OpenRTB 2.6)
// ============================================================================

echo "Scenario 2: Dianomi Bid Request (OpenRTB 2.6)\n";
echo str_repeat('-', 60) . "\n";

// Simulate incoming bid request from Dianomi
$dianomiRequestJson = json_encode([
    'id' => 'dianomi-req-67890',
    'tmax' => 150,
    'imp' => [
        [
            'id' => 'imp-1',
            'banner' => [
                'w' => 728,
                'h' => 90,
                'pos' => 1
            ]
        ]
    ],
    'site' => [
        'domain' => 'news.example.com',
        'page' => 'https://news.example.com/article'
    ],
    'device' => [
        'ua' => 'Mozilla/5.0...',
        'ip' => '192.168.1.2'
    ]
]);

// Create factory for Dianomi
$factory = OpenRTBFactory::forProvider('dianomi');
echo "Using OpenRTB version: {$factory->getVersion()}\n";

// Parse incoming request
$parser = $factory->createParser();
$request = $parser->parseBidRequest($dianomiRequestJson);

echo "Request ID: {$request->getId()}\n";
echo "Timeout: {$request->getTmax()}ms\n";

$imps = $request->getImp();
if ($imps && count($imps) > 0) {
    $imp = $imps[0];
    echo "Impression ID: {$imp->getId()}\n";

    $banner = $imp->getBanner();
    if ($banner) {
        echo "Banner Size: {$banner->getW()}x{$banner->getH()}\n";
    }
}

// Validate request
$validator = $factory->createValidator();
if ($factory->getVersion() === '3.0') {
    $validator->validateRequest($request);
} else {
    $validator->validateBidRequest($request);
}

if ($validator->hasErrors()) {
    echo "Invalid request: " . $validator->getFirstError() . "\n\n";
    exit;
}

// Build successful bid response using v2.6 structures
$bidPrice = 3.25;
echo "Bidding \${$bidPrice}\n";

$responseBuilder = $factory->createResponseBuilder($request->getId());
$responseBuilder
    ->setCur('USD')
    ->addSeatBid(
        (new \OpenRTB\v26\Response\SeatBid())
            ->setSeat('my-dsp-seat')
            ->setBid([
                (new \OpenRTB\v26\Response\Bid())
                    ->setId('bid-' . uniqid('', true))
                    ->setImpid('imp-1')
                    ->setPrice($bidPrice)
                    ->setAdm('<a href="https://advertiser.com"><img src="https://cdn.example.com/ad-728x90.jpg" alt=""/></a>')
                    ->setAdid('creative-123')
                    ->setW(728)
                    ->setH(90)
            ])
    );

$response = $responseBuilder();

echo "Response JSON:\n";
echo json_encode($response->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// ============================================================================
// Scenario 3: Dynamic SSP handling
// ============================================================================

echo "Scenario 3: Dynamic SSP Detection\n";
echo str_repeat('-', 60) . "\n";

/**
 * In production, you'd detect the SSP from HTTP headers, URL path, or request data
 */
function handleBidRequest(string $sspName, string $requestJson): void
{
    echo "Processing request from: {$sspName}\n";

    try {
        $factory = OpenRTBFactory::forProvider($sspName);
        echo "Detected OpenRTB version: {$factory->getVersion()}\n";

        $parser = $factory->createParser();
        $request = $parser->parseBidRequest($requestJson);

        echo "Successfully parsed request: {$request->getId()}\n";

        // Your bidding logic here...

    } catch (\InvalidArgumentException $e) {
        echo "Error: {$e->getMessage()}\n";
    }

    echo "\n";
}

// Simulate requests from different SSPs
handleBidRequest('epom', '{"id":"req-1","item":[]}');
handleBidRequest('dianomi', '{"id":"req-2","imp":[]}');
handleBidRequest('rubicon', '{"id":"req-3","imp":[]}');

echo "=== DSP Integration Example Complete ===\n";
