<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Parsing and Validating a Request Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Util\{Validator};
use OpenRTB\v3\Util\Parser;

// Example JSON request body
$jsonRequest = <<<'JSON'
{
  "id": "test-request-123",
  "at": 2,
  "tmax": 150,
  "item": [
    {
      "id": "item-1"
    }
  ],
  "context": {
    "site": {
        "domain": "example.com"
    }
  }
}
JSON;


// 1. Parse the request
$request = Parser::parseBidRequest($jsonRequest);

if ($request === null) {
    echo "Failed to parse request\n";
    // In a real application, you would likely return an HTTP 400 error.
    exit;
}

// 2. Validate the request
$validator = new Validator();
if ($validator->validateRequest($request)) {
    echo "Request is valid\n";
    echo "Request ID: " . $request->getId() . "\n";

    $items = $request->getItem();
    echo "Number of items: " . count($items) . "\n";

    $context = $request->getContext();
    if ($context->getSite()) {
        echo "Channel: Site\n";
        echo "Domain: " . $context->getSite()->getDomain() . "\n";
    } elseif ($context->getApp()) {
        echo "Channel: App\n";
        echo "Bundle: " . $context->getApp()->getBundle() . "\n";
    }
} else {
    echo "Request validation failed:\n";
    foreach ($validator->getErrors() as $error) {
        echo "- $error\n";
    }
    // In a real application, you would likely return an HTTP 400 error.
}
