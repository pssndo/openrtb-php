<?php

/**
 * OpenRTB 3.0 PHP Library - Building a Video VAST Response Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../../../vendor/autoload.php';

use src\v3\Bid\{Media};
use src\v3\Bid\Ad;
use src\v3\Bid\Bid;
use src\v3\Bid\Seatbid;
use src\v3\Bid\VideoAd;
use src\v3\Enums\CreativeType;
use src\v3\Enums\Placement\ApiFramework;
use src\v3\Util\ResponseBuilder;

// The ID of the bid request to which this is a response.
$requestId = 'test-request-456';

// VAST XML (simplified example)
$vastXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<VAST version="4.0">
  <Ad id="ad123">
    <InLine>
      <AdSystem>DSP Platform</AdSystem>
      <AdTitle>Video Ad</AdTitle>
      <Impression><![CDATA[https://dsp.example.com/impression]]></Impression>
      <Creatives>
        <Creative>
          <Linear>
            <Duration>00:00:15</Duration>
            <MediaFiles>
              <MediaFile delivery="progressive" type="video/mp4" width="1280" height="720">
                <![CDATA[https://cdn.example.com/video-ad.mp4]]>
              </MediaFile>
            </MediaFiles>
            <VideoClicks>
              <ClickThrough><![CDATA[https://advertiser.com/landing]]></ClickThrough>
            </VideoClicks>
          </Linear>
        </Creative>
      </Creatives>
    </InLine>
  </Ad>
</VAST>
XML;

// 1. Create the VideoAd
$videoAd = new VideoAd();
$videoAd
    ->setMime(['video/mp4'])
    ->setType(CreativeType::HTML) // VAST is often served in a VPAID context which is HTML/JS
    ->setAdm($vastXml) // The entire VAST XML is placed in the adm field
    ->setApis([ApiFramework::VPAID_2]);

// 2. Create the Ad, Media, Bid, and Seatbid
$ad = new Ad();
$ad
    ->setId('video-ad-456')
    ->setAdomain(['advertiser.com'])
    ->setVideo($videoAd);

$media = new Media();
$media->setAd($ad);

$bid = new Bid();
$bid
    ->setId('bid-video-' . uniqid())
    ->setItem('1')
    ->setPrice(3.50)
    ->setCid('video-campaign-789')
    ->setMedia($media)
    ->setBurl('https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}');

$seatbid = new Seatbid();
$seatbid
    ->setSeat('video-seat')
    ->addBid($bid);

// 3. Build the final Response
$responseBuilder = new ResponseBuilder($requestId);
$response = $responseBuilder
    ->setBidId('video-bidresponse-' . uniqid())
    ->setCurrency('USD')
    ->addSeatbid($seatbid)
    ->build();

// Output the JSON
header('Content-Type: application/json');
echo $response->toJson();
