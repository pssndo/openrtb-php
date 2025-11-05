<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\Factory\ProviderRegistry;

// ============================================================================
// Example 1: Basic usage by provider name
// ============================================================================

echo "Example 1: Integration with Epom (OpenRTB 3.0)\n";
echo str_repeat('=', 60) . "\n";

// Create factory for Epom (automatically uses OpenRTB 3.0)
$epomFactory = OpenRTBFactory::forProvider('epom');
$epomBuilder = $epomFactory->createRequestBuilder();
$epomParser = $epomFactory->createParser();

echo "Provider: Epom\n";
echo "OpenRTB Version: " . $epomFactory->getVersion() . "\n";
echo "Builder: " . get_class($epomBuilder) . "\n";
echo "Parser: " . get_class($epomParser) . "\n\n";

// ============================================================================
// Example 2: Integration with Dianomi (OpenRTB 2.6)
// ============================================================================

echo "Example 2: Integration with Dianomi (OpenRTB 2.6)\n";
echo str_repeat('=', 60) . "\n";

$dianomiFactory = OpenRTBFactory::forProvider('dianomi');
$dianomiBuilder = $dianomiFactory->createRequestBuilder();

echo "Provider: Dianomi\n";
echo "OpenRTB Version: " . $dianomiFactory->getVersion() . "\n";
echo "Builder: " . get_class($dianomiBuilder) . "\n\n";

// ============================================================================
// Example 3: Direct version usage (when you know the version)
// ============================================================================

echo "Example 3: Direct version usage\n";
echo str_repeat('=', 60) . "\n";

$factory26 = new OpenRTBFactory('2.6');
$factory30 = new OpenRTBFactory('3.0');

echo "Version 2.6 Builder: " . get_class($factory26->createRequestBuilder()) . "\n";
echo "Version 3.0 Builder: " . get_class($factory30->createRequestBuilder()) . "\n\n";

// ============================================================================
// Example 4: Register custom providers
// ============================================================================

echo "Example 4: Register custom providers\n";
echo str_repeat('=', 60) . "\n";

$registry = ProviderRegistry::getInstance();

// Register your custom providers
$registry->register('myCustomExchange', '3.0');
$registry->register('legacyExchange', '2.5'); // Will map to 2.6

// Now use them
$customFactory = OpenRTBFactory::forProvider('myCustomExchange');
echo "Custom Exchange Version: " . $customFactory->getVersion() . "\n";

$legacyFactory = OpenRTBFactory::forProvider('legacyExchange');
echo "Legacy Exchange Version: " . $legacyFactory->getVersion() . " (2.5 mapped to 2.6)\n\n";

// ============================================================================
// Example 5: Full integration flow (Epom - OpenRTB 3.0)
// ============================================================================

echo "Example 5: Complete Epom integration flow\n";
echo str_repeat('=', 60) . "\n";

// 1. Create factory for Epom
$factory = OpenRTBFactory::forProvider('epom');

// 2. Build a bid request
$builder = $factory->createRequestBuilder();
$request = $builder
    ->setId('request-' . uniqid('', true))
    ->setTmax(100)
    ->addItem(
        (new \OpenRTB\v3\Impression\Item())
            ->setId('item-1')
            ->setQty(1)
            ->setFlr(1.0)
            ->setSpec(
                (new \OpenRTB\v3\Impression\Spec())
                    ->setPlacement(
                        (new \OpenRTB\v3\Placement\Placement())
                            ->setTagid('placement-123')
                            ->setDisplay(
                                (new \OpenRTB\v3\Placement\DisplayPlacement())
                                    ->setW(300)
                                    ->setH(250)
                            )
                    )
            )
    )();

echo "Request ID: " . $request->getId() . "\n";
echo "Request JSON:\n" . json_encode($request->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// 3. Parse bid response from Epom
$responseJson = json_encode([
    'id' => $request->getId(),
    'seatbid' => [
        [
            'seat' => 'epom-seat-1',
            'bid' => [
                [
                    'id' => 'bid-1',
                    'item' => 'item-1',
                    'price' => 2.50,
                    'adm' => '<html lang="">Ad markup</html>',
                ]
            ]
        ]
    ]
]);

$parser = $factory->createParser();
$response = $parser->parseBidResponse($responseJson);

echo "Response ID: " . $response->getId() . "\n";
$seatbids = $response->getSeatbid();
if ($seatbids && count($seatbids) > 0) {
    echo "First Seat: " . $seatbids[0]->getSeat() . "\n";
}
echo "\n";

// ============================================================================
// Example 6: Dynamic provider selection from config/database
// ============================================================================

echo "Example 6: Dynamic provider selection\n";
echo str_repeat('=', 60) . "\n";

// Simulate getting provider from config or database
$clientIntegrations = [
    ['client_id' => 1, 'provider' => 'epom', 'status' => 'active'],
    ['client_id' => 2, 'provider' => 'dianomi', 'status' => 'active'],
    ['client_id' => 3, 'provider' => 'rubicon', 'status' => 'active'],
];

foreach ($clientIntegrations as $integration) {
    $factory = OpenRTBFactory::forProvider($integration['provider']);

    echo "Client #{$integration['client_id']}: {$integration['provider']} ";
    echo "(OpenRTB {$factory->getVersion()})\n";
}
echo "\n";

// ============================================================================
// Example 7: Error handling
// ============================================================================

echo "Example 7: Error handling\n";
echo str_repeat('=', 60) . "\n";

try {
    $factory = OpenRTBFactory::forProvider('unknownProvider');
} catch (\InvalidArgumentException $e) {
    echo "Caught expected error: " . $e->getMessage() . "\n";
}

try {
    $factory = new OpenRTBFactory('1.0');
} catch (\InvalidArgumentException $e) {
    echo "Caught expected error: " . $e->getMessage() . "\n";
}
echo "\n";

// ============================================================================
// Example 8: Batch provider registration
// ============================================================================

echo "Example 8: Batch provider registration\n";
echo str_repeat('=', 60) . "\n";

$registry = ProviderRegistry::getInstance();
$registry->registerBatch([
    'smaato' => '2.6',
    'mopub' => '3.0',
    'inmobi' => '2.6',
    'unity' => '3.0',
]);

echo "Registered providers:\n";
foreach ($registry->getProviders() as $provider => $version) {
    echo "  - {$provider}: OpenRTB {$version}\n";
}
echo "\n";

echo "Examples completed successfully!\n";
