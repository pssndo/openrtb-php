<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Native\NativeRequest;
use OpenRTB\v25\Impression\Native\TitleAsset;
use OpenRTB\v25\Impression\Native\ImageAsset;
use OpenRTB\v25\Impression\Native\DataAsset;
use OpenRTB\v25\Impression\Native;
use OpenRTB\v25\Enums\AuctionType;

$factory = new OpenRTBFactory('2.5');

// Build native request using modern object approach
$nativeRequest = (new NativeRequest())
    ->setVer('1.2')
    ->addAsset((new TitleAsset(1, 80, true)))
    ->addAsset((new ImageAsset(2, 3, 300, 250, true)))
    ->addAsset((new DataAsset(3, 2, 120, false)));

$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::FIRST_PRICE)
    ->setSite((new Site())
        ->setId('site-123')
        ->setDomain('example.com'))
    ->addImp((new Imp())
        ->setId('imp-native-1')
        ->setNative((new Native())
            ->setRequest($nativeRequest->toJson())
            ->setVer('1.2'))
        ->setBidfloor(1.00)
        ->setBidfloorcur('USD'))();

echo $request->toJson(JSON_PRETTY_PRINT);
