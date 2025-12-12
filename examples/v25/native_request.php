<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Geo;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Native;
use OpenRTB\v25\Impression\Native\NativeRequest;
use OpenRTB\v25\Impression\Native\TitleAsset;
use OpenRTB\v25\Impression\Native\ImageAsset;
use OpenRTB\v25\Impression\Native\DataAsset;

echo "OpenRTB 2.5 - Native Ad Request Example\n";
echo str_repeat('=', 50) . "\n\n";

// Create factory for OpenRTB 2.5
$factory = new OpenRTBFactory('2.5');
$builder = $factory->createRequestBuilder();

// NEW APPROACH: Build Native Request using Objects
echo "Building Native Request with Type-Safe Objects:\n";
echo str_repeat('-', 50) . "\n";

$nativeRequest = new NativeRequest();
$nativeRequest->setVer('1.2');
$nativeRequest->setContext(1);      // Content-centric
$nativeRequest->setPlcmttype(1);    // In-feed

// Add Title asset (required)
$nativeRequest->addAsset(
    new TitleAsset(
        id: 1,
        len: 90,
        required: true
    )
);
echo "  ✓ Added Title asset (max 90 chars)\n";

// Add Main Image asset (required)
$mainImage = new ImageAsset(
    id: 2,
    type: ImageAsset::TYPE_MAIN,
    wmin: 300,
    hmin: 250,
    required: true
);
$mainImage->setMimes(['image/jpeg', 'image/png']);
$nativeRequest->addAsset($mainImage);
echo "  ✓ Added Main Image (300x250+)\n";

// Add Icon (optional)
$nativeRequest->addAsset(
    new ImageAsset(
        id: 3,
        type: ImageAsset::TYPE_ICON,
        wmin: 50,
        hmin: 50,
        required: false
    )
);
echo "  ✓ Added Icon (50x50+)\n";

// Add Sponsored By text (optional)
$nativeRequest->addAsset(
    new DataAsset(
        id: 4,
        type: DataAsset::TYPE_SPONSORED,
        len: 25,
        required: false
    )
);
echo "  ✓ Added Sponsored By text\n";

// Add Description (optional)
$nativeRequest->addAsset(
    new DataAsset(
        id: 5,
        type: DataAsset::TYPE_DESC,
        len: 140,
        required: false
    )
);
echo "  ✓ Added Description text\n";

// Add Call-to-Action (required)
$nativeRequest->addAsset(
    new DataAsset(
        id: 6,
        type: DataAsset::TYPE_CTATEXT,
        len: 15,
        required: true
    )
);
echo "  ✓ Added Call-to-Action text\n\n";

echo "Total assets: " . count($nativeRequest->getAssets()) . "\n\n";

// Create Native object - it auto-converts the object to JSON!
$native = new Native();
$native->setRequest($nativeRequest);  // ✨ Magic: auto-serializes to JSON!
$native->setVer('1.2');
$native->setApi([3, 5]); // MRAID support
$native->setBattr([1, 2, 3]); // Blocked creative attributes

echo "Native object created with automatic JSON serialization\n\n";

// Create impression
$imp = new Imp();
$imp->setId('imp-1');
$imp->setNative($native);
$imp->setBidfloor(1.50);
$imp->setBidfloorcur('USD');
$imp->setSecure(1);
$imp->setTagid('native-placement-123');

// Build a complete bid request
$request = $builder
    ->setId('native-req-' . uniqid())
    ->setTest(0)
    ->setTmax(200)
    ->setCur(['USD'])();

// Add site information
$site = new Site();
$site->setId('site-123');
$site->setName('Example Publisher');
$site->setDomain('example.com');
$site->setPage('https://example.com/article');
$site->setCat(['IAB1', 'IAB12']); // Arts & Entertainment, News
$request->setSite($site);

// Add device information
$device = new Device();
$device->setUa('Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)');
$device->setIp('192.168.1.1');
$device->setDevicetype(4); // Phone
$device->setMake('Apple');
$device->setModel('iPhone 12');
$device->setOs('iOS');

// Add geo information
$geo = new Geo();
$geo->setCountry('USA');
$geo->setRegion('CA');
$geo->setCity('San Francisco');
$geo->setZip('94102');
$device->setGeo($geo);

$request->setDevice($device);

// Add impression
$request->addImp($imp);

// Display the JSON
echo "Generated Bid Request:\n";
echo str_repeat('=', 50) . "\n";
echo $request->toJson(JSON_PRETTY_PRINT) . "\n\n";

// Show the native request details
echo "Native Request (decoded for viewing):\n";
echo str_repeat('=', 50) . "\n";
$nativeJson = $native->getRequest();
$nativeData = json_decode($nativeJson, true);
echo json_encode($nativeData, JSON_PRETTY_PRINT) . "\n\n";

// Validate the request
$validator = $factory->createValidator();
$isValid = $validator->validateBidRequest($request);

if ($isValid) {
    echo "✓ Bid request is valid!\n\n";
} else {
    echo "✗ Validation errors:\n";
    foreach ($validator->getErrors() as $error) {
        echo "  - $error\n";
    }
    echo "\n";
}

echo str_repeat('=', 50) . "\n";
echo "Benefits of Object-Based Approach:\n";
echo str_repeat('=', 50) . "\n";
echo "  ✓ Type-safe - IDE autocomplete works\n";
echo "  ✓ Named constants - ImageAsset::TYPE_MAIN vs magic number 3\n";
echo "  ✓ Named parameters - Clear what each value means\n";
echo "  ✓ Auto-serialization - No manual json_encode() needed\n";
echo "  ✓ Easy to understand - Self-documenting code\n";
echo "  ✓ Refactoring-safe - Rename with confidence\n\n";

echo "Compare with array approach (see native_request_array.php)\n";
