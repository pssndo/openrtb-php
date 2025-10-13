<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums;

enum NoBidReason: int
{
    case UNKNOWN_ERROR = 0;
    case TECHNICAL_ERROR = 1;
    case INVALID_REQUEST = 2;
    case KNOWN_WEB_SPIDER = 3;
    case SUSPECTED_NON_HUMAN = 4;
    case CLOUD_DATACENTER = 5;
    case UNSUPPORTED_DEVICE = 6;
    case BLOCKED_PUBLISHER = 7;
    case UNMATCHED_USER = 8;
    case DAILY_READER_CAP = 9;
    case DAILY_DOMAIN_CAP = 10;
}
