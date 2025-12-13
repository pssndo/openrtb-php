<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Native;
use OpenRTB\v25\Enums\AuctionType;

$factory = new OpenRTBFactory('2.5');

// Build native request spec
$nativeRequest = json_encode([
    'ver' => '1.2',
    'assets' => [
        ['id' => 1, 'required' => 1, 'title' => ['len' => 80]],
        ['id' => 2, 'required' => 1, 'img' => ['type' => 3, 'w' => 300, 'h' => 250]],
        ['id' => 3, 'required' => 0, 'data' => ['type' => 2, 'len' => 120]]
    ]
]);

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
            ->setRequest($nativeRequest)
            ->setVer('1.2'))
        ->setBidfloor(1.00)
        ->setBidfloorcur('USD'))();

echo $request->toJson(JSON_PRETTY_PRINT);
