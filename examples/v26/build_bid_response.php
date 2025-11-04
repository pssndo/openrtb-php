<?php

declare(strict_types=1);

/**
 * OpenRTB 2.6 PHP Library - Building a Bid Response Example
 *
 * This example demonstrates how to construct an OpenRTB 2.6 Bid Response
 * for a display banner ad.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;
use OpenRTB\v26\Util\BidResponseBuilder;

// The ID of the bid request to which this is a response
$requestId = 'test-request-123';

// Create a bid for a display banner
$bid = new Bid();
$bid
    ->setId('bid-' . uniqid('', true))
    ->setImpid('1') // Must match an impression ID from the request
    ->setPrice(1.25)
    ->setAdid('ad-123')
    ->setCrid('creative-456')
    ->setAdm('<a href="%%CLICK_URL_ESC%%https://advertiser.com"><img src="https://cdn.example.com/banner.jpg" width="300" height="250" alt=""/></a>')
    ->setW(300)
    ->setH(250)
    ->setBurl('https://dsp.example.com/win?id=${AUCTION_ID}&price=${AUCTION_PRICE}')
    ->setLurl('https://dsp.example.com/loss?id=${AUCTION_ID}')
    ->setNurl('https://dsp.example.com/nurl?id=${AUCTION_ID}');

// Use the generic set() method for properties not in the spec
$bid->set('adomain', ['advertiser.com']);
$bid->set('cat', ['IAB3-1']); // Business category

// Create a SeatBid to group the bids
$seatBid = new SeatBid();
$seatBid->setSeat('advertiser-seat-1');
$seatBid->setBid([$bid]);

// Build the response
try {
    $responseBuilder = new BidResponseBuilder($requestId);
    $response = $responseBuilder
        ->setBidId('bidresponse-' . uniqid('', true))
        ->setCur('USD')
        ->addSeatBid($seatBid)
        ->build();

    // Output the JSON
    header('Content-Type: application/json');
    echo json_encode($response, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Exception $e) {
    header('Content-Type: text/plain', true, 500);
    echo "Error building bid response: " . $e->getMessage();
}
