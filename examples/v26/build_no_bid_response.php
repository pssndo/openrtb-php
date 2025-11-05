<?php

declare(strict_types=1);

/**
 * OpenRTB 2.6 PHP Library - Building a No-Bid Response Example
 *
 * This example demonstrates how to construct an OpenRTB 2.6 No-Bid Response.
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v26\Util\BidResponseBuilder;

// The ID of the bid request to which this is a response
$requestId = 'test-request-789';

// No-bid reason codes (from OpenRTB 2.6 spec):
// 0 = Unknown Error
// 1 = Technical Error
// 2 = Invalid Request
// 3 = Known Web Spider
// 4 = Suspected Non-Human Traffic
// 5 = Cloud, Data Center, or Proxy IP
// 6 = Unsupported Device
// 7 = Blocked Publisher or Site
// 8 = Unmatched User
$noBidReason = 8; // Unmatched User

// Build the no-bid response
try {
    $responseBuilder = new BidResponseBuilder($requestId);
    $response = $responseBuilder
        ->setNbr($noBidReason)
        ->build();

    // Output the JSON
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Exception $e) {
    header('Content-Type: text/plain', true, 500);
    echo "Error building no-bid response: " . $e->getMessage();
}
