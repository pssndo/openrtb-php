<?php

declare(strict_types=1);

namespace OpenRTB\v25\Enums;

/**
 * No-Bid Reason Codes - AdCOM List: No-Bid Reason Codes.
 *
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
enum NoBidReason: int
{
    case UNKNOWN_ERROR = 0;
    case TECHNICAL_ERROR = 1;
    case INVALID_REQUEST = 2;
    case KNOWN_WEB_SPIDER = 3;
    case SUSPECTED_NON_HUMAN_TRAFFIC = 4;
    case CLOUD_DATA_CENTER_OR_PROXY_IP = 5;
    case UNSUPPORTED_DEVICE = 6;
    case BLOCKED_PUBLISHER_OR_SITE = 7;
    case UNMATCHED_USER = 8;
    case DAILY_READER_CAP_MET = 9;
    case DAILY_DOMAIN_CAP_MET = 10;
}
