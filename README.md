# OpenRTB for PHP

[![Latest Version](https://img.shields.io/packagist/v/passendo/openrtb-php.svg)](https://packagist.org/packages/passendo/openrtb-php)
[![Run PHPUnit Tests](https://github.com/pssndo/openrtb-php/actions/workflows/ci.yml/badge.svg)](https://github.com/pssndo/openrtb-php/actions/workflows/ci.yml)
[![Coverage Status](https://img.shields.io/coveralls/github/passendo/openrtb-php.svg)](https://coveralls.io/github/passendo/openrtb-php)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A modern, PSR-4 compliant PHP library for the OpenRTB 2.4, 2.6, and 3.0 specifications. This library provides an intuitive, object-oriented interface for building and parsing OpenRTB requests and responses, complete with robust validation and a fluent API.

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

The library is designed to be intuitive, allowing you to build and parse OpenRTB objects with ease.

> **Note:** For more detailed and advanced use cases, please refer to the [Examples](#examples) section below.

### Creating a Bid Request

The `RequestBuilder` provides a fluent interface for constructing a `Request` object. You can chain methods to configure the request and add complex objects like `Item`, `Context`, and `Source`.

**Simple Example:**

```php
use OpenRTB\v3\Util\RequestBuilder;
use OpenRTB\v3\Impression\Item;

// Create a new impression item
$item = (new Item())->setId('imp-123');

// Use the builder to construct the request
$builder = new RequestBuilder();
$request = $builder
    ->setId('request-id-456')
    ->setTest(true)
    ->addItem($item)
    ->build();

// Serialize the request to JSON
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

### Creating a Bid Response

Similarly, the `ResponseBuilder` helps you construct a valid `Response`. You can create `Seatbid` objects, add `Bid`s, and associate them with `Ad` media.

```php
use OpenRTB\v3\Util\ResponseBuilder;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\Ad;

// Create an Ad and Media
$ad = (new Ad())->setId('ad-123')->setAdomain(['advertiser.com']);
$media = (new Media())->setAd($ad);

// Create a Bid
$bid = (new Bid())->setId('bid-456')->setPrice(1.50)->setMedia($media);

// Create a Seatbid
$seatbid = (new Seatbid())->setSeat('seat-789')->addBid($bid);

// Use the builder to construct the response
$builder = new ResponseBuilder('request-id-456');
$response = $builder
    ->setBidId('response-id-abc')
    ->addSeatbid($seatbid)
    ->build();

echo $response->toJson();
```

### Parsing Requests and Responses

The `Parser` utility deserializes a JSON string into a fully-hydrated PHP object (`Request` or `Response`), including all nested objects.

```php
use OpenRTB\v3\Util\Parser;

// Parse a request
$jsonRequest = '{"id":"req-1","item":[{"id":"item-1"}]}';
$request = Parser::parseRequest($jsonRequest);

if ($request) {
    echo "Request ID: " . $request->getId();
}

// Parse a response
$jsonResponse = '{"id":"req-1","bidid":"resp-abc","seatbid":[]}';
$response = Parser::parseResponse($jsonResponse);

if ($response) {
    echo "Response Bid ID: " . $response->getBidid();
}
```

### Validating Objects

Before sending a request, you can validate it against the OpenRTB specification using the `Validator` to catch common errors.

```php
use OpenRTB\v3\Util\Validator;
use OpenRTB\v3\Request;

$request = new Request(); // An invalid request with no ID or items
$validator = new Validator();

if (!$validator->validateRequest($request)) {
    // Get a list of validation errors
    $errors = $validator->getErrors();
    print_r($errors);
    // Expected output:
    // Array
    // (
    //     [0] => Request ID is required
    //     [1] => Request must contain at least one Item
    // )
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

-   `src/v3/`: Contains all classes for OpenRTB 3.0.
-   `src/v26/`: (Future) Will contain classes for OpenRTB 2.6.
-   `src/v24/`: (Future) Will contain classes for OpenRTB 2.4.
-   `tests/`: Contains the unit tests, mirroring the `src` directory structure.

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
