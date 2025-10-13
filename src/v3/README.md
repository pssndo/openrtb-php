# OpenRTB 3.0 PHP Library

A modern, fluent, and PSR-4 compliant PHP library for implementing the IAB OpenRTB 3.0 and AdCOM 1.0 specifications.

This library provides a clean, object-oriented interface for building, parsing, and validating OpenRTB 3.0 bid requests and responses.

## Features

- ✅ **Full OpenRTB 3.0 & AdCOM 1.0 Support**
- ✅ **Modern, PSR-4 Compliant Structure** for easy integration with any framework.
- ✅ **Fluent, Type-Hinted Setters and Getters** for creating complex objects with clean, readable code.
- ✅ **Schema-based Serialization** for lean, maintainable objects.
- ✅ **Support for all major ad formats**: Display, Video, Audio, and Native.
- ✅ **Comprehensive object model** including DOOH, Privacy (GDPR/CCPA), and more.
- ✅ **Built-in Parser** for hydrating JSON into PHP objects.

---

## Installation

This library is designed to be used with [Composer](https://getcomposer.org/). Add it to your `composer.json` file.

1.  **Require the library**:

    ```bash
    composer require your-vendor/openrtb-v3
    ```

2. **Use the autoloader**:
    The library's classes will be available automatically via Composer's autoloader.

   ```php
   <?php
   require_once 'vendor/autoload.php';
   // ...
   ```

---

## Core Concepts

### 1. Fluent Data Objects

All data objects (like `Site`, `Device`, `Bid`, etc.) extend a `BaseObject` which provides the core serialization logic. The data objects themselves provide explicit, fluent setters for a clean and intuitive developer experience.

```php
use src\v3\Context\Device;use src\v3\Enums\Context\DeviceType;

$device = new Device();

// Use the fluent, type-hinted setters
$device->setType(DeviceType::PHONE)
       ->setMake('Apple')
       ->setModel('iPhone14,2');

// Retrieve properties using the corresponding getters
$make = $device->getMake(); // Returns 'Apple'
```

### 2. Direct Object Creation

You create requests and responses by directly instantiating the corresponding classes and their dependencies. This provides a transparent and easy-to-understand way to build complex structures.

```php
use src\v3\Context\Context;use src\v3\Impression\Item;use src\v3\Request;

$item = (new Item())->setId('unique-item-id');

$context = new Context();
// ... populate context

$request = new Request();
$request->setId('unique-request-id')
    ->setAt(2)
    ->addItem($item)
    ->setContext($context);

$json = $request->toJson();
```

### 3. Directory & Namespace Structure

The library is organized into sub-namespaces that mirror the OpenRTB specification, making it easy to find the objects you need.

- `OpenRTB\v3\Bid\*` - Classes related to bid responses (Bid, Ad, Seatbid, etc.).
- `OpenRTB\v3\Context\*` - Classes describing the request context (Site, App, Device, User, etc.).
- `OpenRTB\v3\Impression\*` - Classes describing the ad impression (Item, Spec).
- `OpenRTB\v3\Placement\*` - Classes describing the ad placement itself (DisplayPlacement, VideoPlacement).
- `OpenRTB\v3\Util\*` - Utility classes (Parser).

---

## Usage Examples

Detailed examples for various use cases have been created and organized in the `/examples/v3/` directory. These provide the best reference for building specific types of requests and responses.

### Quick Start Example

Here is a basic example of building a display banner request.

```php
<?php
require_once 'vendor/autoload.php';

use src\v3\Context\{Site};use src\v3\Context\Context;use src\v3\Impression\{Spec};use src\v3\Impression\Item;use src\v3\Placement\{DisplayPlacement};use src\v3\Placement\Placement;use src\v3\Request;

// Define the placement details
$displayPlacement = (new DisplayPlacement())->setW(300)->setH(250);
$placement = (new Placement())->setDisplay($displayPlacement);
$spec = (new Spec())->setPlacement($placement);

// Create the impression item
$item = (new Item())
    ->setId('1')
    ->setFlr(0.50)
    ->setFlrcur('USD')
    ->setSpec($spec);

// Define the context (e.g., a website)
$context = (new Context())
    ->setSite((new Site())->setDomain('example.com'));

// Build the main request object
$request = (new Request())
    ->setId('some-unique-id')
    ->setTimeout(100)
    ->addItem($item)
    ->setContext($context);

// Serialize to JSON
echo $request->toJson();
```

---

## Contributing

Contributions are welcome! Please ensure:
- Code follows PSR-12 coding standards.
- All public methods have proper type hints.
- New features include usage examples.

## License

This library is licensed under the MIT License.
