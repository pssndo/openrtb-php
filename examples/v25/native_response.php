<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;

echo "OpenRTB 2.5 - Native Ad Response Example\n";
echo str_repeat('=', 50) . "\n";
echo "NOTE: Response uses JSON strings (OpenRTB 2.5 spec)\n";
echo "      Response objects coming in future update!\n";
echo str_repeat('=', 50) . "\n\n";

// Step 1: Build the Native Response Object (as per IAB Native Ad Spec 1.2)
// This gets JSON-encoded and put in the Bid.adm field
$nativeResponse = [
    'ver' => '1.2',
    'assets' => [
        // Title asset response
        [
            'id' => 1,
            'required' => 1,
            'title' => [
                'text' => 'Amazing Product - Save 50% Today!'
            ]
        ],
        // Main image asset response
        [
            'id' => 2,
            'required' => 1,
            'img' => [
                'url' => 'https://cdn.example.com/ads/product-image-300x250.jpg',
                'w' => 300,
                'h' => 250
            ]
        ],
        // Icon image response
        [
            'id' => 3,
            'required' => 0,
            'img' => [
                'url' => 'https://cdn.example.com/ads/brand-logo-50x50.png',
                'w' => 50,
                'h' => 50
            ]
        ],
        // Sponsored by text response
        [
            'id' => 4,
            'required' => 0,
            'data' => [
                'value' => 'Sponsored by ACME Corp'
            ]
        ],
        // Description text response
        [
            'id' => 5,
            'required' => 0,
            'data' => [
                'value' => 'Discover our amazing product with 50% off. Limited time offer. Free shipping on all orders!'
            ]
        ],
        // Call to action response
        [
            'id' => 6,
            'required' => 0,
            'data' => [
                'value' => 'Shop Now'
            ]
        ]
    ],
    'link' => [
        'url' => 'https://advertiser.com/landing-page?campaign=123',
        'clicktrackers' => [
            'https://tracker1.example.com/click?id=abc',
            'https://tracker2.example.com/click?id=def'
        ]
    ],
    'imptrackers' => [
        'https://tracker1.example.com/impression?id=abc',
        'https://tracker2.example.com/impression?id=def'
    ],
    'jstracker' => '<script src="https://tracker.example.com/native.js"></script>',
    'privacy' => 'https://advertiser.com/privacy-policy'
];

echo "Native Response Object created:\n";
echo "  • Assets: " . count($nativeResponse['assets']) . "\n";
echo "  • Click trackers: " . count($nativeResponse['link']['clicktrackers']) . "\n";
echo "  • Impression trackers: " . count($nativeResponse['imptrackers']) . "\n\n";

// Step 2: Create the Bid with Native creative
$bid = new Bid();
$bid->setId('bid-1');
$bid->setImpid('imp-1');
$bid->setPrice(2.50);

// IMPORTANT: Native creative goes in 'adm' field as JSON string
$bid->setAdm(json_encode($nativeResponse));

// Set other bid fields
$bid->setAdomain(['advertiser.com']);
$bid->setCrid('creative-123');
$bid->setCat(['IAB1']); // Categories
$bid->setW(300);
$bid->setH(250);

// OpenRTB 2.5 specific: notification URLs
$bid->setBurl('https://dsp.example.com/billing?price=${AUCTION_PRICE}');
$bid->setLurl('https://dsp.example.com/loss?reason=${AUCTION_LOSS}');

// Step 3: Create SeatBid
$seatBid = new SeatBid();
$seatBid->setBid([$bid]); // Set array of bids
$seatBid->setSeat('seat-123');

// Step 4: Create Bid Response
$response = new BidResponse();
$response->setId('native-req-123');
$response->setSeatbid([$seatBid]); // Set array of seatbids
$response->setCur('USD');
$response->setBidid('bidresponse-456');

// Display the complete response
echo "Complete OpenRTB 2.5 Native Bid Response:\n";
echo str_repeat('-', 50) . "\n";
echo $response->toJson(JSON_PRETTY_PRINT) . "\n\n";

// Show what the native response looks like inside
echo "Native Response Field (decoded for viewing):\n";
echo str_repeat('-', 50) . "\n";
echo json_encode($nativeResponse, JSON_PRETTY_PRINT) . "\n\n";

echo str_repeat('=', 50) . "\n";
echo "How Native Response Works:\n";
echo "  1. Native creative is in Bid.adm as JSON string\n";
echo "  2. Publisher decodes Bid.adm to get native assets\n";
echo "  3. Publisher renders assets according to design\n";
echo "  4. Click/impression trackers fire on interaction\n";
echo "\n";
echo "Asset Mapping (Request → Response):\n";
echo "  Request Asset ID → Response Asset ID\n";
echo "  ───────────────────────────────────────\n";
echo "  1 (Title)        → Title text\n";
echo "  2 (Main Image)   → Image URL + dimensions\n";
echo "  3 (Icon)         → Logo URL + dimensions\n";
echo "  4 (Sponsored)    → Sponsor text\n";
echo "  5 (Description)  → Ad copy\n";
echo "  6 (CTA)          → Button text\n";
echo "\n";
echo "Tracking:\n";
echo "  • Impression trackers: Fire when ad is visible\n";
echo "  • Click trackers: Fire when user clicks\n";
echo "  • JS tracker: Additional JavaScript tracking\n";
