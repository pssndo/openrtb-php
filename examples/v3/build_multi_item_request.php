<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;

$factory = new OpenRTBFactory('3.0');

$request = $factory
    ->createRequestBuilder()
    ->setTmax(100)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->addItem((new Item())
        ->setId('1')
        ->setFlr(0.75)
        ->setFlrcur('USD')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('leaderboard')
                ->setDisplay((new DisplayPlacement())
                    ->setPos(AdPosition::ABOVE_FOLD)
                    ->setW(728)
                    ->setH(90)
                    ->setMime(['image/jpeg', 'image/png'])))))
    ->addItem((new Item())
        ->setId('2')
        ->setFlr(0.50)
        ->setFlrcur('USD')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('medium-rectangle')
                ->setDisplay((new DisplayPlacement())
                    ->setPos(AdPosition::ABOVE_FOLD)
                    ->setW(300)
                    ->setH(250)
                    ->setMime(['image/jpeg', 'image/png'])))))
    ->setContext((new Context())
        ->setSite((new Site())
            ->setId('multisite')
            ->setDomain('example.com')
            ->setPage('https://example.com/page'))
        ->setDevice((new Device())
            ->setIp('192.168.1.1')))();

echo $request->toJson(JSON_PRETTY_PRINT);
