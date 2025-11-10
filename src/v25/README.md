# OpenRTB 2.5 PHP Library

A complete, type-safe PHP implementation of the IAB OpenRTB 2.5 specification with 100% test coverage.

This library provides a robust, object-oriented interface for building, parsing, and validating OpenRTB 2.5 bid requests and responses.

## Features

- ✅ **Complete OpenRTB 2.5 Implementation** - Full support for all objects and fields
- ✅ **100% Test Coverage** - Thoroughly tested with 338 tests and 437 assertions
- ✅ **Type-Safe** - Full PHPStan Level 8 compliance with strict type hints
- ✅ **Fluent API** - Chain method calls for clean, readable code
- ✅ **Built-in Validation** - Validate bid requests against OpenRTB requirements
- ✅ **Builders** - RequestBuilder and BidResponseBuilder for simplified object creation
- ✅ **Parser** - Convert JSON to strongly-typed PHP objects
- ✅ **All Ad Formats** - Banner, Video, Audio, and Native advertising support

---

## Installation

Install via Composer:

```bash
composer require your-vendor/openrtb
```

---

## Quick Start

### Creating a Bid Request

```php
<?php
require_once 'vendor/autoload.php';

use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Banner;

// Create a banner impression
$banner = (new Banner())
    ->setW(300)
    ->setH(250)
    ->setPos(1);

$imp = (new Imp())
    ->setId('imp-1')
    ->setBanner($banner)
    ->setBidfloor(1.50)
    ->setBidfloorcur('USD');

// Create site context
$site = (new Site())
    ->setId('site-123')
    ->setDomain('example.com')
    ->setPage('https://example.com/news');

// Create device information
$device = (new Device())
    ->setUa('Mozilla/5.0...')
    ->setIp('192.168.1.1')
    ->setDevicetype(2); // Phone

// Build the bid request
$request = new BidRequest();
$request->setId('request-123')
    ->addImp($imp)
    ->setSite($site)
    ->setDevice($device)
    ->setTest(0)
    ->setTmax(200);

// Convert to JSON
$json = $request->toJson();
echo $json;
```

### Creating a Bid Response

```php
<?php
use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;

// Create a bid
$bid = (new Bid())
    ->setId('bid-1')
    ->setImpid('imp-1')
    ->setPrice(2.50)
    ->setAdm('<div>Your ad markup here</div>')
    ->setAdomain(['advertiser.com'])
    ->setCrid('creative-123')
    ->setW(300)
    ->setH(250);

// Create a seat bid
$seatBid = (new SeatBid())
    ->setSeat('seat-1')
    ->setBid([$bid]);

// Build the bid response
$response = new BidResponse();
$response->setId('request-123')
    ->setBidid('bid-response-456')
    ->setCur('USD')
    ->setSeatbid([$seatBid]);

// Convert to JSON
$json = $response->toJson();
echo $json;
```

---

## Using the Request Builder

The RequestBuilder provides a fluent interface for creating complex bid requests:

```php
<?php
use OpenRTB\v25\Util\RequestBuilder;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Context\Device;

$builder = new RequestBuilder('request-id-123');

$request = $builder
    ->setTest(0)
    ->setTmax(200)
    ->addBannerImp('imp-1', 300, 250, 1.50)
    ->setSite((new Site())->setDomain('example.com'))
    ->setDevice((new Device())->setUa('Mozilla/5.0...'))
    ->setCur(['USD', 'EUR'])
    ->setBcat(['IAB25', 'IAB26'])
    ->build();

echo $request->toJson();
```

---

## Using the Response Builder

The BidResponseBuilder simplifies bid response creation:

```php
<?php
use OpenRTB\v25\Util\BidResponseBuilder;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;

$builder = new BidResponseBuilder('request-123');

// Create bids
$bid1 = (new Bid())
    ->setId('bid-1')
    ->setImpid('imp-1')
    ->setPrice(2.50)
    ->setAdm('<div>Ad 1</div>');

$bid2 = (new Bid())
    ->setId('bid-2')
    ->setImpid('imp-2')
    ->setPrice(3.00)
    ->setAdm('<div>Ad 2</div>');

// Add bids to seat
$seatBid = (new SeatBid())
    ->setSeat('seat-1')
    ->setBid([$bid1, $bid2]);

// Build response
$response = $builder
    ->setBidid('response-456')
    ->setCur('USD')
    ->addSeatBid($seatBid)();

echo $response->toJson();
```

---

## Parsing JSON

Use the Parser to convert JSON strings into strongly-typed PHP objects:

```php
<?php
use OpenRTB\v25\Util\Parser;

$parser = new Parser();

// Parse a bid request
$json = '{"id":"req-1","imp":[{"id":"imp-1","banner":{"w":300,"h":250}}]}';
$request = $parser->parseBidRequest($json);

echo $request->getId(); // "req-1"
$imps = $request->getImp();
echo count($imps); // 1

// Parse a bid response
$responseJson = '{"id":"req-1","seatbid":[{"bid":[{"id":"bid-1","impid":"imp-1","price":2.5}]}]}';
$response = $parser->parseBidResponse($responseJson);

echo $response->getId(); // "req-1"
```

---

## Validation

Validate bid requests to ensure they meet OpenRTB requirements:

```php
<?php
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Util\Validator;

$request = new BidRequest();
$request->setId('req-1');

$imp = (new Imp())
    ->setId('imp-1')
    ->setBanner(new Banner());

$request->addImp($imp);

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

## Video Ad Request

Create a video ad request with VAST support:

```php
<?php
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Video;

$video = (new Video())
    ->setMimes(['video/mp4', 'application/x-shockwave-flash'])
    ->setMinduration(5)
    ->setMaxduration(30)
    ->setProtocols([2, 3, 5, 6]) // VAST 2.0, 3.0, VAST 2.0 Wrapper, VAST 3.0 Wrapper
    ->setW(640)
    ->setH(480)
    ->setLinearity(1) // Linear / In-Stream
    ->setPos(1); // Above the fold

$imp = (new Imp())
    ->setId('video-imp-1')
    ->setVideo($video)
    ->setBidfloor(5.00)
    ->setBidfloorcur('USD');

$request = new BidRequest();
$request->setId('video-request-1')
    ->addImp($imp);

echo $request->toJson();
```

---

## Native Ad Request

Create a native ad request:

```php
<?php
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Native;

$nativeRequest = json_encode([
    'ver' => '1.2',
    'assets' => [
        ['id' => 1, 'required' => 1, 'title' => ['len' => 80]],
        ['id' => 2, 'required' => 1, 'img' => ['type' => 3, 'w' => 300, 'h' => 250]],
        ['id' => 3, 'required' => 0, 'data' => ['type' => 2, 'len' => 120]]
    ]
]);

$native = (new Native())
    ->setRequest($nativeRequest)
    ->setVer('1.2');

$imp = (new Imp())
    ->setId('native-imp-1')
    ->setNative($native)
    ->setBidfloor(1.00);

$request = new BidRequest();
$request->setId('native-request-1')
    ->addImp($imp);

echo $request->toJson();
```

---

## Private Marketplace (PMP) Deals

Create a request with private marketplace deals:

```php
<?php
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Deal;
use OpenRTB\v25\Impression\Pmp;

$deal1 = (new Deal())
    ->setId('deal-123')
    ->setBidfloor(5.00)
    ->setBidfloorcur('USD')
    ->setAt(2); // Second price auction

$deal2 = (new Deal())
    ->setId('deal-456')
    ->setBidfloor(7.50)
    ->setBidfloorcur('USD')
    ->setWseat(['seat-1', 'seat-2']); // Whitelist specific seats

$pmp = (new Pmp())
    ->setPrivateAuction(1)
    ->setDeals([$deal1, $deal2]);

$imp = (new Imp())
    ->setId('pmp-imp-1')
    ->setBanner((new Banner())->setW(300)->setH(250))
    ->setPmp($pmp);
```

---

## Supply Chain (SupplyChain) Support

Add supply chain transparency using SupplyChain object (ads.txt):

```php
<?php
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Context\Source;
use OpenRTB\v25\Context\SupplyChain;
use OpenRTB\v25\Context\SupplyChain\Node;

$node1 = (new Node())
    ->setAsi('exchange.com')
    ->setSid('publisher-123')
    ->setHp(1); // Hop position

$node2 = (new Node())
    ->setAsi('ssp.com')
    ->setSid('seller-456')
    ->setHp(2);

$supplyChain = (new SupplyChain())
    ->setComplete(1)
    ->setVer('1.0')
    ->setNodes([$node1, $node2]);

$source = (new Source())
    ->setSchain($supplyChain);

$request = new BidRequest();
$request->setId('schain-request-1')
    ->setSource($source);
```

---

## Object Structure

### Bid Request Objects

- **BidRequest** - Root request object
- **Impression/** - Impression objects
  - `Imp` - Impression
  - `Banner` - Banner ad format
  - `Video` - Video ad format
  - `Audio` - Audio ad format
  - `Native` - Native ad format
  - `Pmp` - Private marketplace
  - `Deal` - PMP deal
  - `Metric` - Ad metrics
- **Context/** - Context objects
  - `Site` - Website context
  - `App` - Mobile app context
  - `Device` - Device information
  - `User` - User information
  - `Geo` - Geographic location
  - `Content` - Content context
  - `Producer` - Content producer
  - `Publisher` - Publisher information
  - `Regs` - Regulatory information
  - `Source` - Source information
  - `SupplyChain` - Supply chain transparency

### Bid Response Objects

- **BidResponse** - Root response object
- **Response/** - Response objects
  - `SeatBid` - Seat bid collection
  - `Bid` - Individual bid

### Utility Classes

- **Util/** - Utility classes
  - `RequestBuilder` - Fluent bid request builder
  - `BidResponseBuilder` - Fluent bid response builder
  - `Parser` - JSON to object parser
  - `Validator` - Request validator

---

## Enums

OpenRTB 2.5 enums are available in the `Enums/` namespace:

- `AdPosition` - Ad position on screen
- `AuctionType` - First price, second price
- `ApiFramework` - VPAID, MRAID, ORMMA
- `BannerAdType` - XHTML, Flash, etc.
- `ConnectionType` - Unknown, Ethernet, Wifi, Cellular
- `ContentContext` - Video, Game, Music, etc.
- `CreativeAttribute` - Audio auto-play, expandable, etc.
- `DeviceType` - Mobile, PC, TV, etc.
- `Protocol` - VAST versions, DAAST, etc.
- `VideoLinearity` - Linear, non-linear
- And many more...

---

## Best Practices

### 1. Always Set Required Fields

```php
// Required: id and at least one impression
$request = new BidRequest();
$request->setId('unique-id'); // Required

$imp = (new Imp())
    ->setId('imp-id') // Required
    ->setBanner(new Banner()); // At least one ad format required

$request->addImp($imp);
```

### 2. Use Validation Before Sending

```php
$validator = new Validator();
if (!$validator->validateBidRequest($request)) {
    throw new \RuntimeException(
        'Invalid request: ' . implode(', ', $validator->getErrors())
    );
}
```

### 3. Handle Currency Properly

```php
// Specify accepted currencies
$request->setCur(['USD', 'EUR', 'GBP']);

// Set floor prices in the specified currency
$imp->setBidfloor(1.50)
    ->setBidfloorcur('USD');
```

### 4. Include Privacy Signals

```php
use OpenRTB\v25\Context\Regs;
use OpenRTB\v25\Context\User;

$regs = (new Regs())
    ->setCoppa(0) // Not subject to COPPA
    ->setGdpr(1); // GDPR applies

$user = (new User())
    ->setId('user-123')
    ->setConsent('consent-string-here'); // GDPR consent string

$request->setRegs($regs)
    ->setUser($user);
```

---

## Testing

All OpenRTB 2.5 classes have 100% test coverage. Run tests with:

```bash
vendor/bin/phpunit tests/v25/
```

---

## Reference

- [OpenRTB 2.5 Specification](https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf)
- [IAB Tech Lab](https://iabtechlab.com/standards/openrtb/)

---

## License

This library is licensed under the MIT License.
