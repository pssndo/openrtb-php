<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Native;
use OpenRTB\v26\Enums\AuctionType;

$factory = new OpenRTBFactory('2.6');

$nativeRequest = json_encode([
    'ver' => '1.2',
    'context' => 1,
    'plcmttype' => 1,
    'assets' => [
        ['id' => 1, 'required' => 1, 'title' => ['len' => 50]],
        ['id' => 2, 'required' => 1, 'img' => ['type' => 3, 'wmin' => 1200, 'hmin' => 627]],
        ['id' => 3, 'required' => 1, 'data' => ['type' => 1, 'len' => 25]],
        ['id' => 4, 'required' => 0, 'data' => ['type' => 2, 'len' => 150]]
    ]
]);

$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::SECOND_PRICE_PLUS)
    ->setTmax(120)
    ->setCur(['USD'])
    ->setSite((new Site())
        ->setId('native-site-456')
        ->setName('News Publisher')
        ->setDomain('news.example.com')
        ->setPage('https://news.example.com/article/breaking-news')
        ->setCat(['IAB12']))
    ->addImp((new Imp())
        ->setId('1')
        ->setNative((new Native())
            ->setRequest($nativeRequest)
            ->setVer('1.2'))
        ->setBidfloor(0.75)
        ->setBidfloorcur('USD'))
    ->setDevice((new Device())
        ->setUa('Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15')
        ->setIp('192.168.1.1')
        ->setDeviceType(4))
    ->setUser((new User())
        ->setId('user-' . uniqid('', true)))();

echo $request->toJson(JSON_PRETTY_PRINT);
