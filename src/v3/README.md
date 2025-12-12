# OpenRTB 3.0 PHP Library

A modern, fluent, and type-safe PHP library for implementing the IAB OpenRTB 3.0 and AdCOM 1.0 specifications.

This library provides a clean, object-oriented interface for building, parsing, and validating OpenRTB 3.0 bid requests and responses with full support for the AdCOM layer.

## Features

- ✅ **Full OpenRTB 3.0 & AdCOM 1.0 Support** - Complete implementation
- ✅ **Modern, PSR-4 Compliant Structure** for easy integration with any framework
- ✅ **Fluent, Type-Hinted API** for creating complex objects with clean, readable code
- ✅ **Type-Safe** - Full PHPStan Level 8 compliance
- ✅ **Schema-based Serialization** for lean, maintainable objects
- ✅ **Support for all major ad formats**: Display, Video, Audio, and Native
- ✅ **Comprehensive object model** including DOOH, Privacy (GDPR/CCPA), and more
- ✅ **Built-in Parser** for hydrating JSON into PHP objects
- ✅ **Request and Response Builders** for simplified object creation

## What's New in OpenRTB 3.0

OpenRTB 3.0 represents a major architectural change from 2.x:

- **Layered Architecture** - Separates transport (OpenRTB) from ad commerce (AdCOM)
- **Item-based Model** - Flexible "items" replace fixed impressions
- **Unified Placement Model** - Single placement object for all ad types
- **Enhanced Context** - Richer contextual information
- **Better DOOH Support** - First-class support for Digital Out-of-Home
- **Improved Native** - Native advertising as a core ad type
- **Flexible Extensions** - More extensible structure

---

## Installation

Install via Composer:

```bash
composer require your-vendor/openrtb
```

---

## Core Concepts

### 1. Layered Architecture

OpenRTB 3.0 uses a two-layer approach:

- **OpenRTB Layer** - Transport protocol (Request/Response)
- **AdCOM Layer** - Ad commerce objects (Context, Placement, Media)

### 2. Fluent Data Objects

All data objects provide fluent setters for clean code:

```php
<?php
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Geo;

$device = (new Device())
    ->setType(4) // Phone
    ->setMake('Apple')
    ->setModel('iPhone14,2')
    ->setOs('iOS')
    ->setOsv('15.0')
    ->setGeo((new Geo())->setCountry('USA'));

// Retrieve properties using getters
$make = $device->getMake(); // Returns 'Apple'
```

### 3. Item-Based Model

OpenRTB 3.0 uses "items" instead of "impressions":

```php
<?php
use OpenRTB\v3\BidRequest;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\DisplayPlacement;

$displayPlacement = (new DisplayPlacement())
    ->setW(300)
    ->setH(250);

$placement = (new Placement())
    ->setDisplay($displayPlacement);

$item = (new Item())
    ->setId('item-1')
    ->setFlr(1.50)
    ->setFlrcur('USD')
    ->setSpec((new Spec())->setPlacement($placement));

$request = (new BidRequest())
    ->setId('request-123')
    ->addItem($item);
```

---

## Directory & Namespace Structure

The library is organized into sub-namespaces that mirror the OpenRTB 3.0 specification:

- `OpenRTB\v3\BidRequest` - Bid request object
- `OpenRTB\v3\BidResponse` - Bid response object
- `OpenRTB\v3\Bid\*` - Response objects (Bid, Ad, Seatbid, etc.)
- `OpenRTB\v3\Context\*` - Context objects (Site, App, Device, User, DOOH, etc.)
- `OpenRTB\v3\Impression\*` - Impression objects (Item, Spec, Deal, Metric)
- `OpenRTB\v3\Placement\*` - Placement objects (DisplayPlacement, VideoPlacement, AudioPlacement, etc.)
- `OpenRTB\v3\Util\*` - Utility classes (Parser, RequestBuilder, ResponseBuilder, Validator)

---

## Quick Start Example

Here is a basic example of building a display banner request:

```php
<?php
require_once 'vendor/autoload.php';

use OpenRTB\v3\BidRequest;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\DisplayPlacement;

// Define the placement details
$displayPlacement = (new DisplayPlacement())
    ->setW(300)
    ->setH(250)
    ->setPos(1); // Above the fold

$placement = (new Placement())
    ->setDisplay($displayPlacement);

$spec = (new Spec())
    ->setPlacement($placement);

// Create the item (equivalent to impression in 2.x)
$item = (new Item())
    ->setId('item-1')
    ->setFlr(0.50) // Floor price
    ->setFlrcur('USD')
    ->setSpec($spec);

// Define the context (e.g., a website)
$site = (new Site())
    ->setDomain('example.com')
    ->setPage('https://example.com/news');

$context = (new Context())
    ->setSite($site);

// Build the main request object
$request = (new BidRequest())
    ->setId('request-abc123')
    ->setTimeout(100)
    ->addItem($item)
    ->setContext($context);

// Serialize to JSON
echo $request->toJson();
```

---

## Video Ad Request

Create a video ad request with VAST support:

```php
<?php
use OpenRTB\v3\BidRequest;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\VideoPlacement;

$videoPlacement = (new VideoPlacement())
    ->setW(1920)
    ->setH(1080)
    ->setMimes(['video/mp4', 'video/webm'])
    ->setMindur(5)
    ->setMaxdur(30)
    ->setProtocols([8, 9]) // VAST 4.0, VAST 4.1
    ->setPlaymethod([1]) // Auto-play sound on
    ->setPos(1); // Above the fold

$placement = (new Placement())
    ->setVideo($videoPlacement);

$spec = (new Spec())
    ->setPlacement($placement);

$item = (new Item())
    ->setId('video-item-1')
    ->setFlr(5.00)
    ->setFlrcur('USD')
    ->setSpec($spec);

$request = (new BidRequest())
    ->setId('video-request-1')
    ->addItem($item);

echo $request->toJson();
```

---

## Native Ad Request

Create a native ad request using the native placement:

```php
<?php
use OpenRTB\v3\BidRequest;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\NativePlacement;
use OpenRTB\v3\Placement\AssetFormat;
use OpenRTB\v3\Placement\TitleFormat;
use OpenRTB\v3\Placement\ImageFormat;
use OpenRTB\v3\Placement\DataFormat;

// Define asset formats for native ad
$titleFormat = (new TitleFormat())
    ->setLen(80);

$imageFormat = (new ImageFormat())
    ->setW(300)
    ->setH(250)
    ->setMimes(['image/jpeg', 'image/png']);

$dataFormat = (new DataFormat())
    ->setType(2) // Sponsored by
    ->setLen(120);

$titleAsset = (new AssetFormat())
    ->setId(1)
    ->setReq(1) // Required
    ->setTitle($titleFormat);

$imageAsset = (new AssetFormat())
    ->setId(2)
    ->setReq(1)
    ->setImg($imageFormat);

$dataAsset = (new AssetFormat())
    ->setId(3)
    ->setReq(0) // Optional
    ->setData($dataFormat);

$nativePlacement = (new NativePlacement())
    ->setAsset([$titleAsset, $imageAsset, $dataAsset]);

$placement = (new Placement())
    ->setNative($nativePlacement);

$spec = (new Spec())
    ->setPlacement($placement);

$item = (new Item())
    ->setId('native-item-1')
    ->setFlr(1.00)
    ->setFlrcur('USD')
    ->setSpec($spec);

$request = (new BidRequest())
    ->setId('native-request-1')
    ->addItem($item);

echo $request->toJson();
```

---

## DOOH (Digital Out-of-Home) Request

OpenRTB 3.0 provides first-class DOOH support:

```php
<?php
use OpenRTB\v3\BidRequest;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Dooh;
use OpenRTB\v3\Context\Geo;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\DisplayPlacement;

// DOOH venue information
$geo = (new Geo())
    ->setLat(40.7128)
    ->setLon(-74.0060)
    ->setCountry('USA')
    ->setCity('New York');

$dooh = (new Dooh())
    ->setVenue(1) // Airborne
    ->setFixed(1) // Fixed location
    ->setEtch(3) // Eye-tracking hours (3+ hours)
    ->setGeo($geo);

$context = (new Context())
    ->setDooh($dooh);

$displayPlacement = (new DisplayPlacement())
    ->setW(1920)
    ->setH(1080)
    ->setPos(1);

$placement = (new Placement())
    ->setDisplay($displayPlacement);

$spec = (new Spec())
    ->setPlacement($placement);

$item = (new Item())
    ->setId('dooh-item-1')
    ->setFlr(10.00)
    ->setFlrcur('USD')
    ->setSpec($spec);

$request = (new BidRequest())
    ->setId('dooh-request-1')
    ->addItem($item)
    ->setContext($context);

echo $request->toJson();
```

---

## Creating a Bid Response

### Method 1: Using fromArray() (Recommended for Provider Responses)

If you're receiving a response from a provider, use the automatic hydration method:

```php
<?php
use OpenRTB\v3\BidResponse;

// Receive response from provider
$jsonResponse = file_get_contents('php://input');
$rawData = json_decode($jsonResponse, true);

// Automatic hydration - creates all nested objects automatically
$response = BidResponse::fromArray($rawData);

// Access with full type safety
$seatbids = $response->getSeatbid();
foreach ($seatbids as $seatbid) {
    foreach ($seatbid->getBid() as $bid) {
        echo $bid->getPrice();
        echo $bid->getItem(); // Item reference (not impid in v3)
    }
}
```

### Method 2: Using Manual Construction

For building responses from scratch:

```php
<?php
use OpenRTB\v3\BidResponse;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Display\Banner;

// Create ad markup
$banner = (new Banner())
    ->setLink('https://advertiser.com/landing')
    ->setAdm('<div>Your ad markup here</div>');

$display = (new \OpenRTB\v3\Bid\Display())
    ->setBanner($banner);

$ad = (new Ad())
    ->setId('ad-1')
    ->setAdomain(['advertiser.com'])
    ->setDisplay($display);

// Create bid
$bid = (new Bid())
    ->setId('bid-1')
    ->setItem('item-1')
    ->setPrice(2.50)
    ->setAdm([$ad]);

// Create seat bid
$seatbid = (new Seatbid())
    ->setSeat('seat-1')
    ->setBid([$bid]);

// Build response
$response = (new BidResponse())
    ->setId('request-123')
    ->setBidid('response-456')
    ->setCur('USD')
    ->setSeatbid([$seatbid]);

echo $response->toJson();
```

---

## Using the Request Builder

Simplify request creation with the RequestBuilder:

```php
<?php
use OpenRTB\v3\Util\RequestBuilder;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Placement\DisplayPlacement;

$builder = new RequestBuilder('request-123');

$request = $builder
    ->setTimeout(200)
    ->addDisplayItem('item-1', 300, 250, 1.50)
    ->setContext((new Context())->setSite((new Site())->setDomain('example.com')))
    ->setCur(['USD', 'EUR'])
    ->build();

echo $request->toJson();
```

---

## Using the Response Builder

Simplify response creation with the ResponseBuilder:

```php
<?php
use OpenRTB\v3\Util\ResponseBuilder;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Ad;

$builder = new ResponseBuilder('request-123');

$ad = (new Ad())
    ->setId('ad-1')
    ->setAdomain(['advertiser.com']);

$bid = (new Bid())
    ->setId('bid-1')
    ->setItem('item-1')
    ->setPrice(2.50)
    ->setAdm([$ad]);

$response = $builder
    ->setBidid('response-456')
    ->setCur('USD')
    ->addBid('seat-1', $bid)
    ->build();

echo $response->toJson();
```

---

## Parsing JSON

### Option 1: Using fromArray() (Recommended)

The modern approach uses automatic hydration:

```php
<?php
use OpenRTB\v3\BidResponse;

// Parse JSON to array first
$jsonResponse = '{"id":"req-1","seatbid":[{"bid":[{"id":"bid-1","item":"item-1","price":2.5}]}]}';
$rawData = json_decode($jsonResponse, true);

// Automatic hydration - all nested objects created automatically
$response = BidResponse::fromArray($rawData);

echo $response->getId(); // "req-1"
$seatbids = $response->getSeatbid();
foreach ($seatbids as $seatbid) {
    foreach ($seatbid->getBid() as $bid) {
        echo $bid->getPrice(); // 2.5
        echo $bid->getItem(); // "item-1"
    }
}
```

### Option 2: Using the Parser

Use the Parser to convert JSON strings into strongly-typed PHP objects:

```php
<?php
use OpenRTB\v3\Util\Parser;

$parser = new Parser();

// Parse a bid request
$json = '{"id":"req-1","item":[{"id":"item-1","spec":{"placement":{"display":{"w":300,"h":250}}}}]}';
$request = $parser->parseBidRequest($json);

echo $request->getId(); // "req-1"
$items = $request->getItem();
echo count($items); // 1

// Parse a bid response
$responseJson = '{"id":"req-1","seatbid":[{"bid":[{"id":"bid-1","item":"item-1","price":2.5}]}]}';
$response = $parser->parseBidResponse($responseJson);

echo $response->getId(); // "req-1"
```

---

## Privacy and Regulatory Support

OpenRTB 3.0 includes enhanced privacy controls:

```php
<?php
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Context\Regs;

$regs = (new Regs())
    ->setGdpr(1) // GDPR applies
    ->setCoppa(0) // Not subject to COPPA
    ->setUsPrivacy('1YNN'); // CCPA compliance string

$user = (new User())
    ->setId('user-123')
    ->setConsent('CPXxRfAPXxRfAAfKABENB-CgAAAAAAAAAAYgAAAAAAAA'); // GDPR consent

$context = (new Context())
    ->setUser($user)
    ->setRegs($regs);

$request->setContext($context);
```

---

## Validation

Validate requests to ensure they meet OpenRTB requirements:

```php
<?php
use OpenRTB\v3\BidRequest;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Util\Validator;

$request = new BidRequest();
$request->setId('req-1');
$request->addItem((new Item())->setId('item-1'));

$validator = new Validator();
$isValid = $validator->validateBidRequest($request);

if (!$isValid) {
    $errors = $validator->getErrors();
    foreach ($errors as $error) {
        echo "Validation error: $error\n";
    }
}
```

---

## Object Structure Overview

### Request Layer (OpenRTB)
- **BidRequest** - Root request
- **Item** - Ad opportunity (replaces Impression from 2.x)
- **Spec** - Specification for the item
- **Deal** - Private marketplace deal
- **Metric** - Metrics for the item

### Context Layer (AdCOM)
- **Context** - Root context object
- **Site** - Website context
- **App** - Mobile app context
- **Dooh** - Digital out-of-home context
- **Device** - Device information
- **User** - User information
- **Regs** - Regulatory constraints
- **Restrictions** - Content restrictions
- **Geo** - Geographic location
- **Content** - Content context

### Placement Layer (AdCOM)
- **Placement** - Unified placement object
- **DisplayPlacement** - Display/banner placements
- **VideoPlacement** - Video placements
- **AudioPlacement** - Audio placements
- **NativePlacement** - Native placements

### Response Layer (OpenRTB)
- **BidResponse** - Root response
- **Seatbid** - Collection of bids from a seat
- **Bid** - Individual bid
- **Ad** - Ad markup and metadata

---

## Key Differences from OpenRTB 2.x

### 1. Architecture
- **2.x**: Monolithic structure
- **3.0**: Layered (OpenRTB + AdCOM)

### 2. Ad Opportunities
- **2.x**: Impressions (`imp`)
- **3.0**: Items (`item`)

### 3. Ad Formats
- **2.x**: Separate objects (Banner, Video, Native, Audio)
- **3.0**: Unified Placement object with type-specific properties

### 4. Context
- **2.x**: Flat structure (site, app, device as separate top-level fields)
- **3.0**: Nested Context object containing site/app/dooh

### 5. Native
- **2.x**: String-based native request
- **3.0**: Structured NativePlacement object

---

## Migration from OpenRTB 2.x

Key changes when migrating:

```php
// OpenRTB 2.5
$imp = (new Imp())
    ->setId('imp-1')
    ->setBanner($banner);
$request->addImp($imp);

// OpenRTB 3.0
$item = (new Item())
    ->setId('item-1')
    ->setSpec((new Spec())->setPlacement($placement));
$request->addItem($item);
```

```php
// OpenRTB 2.5
$request->setSite($site);

// OpenRTB 3.0
$request->setContext((new Context())->setSite($site));
```

---

## Best Practices

### 1. Use Builders for Complex Objects

```php
$builder = new RequestBuilder('request-id');
$request = $builder
    ->addDisplayItem('item-1', 300, 250, 1.50)
    ->setContext($context)
    ->build();
```

### 2. Always Include Privacy Signals

```php
$regs = (new Regs())
    ->setGdpr(1)
    ->setUsPrivacy('1YNN');

$context->setRegs($regs);
```

### 3. Validate Before Sending

```php
$validator = new Validator();
if (!$validator->validateBidRequest($request)) {
    // Handle validation errors
}
```

---

## Testing

Run tests with:

```bash
vendor/bin/phpunit tests/v3/
```

---

## Reference

- [OpenRTB 3.0 Specification](https://github.com/InteractiveAdvertisingBureau/openrtb3.x)
- [AdCOM 1.0 Specification](https://github.com/InteractiveAdvertisingBureau/AdCOM)
- [IAB Tech Lab](https://iabtechlab.com/standards/openrtb/)

---

## Contributing

Contributions are welcome! Please ensure:
- Code follows PSR-12 coding standards
- All public methods have proper type hints
- New features include usage examples
- PHPStan Level 8 compliance is maintained

---

## License

This library is licensed under the MIT License.
