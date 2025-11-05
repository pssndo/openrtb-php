<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Building a Multi-Item Request Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Context\{Device};
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Impression\{Spec};
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Placement\{DisplayPlacement};
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Util\RequestBuilder;

// 1. Create the first item (e.g., a leaderboard banner)
$displayPlacement1 = (new DisplayPlacement())
    ->setPos(AdPosition::ABOVE_FOLD)
    ->setW(728)
    ->setH(90)
    ->setMime(['image/jpeg', 'image/png']);

$placement1 = (new Placement())->setTagid('leaderboard')->setDisplay($displayPlacement1);
$spec1 = (new Spec())->setPlacement($placement1);

$item1 = (new Item())
    ->setId('1')
    ->setFlr(0.75)
    ->setFlrcur('USD')
    ->setSpec($spec1);

// 2. Create the second item (e.g., a medium rectangle)
$displayPlacement2 = (new DisplayPlacement())
    ->setPos(AdPosition::ABOVE_FOLD)
    ->setW(300)
    ->setH(250)
    ->setMime(['image/jpeg', 'image/png']);

$placement2 = (new Placement())->setTagid('medium-rectangle')->setDisplay($displayPlacement2);
$spec2 = (new Spec())->setPlacement($placement2);

$item2 = (new Item())
    ->setId('2')
    ->setFlr(0.50)
    ->setFlrcur('USD')
    ->setSpec($spec2);

// 3. Create the common context
$site = (new Site())
    ->setId('multisite')
    ->setDomain('example.com')
    ->setPage('https://example.com/page');

$device = (new Device())->setIp('192.168.1.1');

$context = (new Context())
    ->setSite($site)
    ->setDevice($device);

// 4. Build the request with multiple items
$builder = new RequestBuilder();
$request = ($builder
    ->setTmax(100)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->addItem($item1)
    ->addItem($item2)
    ->setContext($context))();

// Output the JSON
header('Content-Type: application/json');
echo $request->toJson();
