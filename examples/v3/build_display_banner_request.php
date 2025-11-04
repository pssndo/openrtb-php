<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Display Banner Request Example
 *
 * This example demonstrates how to construct a complete OpenRTB 3.0 Bid Request
 * for a display banner ad opportunity on a website.
 */

// In a real project, you would include Composer's autoloader.
// The path is adjusted to be relative to this file's location.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Geo;
use OpenRTB\v3\Context\Regs;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\ClickType;
use OpenRTB\v3\Enums\Placement\PlacementType;
use OpenRTB\v3\Enums\Placement\SizeUnit;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Util\RequestBuilder;

// --- 1. Define the Ad Placement Details ---

// Create the specific 'display' placement object
$displayPlacement = new DisplayPlacement();
$displayPlacement
    ->setPos(AdPosition::ABOVE_FOLD)
    ->setW(300)
    ->setH(250)
    ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)
    ->setMime(['image/jpeg', 'image/png'])
    ->setApi([ApiFramework::MRAID_2, ApiFramework::MRAID_3])
    ->setCtype([CreativeType::HTML])
    ->setClktype(ClickType::CLICKABLE)
    ->setPtype(PlacementType::IN_ATOMIC_UNIT);

// Create the generic 'placement' container
$placement = new Placement();
$placement
    ->setTagid('banner-slot-1')
    ->setDisplay($displayPlacement);

// Create the 'spec' object which holds the placement
$spec = new Spec();
$spec->setPlacement($placement);

// --- 2. Create the Impression Item ---

$item = new Item();
$item
    ->setId('1')
    ->setQty(1)
    ->setFlr(0.50)
    ->setFlrcur('USD')
    ->setSpec($spec);

// --- 3. Define the Context (Site, Device, User, Regs) ---

// Create Site object (where the ad will be shown)
$site = new Site();
$site
    ->setId('site123')
    ->setName('Example Site')
    ->setDomain('example.com')
    ->setPage('https://example.com/article/123')
    ->setCat(['IAB1']) // IAB Content Category: Arts & Entertainment
    ->setMobile(0);

// Create Device and Geo objects
$device = new Device();
$device
    ->setType(DeviceType::PC)
    ->setUa('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36')
    ->setIp('192.168.1.1')
    ->setLang('en')
    ->setJs(1);

$geo = new Geo();
$geo
    ->setCountry('USA')
    ->setRegion('CA')
    ->setCity('San Francisco');
$device->setGeo($geo);

// Create User object
$user = new User();
$user
    ->setId('user123')
    ->setGeo($geo);

// Create Regulations object
$regs = new Regs();
$regs
    ->setGdpr(1)
    ->setCoppa(0);

// Combine all context objects into the main Context object
$context = new Context();
$context
    ->setSite($site)
    ->setDevice($device)
    ->setUser($user)
    ->setRegs($regs);

// --- 4. Define the Source of the Request ---

$source = new Source();
$source
    ->setTid('transaction-' . uniqid('', true))
    ->setTs(time());

// --- 5. Build the BidRequest using the RequestBuilder ---

try {
    $builder = new RequestBuilder();
    $request = ($builder
        ->setTmax(100)
        ->setAt(AuctionType::SECOND_PRICE)
        ->setCur(['USD'])
        ->setSource($source)
        ->setContext($context)
        ->addItem($item))();

    // --- 6. Output the resulting JSON ---
    // In a real application, you would send this payload in an HTTP POST request.
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Exception $e) {
    header('Content-Type: text/plain; charset=utf-8', true, 500);
    echo "Error building BidRequest: " . $e->getMessage();
}
