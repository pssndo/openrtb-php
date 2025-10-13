<?php

/**
 * OpenRTB 3.0 PHP Library - Building a Bid Response Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

use src\v3\Bid\{Media};
use src\v3\Bid\Ad;
use src\v3\Bid\Banner;
use src\v3\Bid\Bid;
use src\v3\Bid\DisplayAd;
use src\v3\Bid\Seatbid;
use src\v3\Enums\Bid\CreativeAttribute;
use src\v3\Enums\CreativeType;
use src\v3\Enums\Placement\ApiFramework;
use src\v3\Util\ResponseBuilder;

// The ID of the bid request to which this is a response.
$requestId = 'test-request-123';

// 1. Create the Ad and its components

// The Banner object contains the direct creative asset.
$banner = new Banner();
$banner
    ->setImg('https://cdn.example.com/ads/banner.jpg')
    ->setLink(['url' => 'https://advertiser.com/landing']);

// The DisplayAd object describes the display ad.
$displayAd = new DisplayAd();
$displayAd
    ->setMime('image/jpeg')
    ->setType(CreativeType::HTML)
    ->setW(300)
    ->setH(250)
    ->setAdm('<a href="%%CLICK_URL_ESC%%https://advertiser.com"><img src="https://cdn.example.com/ads/banner.jpg" width="300" height="250" /></a>')
    ->setBanner($banner);

// The Ad object is the top-level container for the creative.
$ad = new Ad();
$ad
    ->setId('ad123')
    ->setAdomain(['advertiser.com'])
    ->setCat(['IAB3-1']) // Business
    ->setSecure(1)
    ->setAttr([CreativeAttribute::THIRTEEN_USER_INTERACTIVE])
    ->setApis([ApiFramework::MRAID_2])
    ->setDisplay($displayAd);

// The Media object wraps the Ad.
$media = new Media();
$media->setAd($ad);

// 2. Create the Bid

$bid = new Bid();
$bid
    ->setId('bid-' . uniqid())
    ->setItem('1') // Corresponds to the ID of the Item in the request
    ->setPrice(1.25)
    ->setCid('campaign123')
    ->setMedia($media)
    ->setBurl('https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}')
    ->setLurl('https://dsp.example.com/loss?id=${AUCTION_ID}');

// 3. Create the Seatbid

// A Seatbid contains one or more bids from a single seat (e.g., a DSP).
$seatbid = new Seatbid();
$seatbid
    ->setSeat('advertiser-seat-1')
    ->addBid($bid);

// 4. Build the final Response

$responseBuilder = new ResponseBuilder($requestId);
$response = $responseBuilder
    ->setBidId('bidresponse-' . uniqid())
    ->setCurrency('USD')
    ->addSeatbid($seatbid)
    ->build();

// Output the JSON
header('Content-Type: application/json');
echo $response->toJson();
