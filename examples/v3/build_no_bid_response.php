<?php

declare(strict_types=1);

/**
 * OpenRTB 3.0 PHP Library - Building a No-Bid Response Example
 */

// In a real project, you would include Composer's autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\Util\ResponseBuilder;

// The ID of the bid request to which this is a response.
$requestId = 'test-request-789';

// The reason for not bidding. This should be one of the standard IAB codes.
$reason = NoBidReason::UNMATCHED_USER;

// 1. Create the ResponseBuilder
$responseBuilder = new ResponseBuilder($requestId);

// 2. Set the no-bid reason
// The builder will automatically handle the case where no seatbids are added,
// but explicitly setting a reason is good practice.
$responseBuilder->setNoBidReason($reason);

// 3. Build the final Response
// Since no seatbids were added, the response will be a valid no-bid response.
$response = $responseBuilder->build();

// Output the JSON
header('Content-Type: application/json');
echo $response->toJson();
