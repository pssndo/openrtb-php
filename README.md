# OpenRTB for PHP

[![Latest Version](https://img.shields.io/packagist/v/passendo/openrtb-php.svg)](https://packagist.org/packages/passendo/openrtb-php)
[![Run PHPUnit Tests](https://github.com/pssndo/openrtb-php/actions/workflows/ci.yml/badge.svg)](https://github.com/pssndo/openrtb-php/actions/workflows/ci.yml)
![Code Coverage](.github/badges/coverage.svg?v=2)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A modern, PSR-4 compliant PHP library for the OpenRTB 2.5, 2.6, and 3.0 specifications. This library provides an intuitive, object-oriented interface for building and parsing OpenRTB requests and responses, complete with robust validation and a fluent API.

## Key Features

*   **Fluent Builder Pattern**: Construct complex OpenRTB requests and responses with an expressive, chainable API.
*   **Object-Oriented**: Maps all OpenRTB entities to clean, well-structured PHP objects.
*   **JSON Serialization**: Easily serialize request and response objects to JSON.
*   **JSON Deserialization**: Hydrate JSON strings back into their corresponding PHP objects with a powerful `Parser`.
*   **Request/Response Validation**: A `Validator` utility to ensure your objects conform to the OpenRTB specification before serialization.
*   **Modern PHP**: Built for PHP 8.0+ with strict typing and modern development practices.
*   **PSR-4 Autoloading**: Compliant with modern PHP standards for easy integration.

## Installation

Install the library via [Composer](https://getcomposer.org/):

```sh
composer require passendo/openrtb-php
```

## Usage

The library uses a Factory pattern for clean, version-agnostic code. This is the recommended approach.

> **Note:** For more detailed and advanced use cases, please refer to the [Examples](#examples) section below.

### Creating a Bid Request (Recommended: Factory Pattern)

Use `OpenRTBFactory` to automatically handle version-specific builders and parsers:

```php
use OpenRTB\Factory\OpenRTBFactory;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Enums\AuctionType;

// Create factory for your OpenRTB version
$factory = new OpenRTBFactory('2.5'); // or '2.6', '3.0'

// Build request using fluent API
$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    ->setTest(0)
    ->setAt(AuctionType::FIRST_PRICE)
    ->setTmax(250)
    ->setCur(['USD'])
    ->setBcat(['IAB25', 'IAB26'])
    ->setSite((new Site())
        ->setId('site-123')
        ->setDomain('example.com'))
    ->setDevice((new Device())
        ->setUa('Mozilla/5.0...')
        ->setIp('192.168.1.1'))
    ->addImp((new Imp())
        ->setId('imp-1')
        ->setBanner((new Banner())
            ->setW(300)
            ->setH(250))
        ->setBidfloor(1.50))();  // Call __invoke() to get the request

// Serialize to JSON
$jsonRequest = $request->toJson();
echo $jsonRequest;
```

**Complex Example with Context:**

```php
use OpenRTB\v3\Util\RequestBuilder;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\VideoPlacement;
use OpenRTB\v3\Enums\Placement\Linearity;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;

// Define a video placement
$videoPlacement = (new VideoPlacement())
    ->setLinear(Linearity::LINEAR)
    ->setMindur(5)
    ->setMaxdur(30);

$placement = (new Placement())->setVideo($videoPlacement);
$spec = (new Spec())->setPlacement($placement);
$item = (new Item())->setId('video-item-1')->setSpec($spec);

// Define device and user context
$device = (new Device())->setIp('192.168.1.1')->setUa('Mozilla/5.0...');
$context = (new Context())->setDevice($device);

// Build the request
$builder = new RequestBuilder();
$request = $builder
    ->setId('complex-request-789')
    ->addItem($item)
    ->setContext($context)
    ->build();

echo $request->toJson();
```

### Parsing Bid Responses

Use the Factory's parser to convert JSON responses into typed objects:

```php
// Parse response from exchange/SSP
$responseJson = file_get_contents('php://input');
$response = $factory->createParser()->parseBidResponse($responseJson);

// Access typed data
foreach ($response->getSeatbid() as $seatbid) {
    foreach ($seatbid->getBid() as $bid) {
        echo "Bid Price: " . $bid->getPrice() . "\n";
        echo "Creative ID: " . $bid->getCrid() . "\n";
    }
}
```

### Version Detection by Provider

Automatically use the correct OpenRTB version for your exchange:

```php
// Automatically uses OpenRTB 3.0 for Epom
$factory = OpenRTBFactory::forProvider('epom');

// Automatically uses OpenRTB 2.6 for Google
$factory = OpenRTBFactory::forProvider('google');

// Build request with the right version automatically
$request = $factory
    ->createRequestBuilder()
    ->setId(uniqid('', true))
    // ... your configuration
    ();
```

### Validation

Validate requests before sending:

```php
$validator = $factory->createValidator();

if (!$validator->validateBidRequest($request)) {
    $errors = $validator->getErrors();
    foreach ($errors as $error) {
        echo "Error: $error\n";
    }
}
```


## Examples

The `examples/v3` directory contains a variety of scripts demonstrating how to use the library for common use cases.

*   **Building Requests:**
    *   [Simple App Banner Request](examples/v3/build_app_banner_request.php)
    *   [Display Banner Request](examples/v3/build_display_banner_request.php)
    *   [Video Request](examples/v3/build_video_request.php)
    *   [DOOH Request](examples/v3/build_dooh_request.php)
    *   [Multi-Item Request](examples/v3/build_multi_item_request.php)
    *   [Native Ad Request](examples/v3/build_native_ad_request_and_response.php)
*   **Building Responses:**
    *   [Simple Bid Response](examples/v3/build_bid_response.php)
    *   [Video Response](examples/v3/build_video_response.php)
    *   [No-Bid Response](examples/v3/build_no_bid_response.php)
*   **Parsing and Validation:**
    *   [Parse and Validate a Request](examples/v3/parse_and_validate_request.php)
*   **Integration Example:**
    *   [Full SSP Integration Example](examples/v3/ssp_integration_example.php)

## Project Structure

The project is organized by OpenRTB specification version. All classes for a specific version are located within their own versioned namespace and directory.

-   `src/v3/`: Contains all classes for OpenRTB 3.0
-   `src/v26/`: Contains all classes for OpenRTB 2.6
-   `src/v25/`: Contains all classes for OpenRTB 2.5
-   `tests/`: Contains the unit tests, mirroring the `src` directory structure
-   `examples/`: Contains comprehensive usage examples for all versions

## Running Tests

To ensure the library is working correctly, run the full PHPUnit test suite from the project root:

```sh
./vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please feel free to submit a pull request.

1.  Fork the repository.
2.  Create a new feature branch (`git checkout -b feature/my-new-feature`).
3.  Commit your changes (`git commit -am 'Add some feature'`).
4.  Push to the branch (`git push origin feature/my-new-feature`).
5.  Create a new Pull Request.

## License

This library is open-source software licensed under the **GNU General Public License v3.0**. See the [LICENSE](LICENSE) file for more details.
