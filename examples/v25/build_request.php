<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Geo;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Enums\AuctionType;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Format;
use OpenRTB\v25\Impression\Imp;

echo "OpenRTB 2.5 - Building a Bid Request Example\n";
echo str_repeat('=', 50) . "\n\n";

// Create factory for OpenRTB 2.5
$factory = new OpenRTBFactory('2.5');
$builder = $factory->createRequestBuilder();

// Build a complete bid request
$request = $builder
    ->setId('example-req-' . uniqid())
    ->setTest(0)
    ->setAt(AuctionType::FIRST_PRICE)
    ->setTmax(200)
    ->setCur(['USD'])
    ->setBcat(['IAB25', 'IAB26'])(); // Block adult and illegal content, () invokes builder

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
$device->setUa('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
$device->setIp('192.168.1.1');
$device->setDeviceType(2); // Personal Computer
$device->setMake('Apple');
$device->setModel('MacBook Pro');
$device->setOs('macOS');

// Add geo information
$geo = new Geo();
$geo->setCountry('USA');
$geo->setRegion('CA');
$geo->setCity('San Francisco');
$geo->setZip('94102');
$device->setGeo($geo);

$request->setDevice($device);

// Add impression with banner
$banner = new Banner();
$banner->setW(728);
$banner->setH(90);

// Add multiple formats
$format1 = new Format();
$format1->setW(728);
$format1->setH(90);

$format2 = new Format();
$format2->setW(970);
$format2->setH(250);

$banner->setFormat([$format1, $format2]);
$banner->setPos(1); // Above the fold
$banner->setMimes(['image/jpeg', 'image/png', 'image/gif']);

$imp = new Imp();
$imp->setId('imp-1');
$imp->setBanner($banner);
$imp->setBidfloor(1.50); // Minimum CPM
$imp->setBidfloorcur('USD');
$imp->setSecure(1); // HTTPS required
$imp->setTagid('placement-123');

$request->addImp($imp);

// Display the JSON
echo "Generated Bid Request:\n";
echo $request->toJson(JSON_PRETTY_PRINT) . "\n\n";

// Validate the request
$validator = $factory->createValidator();
$isValid = $validator->validateBidRequest($request);

if ($isValid) {
    echo "✓ Bid request is valid!\n";
} else {
    echo "✗ Validation errors:\n";
    foreach ($validator->getErrors() as $error) {
        echo "  - $error\n";
    }
}

echo "\n" . str_repeat('=', 50) . "\n";
echo "OpenRTB 2.5 Key Features Demonstrated:\n";
echo "  • First-price auction type\n";
echo "  • Banner impressions with multiple formats\n";
echo "  • Site context with content categories\n";
echo "  • Device and geo targeting\n";
echo "  • Floor pricing\n";
echo "  • Content blocking (bcat)\n";
echo "  • HTTPS requirement (secure flag)\n";
