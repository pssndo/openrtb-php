<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Building a Bid Response Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Bid\{Media};
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Util\ResponseBuilder;

// The ID of the bid request to which this is a response.
$requestId = 'test-request-123';

// 1. Create the Ad and its components

// The Banner object contains the creative dimensions and markup.
$banner = (new Banner())
    ->setImg('https://cdn.example.com/ads/banner.jpg')
    ->setW(300)
    ->setH(250);

// The Display object wraps the banner creative.
$displayAd = (new Display())
    ->setBanner($banner);

// The Ad object is the top-level container for the creative.
$ad = (new Ad())
    ->setId('ad123')
    ->setAdomain(['advertiser.com'])
    ->setCat(['IAB3-1']) // Business
    ->setSecure(1)
    ->setAttr([CreativeAttribute::THIRTEEN_USER_INTERACTIVE])
    ->setDisplay($displayAd);

// The Media object wraps the Ad.
$media = (new Media())->setAd($ad);

// 2. Create the Bid

$bid = (new Bid())
    ->setId('bid-' . uniqid('', true))
    ->setPrice(1.25)
    ->setMedia($media);

// Use the generic set() method for properties not yet implemented
$bid->set('item', '1');  // Link to the request item ID
$bid->set('cid', 'campaign123');  // Campaign ID
$bid->set('burl', 'https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}');  // Billing URL
$bid->set('lurl', 'https://dsp.example.com/loss?id=${AUCTION_ID}');  // Loss URL

// 3. Create the Seatbid

// A Seatbid contains one or more bids from a single seat (e.g., a DSP).
$seatbid = new Seatbid();
$seatbid
    ->setSeat('advertiser-seat-1')
    ->addBid($bid);

// 4. Build the final Response

$responseBuilder = new ResponseBuilder($requestId);
$response = $responseBuilder
    ->setBidId('bidresponse-' . uniqid('', true))
    ->setCurrency('USD')
    ->addSeatbid($seatbid)
    ->build();

// Output the JSON
header('Content-Type: application/json');
echo $response->toJson();
