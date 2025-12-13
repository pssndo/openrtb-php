<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Video;
use OpenRTB\v26\Enums\AuctionType;

$factory = new OpenRTBFactory('2.6');

$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::SECOND_PRICE_PLUS)
    ->setTmax(150)
    ->setCur(['USD'])
    ->setSite((new Site())
        ->setId('video-site-123')
        ->setName('Video Platform')
        ->setDomain('videos.example.com')
        ->setPage('https://videos.example.com/watch/12345'))
    ->addImp((new Imp())
        ->setId('1')
        ->setVideo((new Video())
            ->setMimes(['video/mp4', 'video/webm'])
            ->setMinduration(5)
            ->setMaxduration(30)
            ->setProtocols([2, 3, 5, 6])
            ->setW(1280)
            ->setH(720)
            ->setStartdelay(0)
            ->setLinearity(1)
            ->setSkip(1)
            ->setSkipmin(5)
            ->setSkipafter(5)
            ->setPos(1)
            ->setPlacement(1)
            ->setApi([1, 2]))
        ->setBidfloor(2.0)
        ->setBidfloorcur('USD'))
    ->setDevice((new Device())
        ->setUa('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36')
        ->setIp('192.168.1.1')
        ->setDeviceType(2))
    ->setUser((new User())
        ->setId('user-' . uniqid('', true)))();

echo $request->toJson(JSON_PRETTY_PRINT);
