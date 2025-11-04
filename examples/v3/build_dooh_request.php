<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Building a DOOH (Digital Out of Home) Request Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Context\{Geo};
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Dooh;
use OpenRTB\v3\Enums\{AuctionType};
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Impression\{Spec};
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Placement\{DisplayPlacement};
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Util\RequestBuilder;

// 1. Create the placement for the DOOH screen
$displayPlacement = (new DisplayPlacement())
    ->setW(1920)
    ->setH(1080)
    ->setMime(['image/jpeg', 'video/mp4'])
    ->setCtype([CreativeType::HTML]);

$placement = (new Placement())
    ->setTagid('dooh-screen-1')
    ->setDisplay($displayPlacement);

$spec = (new Spec())->setPlacement($placement);

$item = (new Item())
    ->setId('1')
    ->setFlr(5.00)
    ->setFlrcur('USD')
    ->setSpec($spec);

// 2. Create the DOOH-specific context

// The Dooh object describes the venue
$dooh = (new Dooh())
    ->setId('venue123')
    ->setName('Shopping Mall - Main Entrance')
    ->setVenuetype(['Shopping Mall', 'Retail']);

// The Device object describes the screen itself
$device = (new Device())
    ->setType(DeviceType::TV) // DOOH screens are often classified as TV-like devices
    ->setW(1920)
    ->setH(1080);

// The Geo object provides the physical location
$geo = (new Geo())
    ->setLat(37.7749)
    ->setLon(-122.4194)
    ->setCountry('USA')
    ->setCity('San Francisco');
$device->setGeo($geo);

// The Context object brings it all together
$context = (new Context())
    ->setDooh($dooh)
    ->setDevice($device);

// 3. Build the request
$builder = new RequestBuilder();
$request = ($builder
    ->setTmax(150)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->addItem($item)
    ->setContext($context))();

// Output the JSON
header('Content-Type: application/json');
echo $request->toJson();
