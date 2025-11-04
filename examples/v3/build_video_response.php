<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Building a Video VAST Response Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Bid\{Media};
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Video;
use OpenRTB\v3\Util\ResponseBuilder;

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

// 1. Create the Video creative
$videoAd = (new Video())
    ->setAdm($vastXml); // The entire VAST XML is placed in the adm field

// 2. Create the Ad, Media, Bid, and Seatbid
$ad = (new Ad())
    ->setId('video-ad-456')
    ->setAdomain(['advertiser.com'])
    ->setVideo($videoAd);

$media = (new Media())->setAd($ad);

$bid = (new Bid())
    ->setId('bid-video-' . uniqid('', true))
    ->setPrice(3.50)
    ->setMedia($media);

// Use the generic set() method for properties not yet implemented
$bid->set('item', '1');
$bid->set('cid', 'video-campaign-789');
$bid->set('burl', 'https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}');

$seatbid = new Seatbid();
$seatbid
    ->setSeat('video-seat')
    ->addBid($bid);

// 3. Build the final Response
$responseBuilder = new ResponseBuilder($requestId);
$response = $responseBuilder
    ->setBidId('video-bidresponse-' . uniqid('', true))
    ->setCurrency('USD')
    ->addSeatbid($seatbid)
    ->build();

// Output the JSON
header('Content-Type: application/json');
echo $response->toJson();
