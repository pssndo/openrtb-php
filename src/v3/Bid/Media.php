<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Media implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string>
     */
    protected static array $schema = [
        'ad' => Ad::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setAd(Ad $ad): static
    {
        return $this->set('ad', $ad);
    }

    public function getAd(): ?Ad
    {
        return $this->get('ad');
    }
}
