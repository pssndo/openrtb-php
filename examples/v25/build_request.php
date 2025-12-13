<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Geo;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Enums\AuctionType;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Format;
use OpenRTB\v25\Impression\Imp;

// Create factory for OpenRTB 2.5
$factory = new OpenRTBFactory('2.5');

// Build bid request
$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::FIRST_PRICE)
    ->setTmax(200)
    ->setCur(['USD'])
    ->setBcat(['IAB25', 'IAB26'])
    ->setSite((new Site())
        ->setId('site-123')
        ->setName('Example Publisher')
        ->setDomain('example.com')
        ->setPage('https://example.com/article')
        ->setCat(['IAB1', 'IAB12']))
    ->setDevice((new Device())
        ->setUa('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36')
        ->setIp('192.168.1.1')
        ->setDeviceType(2)
        ->setMake('Apple')
        ->setModel('MacBook Pro')
        ->setOs('macOS')
        ->setGeo((new Geo())
            ->setCountry('USA')
            ->setRegion('CA')
            ->setCity('San Francisco')
            ->setZip('94102')))
    ->addImp((new Imp())
        ->setId('imp-1')
        ->setBanner((new Banner())
            ->setW(728)
            ->setH(90)
            ->setFormat([
                (new Format())->setW(728)->setH(90),
                (new Format())->setW(970)->setH(250)
            ])
            ->setPos(1)
            ->setMimes(['image/jpeg', 'image/png', 'image/gif']))
        ->setBidfloor(1.50)
        ->setBidfloorcur('USD')
        ->setSecure(1)
        ->setTagid('placement-123'))();

// Output JSON
echo $request->toJson(JSON_PRETTY_PRINT);
