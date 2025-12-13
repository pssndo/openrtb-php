<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\BoxingAllowed;
use OpenRTB\v3\Enums\Placement\Linearity;
use OpenRTB\v3\Enums\Placement\PlaybackCessationMode;
use OpenRTB\v3\Enums\Placement\PlaybackMethod;
use OpenRTB\v3\Enums\Placement\VideoPlacementType;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\VideoPlacement;

$factory = new OpenRTBFactory('3.0');

$request = $factory
    ->createRequestBuilder()
    ->setTmax(150)
    ->setAt(AuctionType::SECOND_PRICE)
    ->setCur(['USD'])
    ->addItem((new Item())
        ->setId('1')
        ->setQty(1)
        ->setFlr(2.00)
        ->setFlrcur('USD')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('video-preroll')
                ->setVideo((new VideoPlacement())
                    ->setPtype(VideoPlacementType::INSTREAM)
                    ->setPos(AdPosition::ABOVE_FOLD)
                    ->setW(1280)
                    ->setH(720)
                    ->setMime(['video/mp4', 'video/webm'])
                    ->setApi([ApiFramework::VPAID_2, ApiFramework::OMID_1])
                    ->setMindur(5)
                    ->setMaxdur(30)
                    ->setSkip(1)
                    ->setSkipafter(5)
                    ->setPlaymethod([PlaybackMethod::ON_PAGE_LOAD_SOUND_OFF, PlaybackMethod::ON_CLICK_SOUND_ON])
                    ->setPlayend(PlaybackCessationMode::ON_VIDEO_COMPLETION)
                    ->setLinear(Linearity::LINEAR)
                    ->setBoxing(BoxingAllowed::ALLOWED)))))
    ->setContext((new Context())
        ->setSite((new Site())
            ->setId('videosite123')
            ->setName('Video Platform')
            ->setDomain('videos.example.com')
            ->setPage('https://videos.example.com/watch/abc123'))
        ->setDevice((new Device())
            ->setType(DeviceType::MOBILE)
            ->setIfa('AEBE52E7-03EE-455A-B3C4-E57283966239')
            ->setIp('192.168.1.1')
            ->setMake('Apple')
            ->setModel('iPhone14,2')
            ->setOs('iOS')
            ->setOsv('16.0')))();

echo $request->toJson(JSON_PRETTY_PRINT);
