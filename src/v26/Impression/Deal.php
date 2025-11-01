<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=30
 */
class Deal implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'string',
        'bidfloor' => 'float',
        'bidfloorcur' => 'string',
        'at' => 'int',
        'wseat' => 'array',
        'wadv' => 'array',
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setBidfloor(float $bidfloor): static
    {
        return $this->set('bidfloor', $bidfloor);
    }

    public function getBidfloor(): ?float
    {
        return $this->get('bidfloor');
    }

    public function setBidfloorcur(string $bidfloorcur): static
    {
        return $this->set('bidfloorcur', $bidfloorcur);
    }

    public function getBidfloorcur(): ?string
    {
        return $this->get('bidfloorcur');
    }

    public function setAt(int $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?int
    {
        return $this->get('at');
    }

    /** @param list<string> $wseat */
    public function setWseat(array $wseat): static
    {
        return $this->set('wseat', $wseat);
    }

    /** @return list<string>|null */
    public function getWseat(): ?array
    {
        return $this->get('wseat');
    }

    /** @param list<string> $wadv */
    public function setWadv(array $wadv): static
    {
        return $this->set('wadv', $wadv);
    }

    /** @return list<string>|null */
    public function getWadv(): ?array
    {
        return $this->get('wadv');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
