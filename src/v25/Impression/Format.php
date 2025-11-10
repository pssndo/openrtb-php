<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=24
 */
class Format implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string>
     */
    protected static array $schema = [
        'w' => 'int',
        'h' => 'int',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }
}
