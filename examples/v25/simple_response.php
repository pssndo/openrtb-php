<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;

echo "OpenRTB 2.5 - Simple Bid Response Example\n";
echo str_repeat('=', 50) . "\n\n";

// Create response
$response = new BidResponse();
$response->setId('req-123');
$response->setCur('USD');
$response->setBidid('bid-' . uniqid());

// Create a bid
$bid = new Bid();
$bid->setId('bid-1');
$bid->setImpid('imp-1');
$bid->setPrice(2.50);
$bid->setAdm('<div>Ad Creative</div>');
$bid->setAdomain(['advertiser.com']);

// OpenRTB 2.5 NEW features
$bid->setBurl('https://advertiser.com/billing?price=${AUCTION_PRICE}');
$bid->setLurl('https://advertiser.com/loss?reason=${AUCTION_LOSS}');

// Add to seat bid
$seatBid = new SeatBid();
$seatBid->setBid([$bid]);
$seatBid->setSeat('seat-123');

$response->setSeatbid([$seatBid]);

// Output
echo "Generated Bid Response:\n";
echo $response->toJson(JSON_PRETTY_PRINT) . "\n\n";

echo "✓ OpenRTB 2.5 response created successfully!\n";
echo "\nNew in 2.5:\n";
echo "  • burl - Billing notification URL\n";
echo "  • lurl - Loss notification URL\n";
