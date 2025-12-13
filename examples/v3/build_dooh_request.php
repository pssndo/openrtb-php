<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Dooh;
use OpenRTB\v3\Context\Geo;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;

$factory = new OpenRTBFactory('3.0');

$request = $factory
    ->createRequestBuilder()
    ->setTmax(150)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->addItem((new Item())
        ->setId('1')
        ->setFlr(5.00)
        ->setFlrcur('USD')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('dooh-screen-1')
                ->setDisplay((new DisplayPlacement())
                    ->setW(1920)
                    ->setH(1080)
                    ->setMime(['image/jpeg', 'video/mp4'])
                    ->setCtype([CreativeType::HTML])))))
    ->setContext((new Context())
        ->setDooh((new Dooh())
            ->setId('venue123')
            ->setName('Shopping Mall - Main Entrance')
            ->setVenuetype(['Shopping Mall', 'Retail']))
        ->setDevice((new Device())
            ->setType(DeviceType::TV)
            ->setW(1920)
            ->setH(1080)
            ->setGeo((new Geo())
                ->setLat(37.7749)
                ->setLon(-122.4194)
                ->setCountry('USA')
                ->setCity('San Francisco'))))();

echo $request->toJson(JSON_PRETTY_PRINT);
