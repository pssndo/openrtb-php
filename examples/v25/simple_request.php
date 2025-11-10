<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Enums\AuctionType;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Imp;

echo "OpenRTB 2.5 - Simple Bid Request Example\n";
echo str_repeat('=', 50) . "\n\n";

// Create request
$request = new BidRequest();
$request->setId('req-' . uniqid());
$request->setTest(0);
$request->setAt(AuctionType::FIRST_PRICE);
$request->setTmax(150);
$request->setCur(['USD']);

// Add site
$site = new Site();
$site->setId('site-123');
$site->setDomain('example.com');
$request->setSite($site);

// Add device
$device = new Device();
$device->setUa('Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
$device->setIp('192.168.1.1');
$request->setDevice($device);

// Add impression with banner
$banner = new Banner();
$banner->setW(300);
$banner->setH(250);

$imp = new Imp();
$imp->setId('imp-1');
$imp->setBanner($banner);
$imp->setBidfloor(1.0);
$request->addImp($imp);

// Output
echo "Generated Bid Request:\n";
echo $request->toJson(JSON_PRETTY_PRINT) . "\n\n";

echo "✓ OpenRTB 2.5 request created successfully!\n";
