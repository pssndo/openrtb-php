<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\App;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Impression\Audio;
use OpenRTB\v25\Impression\Imp;

echo "OpenRTB 2.5 - Audio Ad Request Example\n";
echo str_repeat('=', 50) . "\n\n";
echo "Note: Audio object was introduced in OpenRTB 2.5\n\n";

// Create factory for OpenRTB 2.5
$factory = new OpenRTBFactory('2.5');
$builder = $factory->createRequestBuilder();

$request = $builder
    ->setId('audio-req-' . uniqid())
    ->setTest(0)();

// Add app context (audio ads often in mobile apps)
$app = new App();
$app->setId('app-456');
$app->setName('Music Streaming App');
$app->setBundle('com.example.music');
$app->setStoreurl('https://apps.apple.com/app/example-music/id123456');
$request->setApp($app);

// Add device information
$device = new Device();
$device->setUa('Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)');
$device->setIfa('AEBE52E7-03EE-455A-B3C4-E57283966239'); // IDFA
$device->setLmt(0); // Limit ad tracking disabled
$device->setDeviceType(4); // Mobile/Tablet
$device->setMake('Apple');
$device->setModel('iPhone 12');
$device->setOs('iOS');
$device->setOsv('14.0');
$request->setDevice($device);

// Create audio impression (NEW in OpenRTB 2.5)
$audio = new Audio();
$audio->setMimes(['audio/mp4', 'audio/mpeg', 'audio/aac']);
$audio->setMinduration(5);
$audio->setMaxduration(30);
$audio->setProtocols([2, 5]); // VAST 2.0 and 2.0 Wrapper
$audio->setStartdelay(0); // Pre-roll
$audio->setSequence(1);
$audio->setBattr([13]); // Block audio button ads
$audio->setMaxextended(120);
$audio->setMinbitrate(32);
$audio->setMaxbitrate(128);
$audio->setDelivery([2]); // Progressive download
$audio->setApi([3, 5]); // MRAID-1, MRAID-2

$imp = new Imp();
$imp->setId('imp-audio-1');
$imp->setAudio($audio);
$imp->setBidfloor(0.50);
$imp->setBidfloorcur('USD');
$imp->setInstl(0); // Not interstitial

$request->addImp($imp);

// Display the JSON
echo "Generated Audio Bid Request:\n";
echo $request->toJson(JSON_PRETTY_PRINT) . "\n\n";

echo str_repeat('=', 50) . "\n";
echo "OpenRTB 2.5 Audio Features:\n";
echo "  • Audio object (NEW in 2.5) - For podcast ads, music streaming\n";
echo "  • DAAST compliance for audio ad serving\n";
echo "  • Duration constraints (5-30 seconds)\n";
echo "  • Audio-specific attributes\n";
echo "  • Bitrate specifications\n";
echo "  • MRAID API support for interactive audio ads\n";
