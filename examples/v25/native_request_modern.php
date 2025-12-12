<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Native;
use OpenRTB\v25\Impression\Native\NativeRequest;
use OpenRTB\v25\Impression\Native\TitleAsset;
use OpenRTB\v25\Impression\Native\ImageAsset;
use OpenRTB\v25\Impression\Native\DataAsset;

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║  OpenRTB 2.5 - Modern Native Request ✨    ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// ==========================================
// THE NEW WAY: Object-Based Approach
// ==========================================

echo "🎯 Creating Native Request using OBJECTS (not arrays!)\n";
echo str_repeat('-', 62) . "\n\n";

// Step 1: Create Native Request object
$nativeRequest = new NativeRequest();
$nativeRequest->setVer('1.2');
$nativeRequest->setContext(1);      // Content-centric
$nativeRequest->setPlcmttype(1);    // In-feed

echo "✓ Created NativeRequest object\n";
echo "  • Version: " . $nativeRequest->getVer() . "\n";
echo "  • Context: Content-centric (1)\n";
echo "  • Placement: In-feed (1)\n\n";

// Step 2: Add assets using typed objects
echo "Adding assets:\n";

// Title asset - autocomplete works!
$titleAsset = new TitleAsset(
    id: 1,
    len: 90,
    required: true
);
$nativeRequest->addAsset($titleAsset);
echo "  ✓ Title (ID: 1, max 90 chars, required)\n";

// Main image asset - with constants!
$mainImageAsset = new ImageAsset(
    id: 2,
    type: ImageAsset::TYPE_MAIN,  // Type-safe constant!
    wmin: 300,
    hmin: 250,
    required: true
);
$mainImageAsset->setMimes(['image/jpeg', 'image/png']);
$nativeRequest->addAsset($mainImageAsset);
echo "  ✓ Main Image (ID: 2, 300x250+, required)\n";

// Icon image asset
$iconAsset = new ImageAsset(
    id: 3,
    type: ImageAsset::TYPE_ICON,
    wmin: 50,
    hmin: 50,
    required: false
);
$nativeRequest->addAsset($iconAsset);
echo "  ✓ Icon (ID: 3, 50x50+, optional)\n";

// Sponsored by text
$sponsorAsset = new DataAsset(
    id: 4,
    type: DataAsset::TYPE_SPONSORED,  // Type-safe constant!
    len: 25,
    required: false
);
$nativeRequest->addAsset($sponsorAsset);
echo "  ✓ Sponsored text (ID: 4, max 25 chars, optional)\n";

// Description
$descAsset = new DataAsset(
    id: 5,
    type: DataAsset::TYPE_DESC,
    len: 140,
    required: false
);
$nativeRequest->addAsset($descAsset);
echo "  ✓ Description (ID: 5, max 140 chars, optional)\n";

// Call-to-action
$ctaAsset = new DataAsset(
    id: 6,
    type: DataAsset::TYPE_CTATEXT,
    len: 15,
    required: true
);
$nativeRequest->addAsset($ctaAsset);
echo "  ✓ Call-to-action (ID: 6, max 15 chars, required)\n\n";

echo "Total assets: " . count($nativeRequest->getAssets()) . "\n\n";

// Step 3: Create Native object - automatic JSON conversion!
$native = new Native();
$native->setRequest($nativeRequest);  // ← Just pass the object! Magic! ✨
$native->setVer('1.2');
$native->setApi([3, 5]);
$native->setBattr([1, 2, 3]);

echo "✨ Magic happened!\n";
echo "  • NativeRequest object → Auto-converted to JSON string\n";
echo "  • OpenRTB 2.5 compatible format maintained\n";
echo "  • No manual json_encode() needed!\n\n";

// Step 4: Create impression
$imp = new Imp();
$imp->setId('imp-1');
$imp->setNative($native);
$imp->setBidfloor(1.50);
$imp->setBidfloorcur('USD');
$imp->setSecure(1);
$imp->setTagid('native-placement-123');

// Step 5: Create the bid request
$factory = new OpenRTBFactory('2.5');
$request = $factory->createRequestBuilder()
    ->setId('modern-native-req-' . uniqid())
    ->setTest(0)
    ->setTmax(200)
    ->setCur(['USD'])();

// Add site information
$site = new Site();
$site->setId('site-123');
$site->setName('Modern News Publisher');
$site->setDomain('news.example.com');
$site->setPage('https://news.example.com/tech/article');
$site->setCat(['IAB19']); // Technology
$request->setSite($site);

// Add device information
$device = new Device();
$device->setUa('Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X)');
$device->setIp('192.168.1.1');
$device->setDevicetype(4); // Phone
$request->setDevice($device);

// Add impression
$request->addImp($imp);

// Display the complete request
echo str_repeat('=', 62) . "\n";
echo "Complete OpenRTB 2.5 Bid Request (using object-based Native):\n";
echo str_repeat('=', 62) . "\n";
echo $request->toJson(JSON_PRETTY_PRINT) . "\n\n";

// Show what the native request looks like
echo str_repeat('=', 62) . "\n";
echo "Native Request Field (auto-generated from objects):\n";
echo str_repeat('=', 62) . "\n";
$nativeRequestJson = $native->getRequest();
$nativeRequestArray = json_decode($nativeRequestJson, true);
echo json_encode($nativeRequestArray, JSON_PRETTY_PRINT) . "\n\n";

// Validate
$validator = $factory->createValidator();
if ($validator->validateBidRequest($request)) {
    echo "✅ Bid request is valid!\n\n";
} else {
    echo "❌ Validation errors:\n";
    foreach ($validator->getErrors() as $error) {
        echo "  - $error\n";
    }
}

echo str_repeat('=', 62) . "\n";
echo "🎉 Benefits of Object-Based Approach:\n";
echo str_repeat('=', 62) . "\n";
echo "✓ Type Safety         - IDE autocomplete works perfectly\n";
echo "✓ Constants           - Use ImageAsset::TYPE_MAIN instead of magic numbers\n";
echo "✓ Named Parameters    - Clear what each parameter means\n";
echo "✓ Auto-Serialization  - No manual json_encode() needed\n";
echo "✓ Auto-Deserialization - Convert back with getRequestObject()\n";
echo "✓ Validation          - Constructor enforces required fields\n";
echo "✓ Discoverability     - Easy to explore API via IDE\n";
echo "✓ Refactoring Safe    - Rename with confidence\n\n";

echo str_repeat('=', 62) . "\n";
echo "📚 Available Asset Types:\n";
echo str_repeat('=', 62) . "\n";
echo "• TitleAsset       - Headlines and titles\n";
echo "• ImageAsset       - Images (icon, logo, main)\n";
echo "• DataAsset        - Text data (sponsor, desc, CTA, price, etc.)\n";
echo "• VideoAsset       - Video creatives\n\n";

echo str_repeat('=', 62) . "\n";
echo "🔄 Backward Compatibility:\n";
echo str_repeat('=', 62) . "\n";
echo "Old way still works:\n";
echo "  \$native->setRequest(json_encode(\$array));\n\n";
echo "New way is cleaner:\n";
echo "  \$native->setRequest(new NativeRequest());\n\n";
echo "Both produce identical OpenRTB 2.5 JSON output!\n\n";

echo str_repeat('=', 62) . "\n";
echo "💡 Pro Tip: Extract Native Request from Response\n";
echo str_repeat('=', 62) . "\n";
echo "If you receive a request, convert JSON back to objects:\n";
echo "  \$nativeObj = \$native->getRequestObject();\n";
echo "  \$assets = \$nativeObj->getAssets();\n";
echo "  foreach (\$assets as \$asset) {\n";
echo "    if (\$asset instanceof TitleAsset) {\n";
echo "      echo \"Title max length: \" . \$asset->getLen();\n";
echo "    }\n";
echo "  }\n\n";
