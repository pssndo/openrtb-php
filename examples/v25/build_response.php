<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Response\Bid;

echo "OpenRTB 2.5 - Building a Bid Response Example\n";
echo str_repeat('=', 50) . "\n\n";

// Create factory for OpenRTB 2.5
$factory = new OpenRTBFactory('2.5');
$responseBuilder = $factory->createResponseBuilder('example-req-123');

// Build bid response
$response = $responseBuilder
    ->setCur('USD')
    ->setBidId('bidid-' . uniqid())();

// Create a bid
$bid = new Bid();
$bid->setId('bid-1');
$bid->setImpid('imp-1'); // References impression from request
$bid->setPrice(2.75); // CPM bid
$bid->setAdid('creative-123');
$bid->setCrid('creative-123');
$bid->setAdomain(['advertiser.com']);
$bid->setIurl('https://advertiser.com/creative-preview.jpg');
$bid->setCat(['IAB1-1']); // Content category
$bid->setW(728);
$bid->setH(90);

// Set ad markup (HTML creative)
$adMarkup = <<<HTML
<a href="%%CLICK_URL_ESC%%https://advertiser.com/landing" target="_blank">
    <img src="https://advertiser.com/banner-728x90.jpg" width="728" height="90" alt="Advertisement" />
</a>
<img src="%%VIEW_URL%%" width="1" height="1" style="display:none" />
HTML;

$bid->setAdm($adMarkup);

// OpenRTB 2.5 features: Billing and loss notification URLs
$bid->setBurl('https://advertiser.com/billing?price=${AUCTION_PRICE}'); // Billing notice
$bid->setLurl('https://advertiser.com/loss?reason=${AUCTION_LOSS}'); // Loss notice

// Add bid to response
$responseBuilder->addBid($bid, 'seat-123');

// Get final response
$response = $responseBuilder();

// Display the JSON
echo "Generated Bid Response:\n";
echo $response->toJson(JSON_PRETTY_PRINT) . "\n\n";

echo str_repeat('=', 50) . "\n";
echo "OpenRTB 2.5 Key Features Demonstrated:\n";
echo "  • Billing notification URL (burl) - NEW in 2.5\n";
echo "  • Loss notification URL (lurl) - NEW in 2.5\n";
echo "  • Ad markup with macros\n";
echo "  • Creative preview URL\n";
echo "  • Advertiser domain disclosure\n";
echo "  • Content categorization\n";
echo "  • CPM pricing\n";
