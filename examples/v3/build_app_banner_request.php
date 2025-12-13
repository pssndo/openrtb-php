<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Context\App;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Regs;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ClickType;
use OpenRTB\v3\Enums\Placement\PlacementType;
use OpenRTB\v3\Enums\Placement\SizeUnit;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;

$factory = new OpenRTBFactory('3.0');

$request = $factory
    ->createRequestBuilder()
    ->setTmax(120)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->addItem((new Item())
        ->setId('1')
        ->setQty(1)
        ->setFlr(1.50)
        ->setFlrcur('USD')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('app-banner-bottom')
                ->setDisplay((new DisplayPlacement())
                    ->setPos(AdPosition::ABOVE_FOLD)
                    ->setInstl(0)
                    ->setW(320)
                    ->setH(50)
                    ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)
                    ->setMime(['image/jpeg', 'image/png'])
                    ->setCtype([CreativeType::HTML])
                    ->setClktype(ClickType::CLICKABLE)
                    ->setPtype(PlacementType::IN_ATOMIC_UNIT)))))
    ->setContext((new Context())
        ->setApp((new App())
            ->setId('app456')
            ->setName('My Mobile Game')
            ->setBundle('com.example.game')
            ->setStoreurl('https://apps.apple.com/app/id123456')
            ->setCat(['IAB9'])
            ->setVer('2.1.0')
            ->setPaid(0))
        ->setDevice((new Device())
            ->setType(DeviceType::PHONE)
            ->setIfa('AEBE52E7-03EE-455A-B3C4-E57283966239')
            ->setLmt(0)
            ->setIp('192.168.1.1')
            ->setMake('Samsung')
            ->setModel('Galaxy S21')
            ->setOs('Android')
            ->setOsv('13'))
        ->setUser((new User())
            ->setId('user789')
            ->setConsent('CPXxRfAPXxRfAAfKABENBsCsAP_AAH_AACiQGaNf_X_fb3...'))
        ->setRegs((new Regs())
            ->setGdpr(1)
            ->setCoppa(0)
            ->setGpp('DBABMA~CPXxRfAPXxRfAAfKABENB')
            ->setGppSid([2, 6])))
    ->setSource((new Source())
        ->setTid('txn-' . uniqid('', true))
        ->setTs(time()))();

echo $request->toJson(JSON_PRETTY_PRINT);
