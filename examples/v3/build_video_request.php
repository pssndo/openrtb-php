<?php

/**
 * OpenRTB 3.0 PHP Library - Video VAST Request Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

use src\v3\Context\{Device};
use src\v3\Context\Context;
use src\v3\Context\Site;
use src\v3\Enums\AuctionType;
use src\v3\Enums\Context\DeviceType;
use src\v3\Enums\Placement\{Linearity};
use src\v3\Enums\Placement\AdPosition;
use src\v3\Enums\Placement\ApiFramework;
use src\v3\Enums\Placement\BoxingAllowed;
use src\v3\Enums\Placement\PlaybackCessationMode;
use src\v3\Enums\Placement\PlaybackMethod;
use src\v3\Enums\Placement\VideoPlacementType;
use src\v3\Impression\{Spec};
use src\v3\Impression\Item;
use src\v3\Placement\{VideoPlacement};
use src\v3\Placement\Placement;
use src\v3\Util\RequestBuilder;

// Create video placement
$videoPlacement = new VideoPlacement();
$videoPlacement
    ->setPtype(VideoPlacementType::INSTREAM)
    ->setPos(AdPosition::ABOVE_FOLD)
    ->setW(1280)
    ->setH(720)
    ->setMime(['video/mp4', 'video/webm'])
    ->setApi([ApiFramework::VPAID_2, ApiFramework::OMID_1])
    ->setMindur(5)      // Minimum 5 seconds
    ->setMaxdur(30)     // Maximum 30 seconds
    ->setSkip(1)        // Skippable
    ->setSkipafter(5)   // Skip after 5 seconds
    ->setPlaymethod([PlaybackMethod::ON_PAGE_LOAD_SOUND_OFF, PlaybackMethod::ON_CLICK_SOUND_ON])
    ->setPlayend(PlaybackCessationMode::ON_VIDEO_COMPLETION)
    ->setLinear(Linearity::LINEAR)
    ->setBoxing(BoxingAllowed::ALLOWED);

// Create placement
$placement = new Placement();
$placement
    ->setTagid('video-preroll')
    ->setVideo($videoPlacement);

// Create spec
$spec = new Spec();
$spec->setPlacement($placement);

// Create item
$item = new Item();
$item
    ->setId('1')
    ->setQty(1)
    ->setFlr(2.00)
    ->setFlrcur('USD')
    ->setSpec($spec);

// Create site with video content
$site = new Site();
$site
    ->setId('videosite123')
    ->setName('Video Platform')
    ->setDomain('videos.example.com')
    ->setPage('https://videos.example.com/watch/abc123');

// Create device
$device = new Device();
$device
    ->setType(DeviceType::MOBILE)
    ->setIfa('AEBE52E7-03EE-455A-B3C4-E57283966239')  // IDFA
    ->setIp('192.168.1.1')
    ->setMake('Apple')
    ->setModel('iPhone14,2')
    ->setOs('iOS')
    ->setOsv('16.0');

// Create context
$context = new Context();
$context
    ->setSite($site)
    ->setDevice($device);

// Build request
$builder = new RequestBuilder();
$request = $builder
    ->setTimeout(150)
    ->setAuctionType(AuctionType::SECOND_PRICE)
    ->setCurrencies(['USD'])
    ->addItem($item)
    ->setContext($context)
    ->build();

// Output the JSON
header('Content-Type: application/json');
echo $request->toJson();
