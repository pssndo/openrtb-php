<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Media extends BaseObject
{
    protected static array $schema = [
        'ad' => Ad::class,
    ];

    public function setAd(Ad $ad): self
    {
        return $this->set('ad', $ad);
    }

    public function getAd(): ?Ad
    {
        return $this->get('ad');
    }
}
