<?php

declare(strict_types=1);

// This assumes you have a `vendor/autoload.php` file.
// Adjust the path if your project structure is different.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Util\RequestBuilder;

/**
 * This file provides examples of how to use the BidRequestBuilder to construct
 * valid OpenRTB 2.6 BidRequest objects.
 */

echo "Running OpenRTB 2.6 BidRequestBuilder Examples...\n\n";

// For demonstration purposes, we'll create some common objects.
// In a real application, these would be populated with actual request data.
$device = new Device();
$device->setIp('123.145.167.189');
$device->setUa('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36');

$user = new User();
$user->setId('ab382f34-b927-44c6-a8a5-039f544b2973');

$regs = new Regs();
$regs->setGdpr(1);

$imp = new Imp();
$imp->setId('1');
$imp->setBanner(new Banner()); // Assuming a Banner object exists and can be instantiated

// =============================================================================
// Example 1: Building a Bid Request for a website (Site)
// =============================================================================

echo "--- Example 1: Site-based Bid Request ---\n";

$site = new Site();
$site->setId('102855');
$site->setPage('http://www.example.com/index.html');
$site->setDomain('example.com');

try {
    $siteRequestBuilder = new RequestBuilder();

    $siteBidRequest = $siteRequestBuilder
        ->setSite($site)
        ->addImp($imp)
        ->setDevice($device)
        ->setUser($user)
        ->setRegs($regs)
        ->setAt(AuctionType::SECOND_PRICE_PLUS)
        ->setTmax(200)
        ->setCur(['USD'])
        ->setBcat(['IAB25', 'IAB7-39'])
        ->setTest(1)(); // 1 = Test mode is enabled, () invokes the builder

    // The BidRequest object implements JsonSerializable for direct encoding.
    echo json_encode($siteBidRequest->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    echo "\n\n";

} catch (\Exception $e) {
    echo "Error building site-based request: " . $e->getMessage() . "\n\n";
}

// =============================================================================
// Example 2: Building a Bid Request for a mobile application (App)
// =============================================================================

echo "--- Example 2: App-based Bid Request ---\n";

$app = new App();
$app->setId('ag9zfmFkZGl6enlyEQsSBExpY2Vuc2UiNDI1MzkzMTA5OTQ0MjE3Ngw');
$app->setName('Example App');
$app->setBundle('com.example.app');
$app->setDomain('example.com');

try {
    $appRequestBuilder = new RequestBuilder();

    // Note that calling setApp() will automatically nullify any previously set Site object.
    $appBidRequest = $appRequestBuilder
        ->setApp($app)
        ->addImp($imp)
        ->setDevice($device)
        ->setUser($user)
        ->setRegs($regs)
        ->setAt(AuctionType::FIRST_PRICE)
        ->setTmax(150)
        ->setCur(['USD'])
        ->setBadv(['apple.com'])
        ->setTest(0)(); // 0 = Test mode is disabled (production), () invokes the builder

    echo json_encode($appBidRequest->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    echo "\n\n";

} catch (\Exception $e) {
    echo "Error building app-based request: " . $e->getMessage() . "\n\n";
}