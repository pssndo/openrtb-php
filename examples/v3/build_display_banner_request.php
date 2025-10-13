<?php

/**
 * OpenRTB 3.0 PHP Library - Display Banner Request Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

use src\v3\Context\{Geo};
use src\v3\Context\Context;
use src\v3\Context\Device;
use src\v3\Context\Regs;
use src\v3\Context\Site;
use src\v3\Context\Source;
use src\v3\Context\User;
use src\v3\Enums\{AuctionType, Placement\AdPosition, Placement\ClickType};
use src\v3\Enums\Context\DeviceType;
use src\v3\Enums\CreativeType;
use src\v3\Enums\Placement\{SizeUnit};
use src\v3\Enums\Placement\ApiFramework;
use src\v3\Enums\Placement\PlacementType;
use src\v3\Impression\{Spec};
use src\v3\Impression\Item;
use src\v3\Placement\{DisplayPlacement};
use src\v3\Placement\Placement;
use src\v3\Util\RequestBuilder;

// Create display placement
$displayPlacement = new DisplayPlacement();
$displayPlacement
    ->setPos(AdPosition::ABOVE_FOLD)
    ->setW(300)
    ->setH(250)
    ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)
    ->setMime(['image/jpeg', 'image/png', 'image/gif'])
    ->setApi([ApiFramework::MRAID_2, ApiFramework::MRAID_3])
    ->setCtype([CreativeType::HTML])
    ->setClktype(ClickType::CLICKABLE)
    ->setPtype(PlacementType::IN_ATOMIC_UNIT);

// Create placement
$placement = new Placement();
$placement
    ->setTagid('banner-slot-1')
    ->setDisplay($displayPlacement);

// Create spec
$spec = new Spec();
$spec->setPlacement($placement);

// Create item (impression)
$item = new Item();
$item
    ->setId('1')
    ->setQty(1)
    ->setFlr(0.50)  // Floor price
    ->setFlrcur('USD')
    ->setSpec($spec);

// Create site
$site = new Site();
$site
    ->setId('site123')
    ->setName('Example Site')
    ->setDomain('example.com')
    ->setPage('https://example.com/article/123')
    ->setCat(['IAB1'])  // Arts & Entertainment
    ->setMobile(0);

// Create device
$device = new Device();
$device
    ->setType(DeviceType::PC)
    ->setUa('Mozilla/5.0 (Windows NT 10.0; Win64; x64)...')
    ->setIp('192.168.1.1')
    ->setLang('en')
    ->setJs(1);

// Create geo
$geo = new Geo();
$geo
    ->setCountry('USA')
    ->setRegion('CA')
    ->setCity('San Francisco');
$device->setGeo($geo);

// Create user
$user = new User();
$user
    ->setId('user123')
    ->setGeo($geo);

// Create regulations
$regs = new Regs();
$regs
    ->setGdpr(1)
    ->setCoppa(0);

// Create context
$context = new Context();
$context
    ->setSite($site)
    ->setDevice($device)
    ->setUser($user)
    ->setRegs($regs);

// Create source
$source = new Source();
$source
    ->setTid('transaction-' . uniqid())
    ->setTs(time());

// Build request
$builder = new RequestBuilder();
$request = $builder
    ->setTimeout(100)
    ->setAuctionType(AuctionType::SECOND_PRICE)
    ->setCurrencies(['USD'])
    ->addItem($item)
    ->setContext($context)
    ->setSource($source)
    ->build();

// Output the JSON
header('Content-Type: application/json');
echo $request->toJson();
