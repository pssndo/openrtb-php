<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('3.0');

$vastXml = '<?xml version="1.0" encoding="UTF-8"?><VAST version="4.0"><Ad id="ad123"><InLine><AdSystem>DSP Platform</AdSystem><AdTitle>Video Ad</AdTitle><Impression><![CDATA[https://dsp.example.com/impression]]></Impression><Creatives><Creative><Linear><Duration>00:00:15</Duration><MediaFiles><MediaFile delivery="progressive" type="video/mp4" width="1280" height="720"><![CDATA[https://cdn.example.com/video-ad.mp4]]></MediaFile></MediaFiles><VideoClicks><ClickThrough><![CDATA[https://advertiser.com/landing]]></ClickThrough></VideoClicks></Linear></Creative></Creatives></InLine></Ad></VAST>';

$responseJson = json_encode([
    'id' => 'test-request-456',
    'bidid' => 'video-bidresponse-12345',
    'seatbid' => [[
        'seat' => 'video-seat',
        'bid' => [[
            'id' => 'bid-video-1',
            'item' => '1',
            'price' => 3.50,
            'cid' => 'video-campaign-789',
            'burl' => 'https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}',
            'media' => [
                'ad' => [
                    'id' => 'video-ad-456',
                    'adomain' => ['advertiser.com'],
                    'video' => [
                        'adm' => $vastXml
                    ]
                ]
            ]
        ]]
    ]],
    'cur' => 'USD'
]);

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
