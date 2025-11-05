<?php

declare(strict_types=1);

namespace OpenRTB\Interfaces;

interface BidRequestInterface extends ObjectInterface
{
    // Common methods for all Bid Request objects can be defined here
    // For now, it just extends ObjectInterface, inheriting toArray, toJson, getSchema.
}
