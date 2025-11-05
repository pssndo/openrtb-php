<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class TitleFormat implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<class-string>>
     */
    protected static array $schema = [];

    /**
     * @return array<string, class-string|array<class-string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setLen(int $len): static
    {
        return $this->set('len', $len);
    }

    public function getLen(): ?int
    {
        return $this->get('len');
    }
}
