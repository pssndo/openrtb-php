<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;

$factory = new OpenRTBFactory('3.0');

$incomingJson = '{
  "id": "ssp-test-request",
  "at": 2,
  "item": [
    {
      "id": "item-1",
      "flr": 1.50
    },
    {
      "id": "item-2",
      "flr": 2.50
    }
  ]
}';

$request = $factory->createParser()->parseBidRequest($incomingJson);

$validator = $factory->createValidator();
$validator->validateRequest($request);

if ($validator->hasErrors()) {
    $response = $factory
        ->createResponseBuilder($request->getId())
        ->setNoBidReason(NoBidReason::INVALID_REQUEST)();
    echo $response->toJson(JSON_PRETTY_PRINT);
    exit;
}

$bids = [];
foreach ($request->getItem() as $item) {
    $floorPrice = $item->getFlr() ?? 0.0;
    if ($floorPrice <= 2.00) {
        $bidPrice = $floorPrice > 0 ? $floorPrice * 1.5 : 1.0;

        $bid = (new Bid())
            ->setId('ssp-bid-' . uniqid('', true))
            ->setItem($item->getId())
            ->setPrice($bidPrice)
            ->setMedia((new Media())
                ->setAd((new Ad())
                    ->setId('ad-' . uniqid('', true))
                    ->setAdomain(['example.com'])
                    ->setDisplay((new Display())
                        ->setBanner((new Display\Banner())
                            ->setImg('https://cdn.example.com/ad.jpg')
                            ->setW(300)
                            ->setH(250)))));

        $bid->set('cid', 'creative-id-12345');
        $bids[] = $bid;
    }
}

if (!empty($bids)) {
    $seatBid = (new Seatbid())
        ->setSeat('my-dsp-seat');

    foreach ($bids as $bid) {
        $seatBid->addBid($bid);
    }

    $response = $factory
        ->createResponseBuilder($request->getId())
        ->setCurrency('USD')
        ->addSeatbid($seatBid)();
} else {
    $response = $factory
        ->createResponseBuilder($request->getId())
        ->setNoBidReason(NoBidReason::UNMATCHED_USER)();
}

echo $response->toJson(JSON_PRETTY_PRINT);
