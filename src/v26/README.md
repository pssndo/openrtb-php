# OpenRTB 2.6 PHP Library

A complete, type-safe PHP implementation of the IAB OpenRTB 2.6 specification.

This library provides a robust, object-oriented interface for building, parsing, and validating OpenRTB 2.6 bid requests and responses with enhanced support for privacy, supply chain transparency, and additional ad formats.

## Features

- ✅ **Complete OpenRTB 2.6 Implementation** - Full support for all objects and fields
- ✅ **Enhanced Privacy Support** - GDPR, CCPA, and extended consent management
- ✅ **Supply Chain Object (schain)** - Full ads.txt and supply chain transparency
- ✅ **Type-Safe** - Full PHPStan Level 8 compliance with strict type hints
- ✅ **Fluent API** - Chain method calls for clean, readable code
- ✅ **Built-in Validation** - Validate bid requests against OpenRTB requirements
- ✅ **Builders** - RequestBuilder and BidResponseBuilder for simplified object creation
- ✅ **Parser** - Convert JSON to strongly-typed PHP objects
- ✅ **All Ad Formats** - Banner, Video, Audio, and Native advertising support
- ✅ **DOOH Support** - Digital Out-of-Home advertising enhancements

## What's New in OpenRTB 2.6

OpenRTB 2.6 introduces several important enhancements over 2.5:

- **Enhanced Regulations Object** - Extended GDPR and US Privacy support
- **Supply Chain Enhancements** - Improved supply chain transparency
- **Extended User IDs** - Support for multiple user ID types and sources
- **Additional Video Fields** - Enhanced video advertising capabilities
- **DOOH Improvements** - Better support for digital out-of-home advertising
- **Privacy Enhancements** - More granular privacy controls

---

## Installation

Install via Composer:

```bash
composer require your-vendor/openrtb
```

---

## Quick Start

### Creating a Bid Request with Privacy Signals

```php
<?php
require_once 'vendor/autoload.php';

use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Banner;

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

// Privacy and regulatory information (OpenRTB 2.6)
$regs = (new Regs())
    ->setGdpr(1)
    ->setUsPrivacy('1YNN'); // US Privacy String (CCPA)

$user = (new User())
    ->setId('user-123')
    ->setConsent('CPXxRfAPXxRfAAfKABENB-CgAAAAAAAAAAYgAAAAAAAA'); // GDPR consent string

// Build the bid request
$request = new BidRequest();
$request->setId('request-123')
    ->addImp($imp)
    ->setSite($site)
    ->setDevice($device)
    ->setUser($user)
    ->setRegs($regs)
    ->setTest(0)
    ->setTmax(200);

// Convert to JSON
$json = $request->toJson();
echo $json;
```

### Supply Chain Object (schain)

OpenRTB 2.6 includes enhanced supply chain transparency:

```php
<?php
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\SupplyChain;
use OpenRTB\v26\Context\SupplyChain\Node;

// Create supply chain nodes
$node1 = (new Node())
    ->setAsi('directseller.com')
    ->setSid('00001')
    ->setHp(1) // Indicates this party participates in the transaction
    ->setRid('request-id-123')
    ->setName('Direct Seller')
    ->setDomain('directseller.com');

$node2 = (new Node())
    ->setAsi('reseller.com')
    ->setSid('00002')
    ->setHp(1)
    ->setRid('request-id-123')
    ->setName('Reseller')
    ->setDomain('reseller.com');

// Create supply chain
$supplyChain = (new SupplyChain())
    ->setComplete(1) // Complete chain
    ->setVer('1.0')
    ->setNodes([$node1, $node2]);

// Add to source object
$source = (new Source())
    ->setSchain($supplyChain)
    ->setFd(1); // Final decision on transaction

$request = new BidRequest();
$request->setId('schain-request')
    ->setSource($source);

echo $request->toJson();
```

---

## Enhanced Privacy Support

### GDPR and Consent String

```php
<?php
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Context\Regs;

// GDPR regulations
$regs = (new Regs())
    ->setGdpr(1) // GDPR applies
    ->setCoppa(0); // Not subject to COPPA

// User with GDPR consent
$user = (new User())
    ->setId('user-123')
    ->setYob(1990)
    ->setGender('M')
    ->setConsent('CPXxRfAPXxRfAAfKABENB-CgAAAAAAAAAAYgAAAAAAAA'); // IAB TCF 2.0 consent string

$request->setRegs($regs)
    ->setUser($user);
```

### US Privacy (CCPA) Support

```php
<?php
use OpenRTB\v26\Context\Regs;

// US Privacy String (CCPA)
$regs = (new Regs())
    ->setUsPrivacy('1YNN'); // 1YNN = Do Not Sell flag set

$request->setRegs($regs);
```

---

## Using the Request Builder

The RequestBuilder provides a fluent interface for creating complex bid requests:

```php
<?php
use OpenRTB\v26\Util\RequestBuilder;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;

$builder = new RequestBuilder('request-id-123');

$request = $builder
    ->setTest(0)
    ->setTmax(200)
    ->addBannerImp('imp-1', 300, 250, 1.50)
    ->setSite((new Site())->setDomain('example.com'))
    ->setDevice((new Device())->setUa('Mozilla/5.0...'))
    ->setRegs((new Regs())->setGdpr(1)->setUsPrivacy('1YNN'))
    ->setCur(['USD', 'EUR'])
    ->build();

echo $request->toJson();
```

---

## Video Ad Request with Extended Fields

OpenRTB 2.6 adds additional video fields:

```php
<?php
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Video;

$video = (new Video())
    ->setMimes(['video/mp4', 'video/webm'])
    ->setMinduration(5)
    ->setMaxduration(30)
    ->setProtocols([2, 3, 5, 6]) // VAST 2.0, 3.0, Wrappers
    ->setW(1920)
    ->setH(1080)
    ->setLinearity(1) // Linear / In-Stream
    ->setPos(1) // Above the fold
    ->setPlacement(1) // In-Stream
    ->setPlaybackmethod([1, 3]) // Auto-play sound on, Click to play
    ->setApi([1, 2]); // VPAID 1.0, VPAID 2.0

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

## Parsing Bid Responses

Use the Factory's parser for clean, typed response handling:

```php
<?php
use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.6');

// Receive response from provider
$jsonResponse = file_get_contents('php://input');
$response = $factory->createParser()->parseBidResponse($jsonResponse);

// Access with full type safety
$seatbids = $response->getSeatbid();
foreach ($seatbids as $seatbid) {
    foreach ($seatbid->getBid() as $bid) {
        echo $bid->getPrice();
        echo $bid->getNurl(); // Win notification URL
        echo $bid->getBurl(); // Billing URL
    }
}
```

### Method 2: Using Manual Construction

For building responses from scratch:

```php
<?php
use OpenRTB\v26\BidResponse;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;

// Create a bid
$bid = (new Bid())
    ->setId('bid-1')
    ->setImpid('imp-1')
    ->setPrice(2.50)
    ->setAdm('<VAST version="3.0">...</VAST>')
    ->setAdomain(['advertiser.com'])
    ->setCrid('creative-123')
    ->setW(300)
    ->setH(250)
    ->setNurl('https://win.notification.url')
    ->setBurl('https://billing.url')
    ->setLurl('https://loss.notification.url');

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

echo $response->toJson();
```

---

## Using the Response Builder

```php
<?php
use OpenRTB\v26\Util\BidResponseBuilder;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;

$builder = new BidResponseBuilder('request-123');

$bid = (new Bid())
    ->setId('bid-1')
    ->setImpid('imp-1')
    ->setPrice(2.50)
    ->setAdm('<div>Ad markup</div>');

$seatBid = (new SeatBid())
    ->setSeat('seat-1')
    ->setBid([$bid]);

$response = $builder
    ->setBidid('response-456')
    ->setCur('USD')
    ->addSeatBid($seatBid)();

echo $response->toJson();
```

---

## Parsing JSON

Use the Factory's parser to convert JSON strings into strongly-typed PHP objects:

```php
<?php
use OpenRTB\Factory\OpenRTBFactory;

$factory = new OpenRTBFactory('2.6');

// Parse a bid request
$json = '{"id":"req-1","imp":[{"id":"imp-1","banner":{"w":300,"h":250}}],"regs":{"gdpr":1}}';
$request = $factory->createParser()->parseBidRequest($json);

echo $request->getId(); // "req-1"
$regs = $request->getRegs();
echo $regs->getGdpr(); // 1

// Parse a bid response
$responseJson = '{"id":"req-1","seatbid":[{"bid":[{"id":"bid-1","impid":"imp-1","price":2.5}]}]}';
$response = $factory->createParser()->parseBidResponse($responseJson);

echo $response->getId(); // "req-1"
```

---

## Validation

Validate bid requests to ensure they meet OpenRTB requirements:

```php
<?php
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Util\Validator;

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

## Private Marketplace (PMP) with Extended Deals

```php
<?php
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Deal;
use OpenRTB\v26\Impression\Pmp;

$deal = (new Deal())
    ->setId('deal-123')
    ->setBidfloor(5.00)
    ->setBidfloorcur('USD')
    ->setAt(2) // Second price auction
    ->setWseat(['seat-1', 'seat-2']) // Whitelisted seats
    ->setWadv(['advertiser1.com', 'advertiser2.com']); // Whitelisted advertisers

$pmp = (new Pmp())
    ->setPrivateAuction(1)
    ->setDeals([$deal]);

$imp = (new Imp())
    ->setId('pmp-imp-1')
    ->setBanner((new Banner())->setW(728)->setH(90))
    ->setPmp($pmp);
```

---

## Object Structure

### Bid Request Objects

- **BidRequest** - Root request object
- **Impression/** - Impression objects
  - `Imp` - Impression
  - `Banner` - Banner ad format
  - `Video` - Video ad format (enhanced in 2.6)
  - `Audio` - Audio ad format
  - `Native` - Native ad format
  - `Pmp` - Private marketplace
  - `Deal` - PMP deal
  - `Metric` - Ad metrics
- **Context/** - Context objects
  - `Site` - Website context
  - `App` - Mobile app context
  - `Device` - Device information
  - `User` - User information (enhanced privacy)
  - `Geo` - Geographic location
  - `Content` - Content context
  - `Producer` - Content producer
  - `Publisher` - Publisher information
  - `Regs` - Regulatory information (enhanced in 2.6)
  - `Source` - Source information with supply chain
  - `SupplyChain` - Supply chain transparency (enhanced in 2.6)

### Bid Response Objects

- **BidResponse** - Root response object
- **Response/** - Response objects
  - `SeatBid` - Seat bid collection
  - `Bid` - Individual bid (enhanced notification URLs)

### Utility Classes

- **Util/** - Utility classes
  - `RequestBuilder` - Fluent bid request builder
  - `BidResponseBuilder` - Fluent bid response builder
  - `Parser` - JSON to object parser
  - `Validator` - Request validator

---

## Key Differences from OpenRTB 2.5

### Enhanced Privacy (Regs Object)

```php
// OpenRTB 2.5
$regs = (new Regs())
    ->setGdpr(1)
    ->setCoppa(0);

// OpenRTB 2.6 adds US Privacy
$regs = (new Regs())
    ->setGdpr(1)
    ->setCoppa(0)
    ->setUsPrivacy('1YNN'); // CCPA support
```

### Enhanced Supply Chain

OpenRTB 2.6 expands the supply chain object with additional node properties for better transparency.

### Extended Video Support

Additional fields for video placement, playback methods, and companion ads.

---

## Best Practices

### 1. Always Include Privacy Signals

```php
$regs = (new Regs())
    ->setGdpr(1) // If EU traffic
    ->setUsPrivacy('1YNN'); // If US traffic with CCPA

$user = (new User())
    ->setConsent('...'); // GDPR consent string

$request->setRegs($regs)->setUser($user);
```

### 2. Implement Supply Chain Transparency

```php
// Always include supply chain information for transparency
$source = (new Source())
    ->setSchain($supplyChain)
    ->setFd(1);

$request->setSource($source);
```

### 3. Use Validation Before Sending

```php
$validator = new Validator();
if (!$validator->validateBidRequest($request)) {
    throw new \RuntimeException(
        'Invalid request: ' . implode(', ', $validator->getErrors())
    );
}
```

### 4. Handle Multiple Currency Support

```php
// Specify accepted currencies in order of preference
$request->setCur(['USD', 'EUR', 'GBP']);

// Set floor prices with currency
$imp->setBidfloor(1.50)
    ->setBidfloorcur('USD');
```

---

## Migration from OpenRTB 2.5

OpenRTB 2.6 is backward compatible with 2.5. Main changes to consider:

1. **Add US Privacy String** - Include `usprivacy` in Regs object
2. **Enhanced Supply Chain** - Utilize extended schain properties
3. **Extended Video Fields** - Take advantage of new video capabilities
4. **Enhanced Notification URLs** - Use burl (billing URL) and lurl (loss URL) in responses

Example migration:

```php
// Before (2.5)
$regs = (new Regs())->setGdpr(1);

// After (2.6) - Add US Privacy
$regs = (new Regs())
    ->setGdpr(1)
    ->setUsPrivacy('1YNN');
```

---

## Testing

Run tests with:

```bash
vendor/bin/phpunit tests/v26/
```

---

## Reference

- [OpenRTB 2.6 Draft Specification](https://github.com/InteractiveAdvertisingBureau/openrtb2.x/blob/main/2.6.md)
- [IAB Tech Lab OpenRTB](https://iabtechlab.com/standards/openrtb/)
- [Supply Chain Object Specification](https://iabtechlab.com/ads-txt/)

---

## License

This library is licensed under the MIT License.
