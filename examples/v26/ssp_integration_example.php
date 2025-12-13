<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;

$factory = new OpenRTBFactory('2.6');

$incomingJson = '{
  "id": "ssp-test-request-26",
  "imp": [
    {
      "id": "imp-1",
      "banner": {
        "w": 300,
        "h": 250,
        "pos": 1
      },
      "bidfloor": 1.50,
      "bidfloorcur": "USD"
    },
    {
      "id": "imp-2",
      "banner": {
        "w": 728,
        "h": 90,
        "pos": 1
      },
      "bidfloor": 2.50,
      "bidfloorcur": "USD"
    }
  ],
  "site": {
    "domain": "example.com",
    "page": "https://example.com/article"
  },
  "device": {
    "ua": "Mozilla/5.0...",
    "ip": "192.168.1.1"
  },
  "at": 2,
  "tmax": 150
}';

$request = $factory->createParser()->parseBidRequest($incomingJson);

$validator = $factory->createValidator();
$validator->validateBidRequest($request);

if ($validator->hasErrors()) {
    $response = $factory
        ->createResponseBuilder($request->getId())
        ->setNbr(2)();
    echo $response->toJson(JSON_PRETTY_PRINT);
    exit;
}

$bids = [];
foreach ($request->getImp() as $imp) {
    $floorPrice = $imp->getBidfloor() ?? 0.0;
    if ($floorPrice <= 2.00) {
        $bidPrice = $floorPrice > 0 ? $floorPrice * 1.5 : 1.0;

        $bid = (new Bid())
            ->setId('bid-' . uniqid('', true))
            ->setImpid($imp->getId())
            ->setPrice($bidPrice)
            ->setAdid('ad-123')
            ->setCrid('creative-456')
            ->setAdm('<a href="%%CLICK_URL_ESC%%https://example.com"><img alt="" src="https://cdn.example.com/ad.jpg" width="300" height="250"/></a>')
            ->setW(300)
            ->setH(250)
            ->setBurl('https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}');

        $bid->set('adomain', ['example.com']);
        $bid->set('cat', ['IAB3-1']);

        $bids[] = $bid;
    }
}

if (!empty($bids)) {
    $seatBid = (new SeatBid())
        ->setSeat('my-dsp-seat')
        ->setBid($bids);

    $response = $factory
        ->createResponseBuilder($request->getId())
        ->setCur('USD')
        ->addSeatBid($seatBid)();
} else {
    $response = $factory
        ->createResponseBuilder($request->getId())
        ->setNbr(8)();
}

echo $response->toJson(JSON_PRETTY_PRINT);
