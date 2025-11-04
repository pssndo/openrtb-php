# OpenRTB Examples

This directory contains comprehensive examples demonstrating how to use the OpenRTB library for AdTech integrations.

## Quick Start Examples

### 1. Factory Usage (`factory_usage.php`)

**Purpose**: Learn the basics of the Factory pattern for version-agnostic code.

**Topics covered**:
- Creating factories by provider name
- Creating factories by version
- Registering custom providers
- Building requests and parsing responses
- Dynamic provider selection

**Run it**:
```bash
php examples/factory_usage.php
```

**Key takeaway**: Use `OpenRTBFactory::forProvider('provider')` to automatically get the correct OpenRTB version for any exchange.

---

### 2. Bidding Workflow (`bidding_workflow.php`)

**Purpose**: Complete multi-exchange bidding simulation.

**Topics covered**:
- Building bid requests for multiple exchanges
- Handling both OpenRTB 2.6 and 3.0 in one workflow
- Parsing responses from different versions
- Selecting winning bids

**Run it**:
```bash
php examples/bidding_workflow.php
```

**Key takeaway**: One unified workflow handles all OpenRTB versions seamlessly.

---

## Integration Examples

### 3. DSP Integration (`dsp_integration.php`)

**Purpose**: How to build a DSP (Demand Side Platform) that receives bid requests.

**Scenarios demonstrated**:
1. Receiving OpenRTB 3.0 request from Epom
2. Receiving OpenRTB 2.6 request from Dianomi
3. Dynamic SSP detection

**Topics covered**:
- Parsing incoming bid requests
- Validating requests
- Building no-bid responses
- Building successful bid responses
- Version-specific response structures

**Run it**:
```bash
php examples/dsp_integration.php
```

**Use case**: You're building a bidder that integrates with multiple SSPs (supply partners).

---

### 4. SSP Integration (`ssp_integration.php`)

**Purpose**: How to build an SSP (Supply Side Platform) that sends bid requests to DSPs.

**Flow demonstrated**:
1. Receive ad request from publisher
2. Build bid requests for each DSP partner
3. Send requests (simulated)
4. Parse responses
5. Select winning bid

**Topics covered**:
- Building requests for multiple DSP partners
- Handling different OpenRTB versions per partner
- Parsing and comparing bids
- Winner selection logic

**Run it**:
```bash
php examples/ssp_integration.php
```

**Use case**: You're building a publisher platform that monetizes inventory through multiple DSPs.

---

### 5. Practical Bidder (`practical_bidder.php`)

**Purpose**: Production-ready bidder class structure.

**Features**:
- Single class handles both OpenRTB 2.6 and 3.0
- Request validation
- Intelligent bidding logic
- Creative management
- Error handling
- No-bid responses

**Topics covered**:
- Object-oriented bidder architecture
- Version-agnostic business logic
- Floor price evaluation
- Creative selection
- Response building

**Run it**:
```bash
php examples/practical_bidder.php
```

**Use case**: Starting point for building a real production bidder.

---

## Educational Examples

### 6. Version Comparison (`version_comparison.php`)

**Purpose**: Understand the differences between OpenRTB 2.6 and 3.0.

**Comparisons shown**:
- Request structure differences
- Response structure differences
- Field mapping between versions
- Migration tips

**Topics covered**:
- Side-by-side JSON comparison
- Structural changes (imp → item, context, media)
- Field renaming (impid → item, adm → media)
- Enum requirements

**Run it**:
```bash
php examples/version_comparison.php
```

**Key takeaway**: Complete reference for understanding version differences and migration path.

---

## Version-Specific Examples

### OpenRTB 2.6 Examples (`v26/`)

Directory contains OpenRTB 2.6-specific examples:

- `build_request.php` - Building bid requests
- `build_bid_response.php` - Building successful bid responses
- `build_no_bid_response.php` - Building no-bid responses
- `build_native_request.php` - Native ad requests
- `build_video_request.php` - Video ad requests
- `ssp_integration_example.php` - Complete SSP workflow

**Run any v2.6 example**:
```bash
php examples/v26/build_request.php
```

---

### OpenRTB 3.0 Examples (`v3/`)

Directory contains OpenRTB 3.0-specific examples:

- `build_display_banner_request.php` - Display banner requests
- `build_app_banner_request.php` - In-app banner requests
- `build_video_request.php` - Video ad requests
- `build_dooh_request.php` - Digital out-of-home requests
- `build_native_ad_request_and_response.php` - Native ads
- `build_multi_item_request.php` - Multi-item bidding
- `build_bid_response.php` - Successful bid responses
- `build_video_response.php` - Video bid responses
- `build_no_bid_response.php` - No-bid responses
- `parse_and_validate_request.php` - Request parsing and validation
- `ssp_integration_example.php` - Complete SSP workflow

**Run any v3.0 example**:
```bash
php examples/v3/build_display_banner_request.php
```

---

## Common Use Cases

### As a DSP (Receiving Bid Requests)

1. **Start with**: `dsp_integration.php`
2. **Then study**: `practical_bidder.php`
3. **Reference**: `version_comparison.php` for spec differences

**Your integration checklist**:
- [ ] Register your SSP partners with their OpenRTB versions
- [ ] Implement request parsing (handled by factory)
- [ ] Implement request validation
- [ ] Implement bidding logic (floor price, targeting, etc.)
- [ ] Implement creative management
- [ ] Build responses (handled by factory)

### As an SSP (Sending Bid Requests)

1. **Start with**: `ssp_integration.php`
2. **Then study**: `bidding_workflow.php`
3. **Reference**: Version-specific examples for request building

**Your integration checklist**:
- [ ] Register your DSP partners with their OpenRTB versions
- [ ] Convert publisher requests to OpenRTB format
- [ ] Send requests to DSPs (HTTP client)
- [ ] Parse and validate responses
- [ ] Select winning bid
- [ ] Handle timeouts and errors

### Learning the Library

**Recommended order**:
1. `factory_usage.php` - Understand the factory pattern
2. `version_comparison.php` - Learn version differences
3. `dsp_integration.php` OR `ssp_integration.php` - Pick your use case
4. `practical_bidder.php` - Production patterns
5. Version-specific examples - Deep dive into specific ad formats

---

## Key Concepts

### Factory Pattern

```php
use OpenRTB\Factory\OpenRTBFactory;

// Automatic version detection
$factory = OpenRTBFactory::forProvider('epom');  // Uses 3.0
$factory = OpenRTBFactory::forProvider('google'); // Uses 2.6

// Manual version selection
$factory = new OpenRTBFactory('2.6');
$factory = new OpenRTBFactory('3.0');
```

### Building Requests

```php
// Get version-appropriate builder
$builder = $factory->createRequestBuilder();

// Version-specific building (handled automatically)
$request = $builder
    ->setId('req-123')
    ->setTmax(100)
    // ... version-specific methods
    ();  // Call to build
```

### Parsing Responses

```php
// Get version-appropriate parser
$parser = $factory->createParser();

// Parse works for any version
$response = $parser->parseBidResponse($jsonString);
```

### Validation

```php
$validator = $factory->createValidator();

// Version-specific validation
if ($factory->getVersion() === '3.0') {
    $validator->validateRequest($request);
} else {
    $validator->validateBidRequest($request);
}

if ($validator->hasErrors()) {
    $errors = $validator->getErrors();
}
```

---

## Provider Registry

### Default Providers

These providers are pre-configured:

| Provider  | OpenRTB Version |
|-----------|-----------------|
| epom      | 3.0             |
| dianomi   | 2.6             |
| google    | 2.6             |
| rubicon   | 2.6             |
| appnexus  | 2.5 → 2.6       |
| pubmatic  | 2.6             |

### Register Custom Providers

```php
use OpenRTB\Factory\ProviderRegistry;

$registry = ProviderRegistry::getInstance();

// Single provider
$registry->register('my_exchange', '3.0');

// Batch registration
$registry->registerBatch([
    'exchange_a' => '2.6',
    'exchange_b' => '3.0',
    'exchange_c' => '2.6',
]);
```

---

## OpenRTB Version Differences Quick Reference

### Request Structure

| Aspect          | OpenRTB 2.6     | OpenRTB 3.0         |
|-----------------|-----------------|---------------------|
| Ad Opportunities| `imp[]`         | `item[]`            |
| Context         | Root level      | `context` object    |
| Media Spec      | `banner/video`  | `spec.placement`    |
| Quantity        | Not supported   | `item[].qty`        |

### Response Structure

| Aspect          | OpenRTB 2.6     | OpenRTB 3.0         |
|-----------------|-----------------|---------------------|
| Bid Reference   | `bid[].impid`   | `bid[].item`        |
| Creative        | `bid[].adm`     | `bid[].media`       |
| Ad Domain       | `bid[].adomain` | `media.ad.adomain`  |
| Dimensions      | `bid[].w/h`     | `media.ad.*.w/h`    |

---

## Testing

Run all examples to verify your environment:

```bash
# Test individual example
php examples/factory_usage.php

# Test all examples
for f in examples/*.php; do
    echo "Testing: $f"
    php "$f" > /dev/null 2>&1 && echo "✓ PASS" || echo "✗ FAIL"
done
```

---

## Further Resources

- **Factory Pattern Documentation**: [`FACTORY_USAGE.md`](../FACTORY_USAGE.md)
- **Main Documentation**: [`README.md`](../README.md)
- **OpenRTB 2.6 Spec**: [IAB OpenRTB 2.6](https://iabtechlab.com/standards/openrtb/)
- **OpenRTB 3.0 Spec**: [IAB OpenRTB 3.0](https://iabtechlab.com/standards/openrtb/)

---

## Support

For issues or questions:
1. Check the example that matches your use case
2. Review the inline comments in examples
3. Consult `FACTORY_USAGE.md` for factory pattern details
4. Check main `README.md` for API documentation

---

## Contributing

When adding new examples:
1. Follow the naming convention: `{purpose}_{type}.php`
2. Include comprehensive comments
3. Demonstrate a single concept or workflow
4. Add error handling
5. Update this README with your example

---

Happy bidding! 🎯
