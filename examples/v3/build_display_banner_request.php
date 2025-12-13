<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Geo;
use OpenRTB\v3\Context\Regs;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\ClickType;
use OpenRTB\v3\Enums\Placement\PlacementType;
use OpenRTB\v3\Enums\Placement\SizeUnit;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;

$factory = new OpenRTBFactory('3.0');

$geo = (new Geo())
    ->setCountry('USA')
    ->setRegion('CA')
    ->setCity('San Francisco');

$request = $factory
    ->createRequestBuilder()
    ->setTmax(100)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->setSource((new Source())
        ->setTid('transaction-' . uniqid('', true))
        ->setTs(time()))
    ->setContext((new Context())
        ->setSite((new Site())
            ->setId('site123')
            ->setName('Example Site')
            ->setDomain('example.com')
            ->setPage('https://example.com/article/123')
            ->setCat(['IAB1'])
            ->setMobile(0))
        ->setDevice((new Device())
            ->setType(DeviceType::PC)
            ->setUa('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36')
            ->setIp('192.168.1.1')
            ->setLang('en')
            ->setJs(1)
            ->setGeo($geo))
        ->setUser((new User())
            ->setId('user123')
            ->setGeo($geo))
        ->setRegs((new Regs())
            ->setGdpr(1)
            ->setCoppa(0)))
    ->addItem((new Item())
        ->setId('1')
        ->setQty(1)
        ->setFlr(0.50)
        ->setFlrcur('USD')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('banner-slot-1')
                ->setDisplay((new DisplayPlacement())
                    ->setPos(AdPosition::ABOVE_FOLD)
                    ->setW(300)
                    ->setH(250)
                    ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)
                    ->setMime(['image/jpeg', 'image/png'])
                    ->setApi([ApiFramework::MRAID_2, ApiFramework::MRAID_3])
                    ->setCtype([CreativeType::HTML])
                    ->setClktype(ClickType::CLICKABLE)
                    ->setPtype(PlacementType::IN_ATOMIC_UNIT)))))();

echo $request->toJson(JSON_PRETTY_PRINT);
