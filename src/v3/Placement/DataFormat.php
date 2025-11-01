<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class DataFormat implements ObjectInterface
{
    use HasData;

    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(int $type): self
    {
        return $this->set('type', $type);
    }

    public function setLen(int $len): self
    {
        return $this->set('len', $len);
    }

    public function getType(): ?int
    {
        return $this->get('type');
    }

    public function getLen(): ?int
    {
        return $this->get('len');
    }
}
