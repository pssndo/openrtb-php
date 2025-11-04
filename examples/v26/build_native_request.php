<?php

declare(strict_types=1);

/**
 * OpenRTB 2.6 PHP Library - Native Ad Request Example
 *
 * This example demonstrates how to construct an OpenRTB 2.6 Bid Request
 * for a native ad opportunity.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Native;
use OpenRTB\v26\Util\RequestBuilder;

// Create a native impression
// The native request is typically a JSON-encoded Native Ad Request object
$nativeRequest = [
    'ver' => '1.2', // Native Ads Specification version
    'context' => 1, // Content-centric context
    'plcmttype' => 1, // In-feed placement
    'assets' => [
        [
            'id' => 1,
            'required' => 1,
            'title' => [
                'len' => 50 // Maximum title length
            ]
        ],
        [
            'id' => 2,
            'required' => 1,
            'img' => [
                'type' => 3, // Main image
                'wmin' => 1200,
                'hmin' => 627
            ]
        ],
        [
            'id' => 3,
            'required' => 1,
            'data' => [
                'type' => 1, // Sponsored by / Advertiser name
                'len' => 25
            ]
        ],
        [
            'id' => 4,
            'required' => 0,
            'data' => [
                'type' => 2, // Description / Body text
                'len' => 150
            ]
        ]
    ]
];

$native = new Native();
$native
    ->setRequest(json_encode($nativeRequest))
    ->setVer('1.2'); // Native Ads Specification version

$imp = new Imp();
$imp
    ->setId('1')
    ->setNative($native)
    ->setBidfloor(0.75)
    ->setBidfloorcur('USD');

// Create context
$site = new Site();
$site
    ->setId('native-site-456')
    ->setName('News Publisher')
    ->setDomain('news.example.com')
    ->setPage('https://news.example.com/article/breaking-news')
    ->setCat(['IAB12']); // News category

$device = new Device();
$device
    ->setUa('Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15')
    ->setIp('192.168.1.1')
    ->setDevicetype(4); // Phone

$user = new User();
$user->setId('user-' . uniqid('', true));

// Build the request
try {
    $builder = new RequestBuilder();
    $request = $builder
        ->setSite($site)
        ->addImp($imp)
        ->setDevice($device)
        ->setUser($user)
        ->setAt(AuctionType::SECOND_PRICE)
        ->setTmax(120)
        ->setCur(['USD'])
        ->build();

    // Output the JSON
    header('Content-Type: application/json');
    echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Exception $e) {
    header('Content-Type: text/plain', true, 500);
    echo "Error building native request: " . $e->getMessage();
}
