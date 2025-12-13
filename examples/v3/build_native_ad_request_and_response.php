<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\AssetFormat;
use OpenRTB\v3\Placement\DataFormat;
use OpenRTB\v3\Placement\ImageFormat;
use OpenRTB\v3\Placement\NativeFormat;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\TitleFormat;

$factory = new OpenRTBFactory('3.0');

$request = $factory
    ->createRequestBuilder()
    ->setAt(AuctionType::SECOND_PRICE)
    ->addItem((new Item())
        ->setId('native-item-1')
        ->setSpec((new Spec())
            ->setPlacement((new Placement())
                ->setTagid('native-ad-slot-1')
                ->setPos(AdPosition::BELOW_FOLD)
                ->setNativefmt((new NativeFormat())
                    ->setAsset([
                        (new AssetFormat())
                            ->setId(1)
                            ->setReq(1)
                            ->setTitle((new TitleFormat())->setLen(50)),
                        (new AssetFormat())
                            ->setId(2)
                            ->setReq(1)
                            ->setImg((new ImageFormat())->setW(1200)->setH(627)),
                        (new AssetFormat())
                            ->setId(3)
                            ->setReq(1)
                            ->setData((new DataFormat())->setType(1))
                    ])))))
    ->setContext((new Context())
        ->setSite((new Site())
            ->setDomain('native-publisher.com')))();

$responseJson = json_encode([
    'id' => $request->getId(),
    'bidid' => 'native-bid-response-123',
    'seatbid' => [[
        'seat' => 'native-dsp-seat-1',
        'bid' => [[
            'id' => 'native-bid-1',
            'item' => 'native-item-1',
            'price' => 2.50,
            'media' => [
                'ad' => [
                    'id' => 'native-ad-creative-1',
                    'adomain' => ['advertiser.com'],
                    'native' => [
                        'asset' => [
                            ['id' => 1, 'title' => ['text' => 'This is the Native Ad Title']],
                            ['id' => 2, 'img' => ['url' => 'https://cdn.example.com/native-ad-image.jpg']],
                            ['id' => 3, 'data' => ['value' => 'Our Great Sponsor']]
                        ],
                        'link' => [
                            'url' => 'https://advertiser-landing-page.com',
                            'trkr' => ['https://analytics.example.com/click-tracker']
                        ],
                        'imptrackers' => ['https://analytics.example.com/impression-tracker']
                    ]
                ]
            ]
        ]]
    ]],
    'cur' => 'USD'
]);

$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->toJson(JSON_PRETTY_PRINT);
