<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Bid;

/**
 * The following table lists the audit status codes for an ad.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--audit-status-codes-
 */
enum AuditStatus: int
{
    case PENDING = 1;
    case PRE_APPROVED = 2;
    case DENIED = 3;
    case REQUIRES_USER_DATA = 4;
}
