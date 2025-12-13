<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\App;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Audio;
use OpenRTB\v25\Enums\AuctionType;

$factory = new OpenRTBFactory('2.5');

$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::FIRST_PRICE)
    ->setTmax(200)
    ->setCur(['USD'])
    ->setApp((new App())
        ->setId('app-456')
        ->setName('Music Streaming App')
        ->setBundle('com.example.music')
        ->setStoreurl('https://apps.apple.com/app/example-music/id123456'))
    ->setDevice((new Device())
        ->setUa('Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)')
        ->setIp('192.168.1.1')
        ->setDeviceType(4)
        ->setMake('Apple')
        ->setModel('iPhone 12')
        ->setOs('iOS')
        ->setOsv('14.0'))
    ->addImp((new Imp())
        ->setId('imp-audio-1')
        ->setAudio((new Audio())
            ->setMimes(['audio/mp4', 'audio/mpeg', 'audio/aac'])
            ->setMinduration(5)
            ->setMaxduration(30)
            ->setProtocols([2, 5])
            ->setMaxseq(1)
            ->setApi([3, 5]))
        ->setBidfloor(2.00)
        ->setBidfloorcur('USD'))();

echo $request->toJson(JSON_PRETTY_PRINT);
