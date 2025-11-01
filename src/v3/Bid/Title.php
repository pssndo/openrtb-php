<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Title implements ObjectInterface
{
    use HasData;

    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setText(string $text): self
    {
        return $this->set('text', $text);
    }

    public function getText(): ?string
    {
        return $this->get('text');
    }
}
