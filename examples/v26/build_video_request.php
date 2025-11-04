<?php

declare(strict_types=1);

/**
 * OpenRTB 2.6 PHP Library - Video Request Example
 *
 * This example demonstrates how to construct an OpenRTB 2.6 Bid Request
 * for a video ad opportunity.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Video;
use OpenRTB\v26\Util\RequestBuilder;

// Create a video impression
$video = new Video();
$video
    ->setMimes(['video/mp4', 'video/webm'])
    ->setMinduration(5)
    ->setMaxduration(30)
    ->setProtocols([2, 3, 5, 6]) // VAST 2.0, 3.0, VAST 2.0 Wrapper, VAST 3.0 Wrapper
    ->setW(1280)
    ->setH(720)
    ->setStartdelay(0) // Pre-roll
    ->setLinearity(1) // Linear/In-Stream
    ->setSkip(1) // Skippable
    ->setSkipmin(5) // Skip after 5 seconds
    ->setSkipafter(5)
    ->setPos(1) // Above the fold
    ->setApi([1, 2]); // VPAID 1.0, VPAID 2.0

$imp = new Imp();
$imp
    ->setId('1')
    ->setVideo($video)
    ->setBidfloor(2.0)
    ->setBidfloorcur('USD');

// Create context
$site = new Site();
$site
    ->setId('video-site-123')
    ->setName('Video Platform')
    ->setDomain('videos.example.com')
    ->setPage('https://videos.example.com/watch/12345');

$device = new Device();
$device
    ->setUa('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36')
    ->setIp('192.168.1.1')
    ->setDevicetype(2); // Personal Computer

$user = new User();
$user->setId('user-' . uniqid());

// Build the request
try {
    $builder = new RequestBuilder();
    $request = $builder
        ->setSite($site)
        ->addImp($imp)
        ->setDevice($device)
        ->setUser($user)
        ->setAt(AuctionType::SECOND_PRICE)
        ->setTmax(150)
        ->setCur(['USD'])
        ->build();

    // Output the JSON
    header('Content-Type: application/json');
    echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Exception $e) {
    header('Content-Type: text/plain', true, 500);
    echo "Error building video request: " . $e->getMessage();
}