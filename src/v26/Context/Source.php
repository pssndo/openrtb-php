<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=42
 */
class Source implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'schain' => SupplyChain::class,
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setFd(int $fd): static
    {
        return $this->set('fd', $fd);
    }

    public function getFd(): ?int
    {
        return $this->get('fd');
    }

    public function setTid(string $tid): static
    {
        return $this->set('tid', $tid);
    }

    public function getTid(): ?string
    {
        return $this->get('tid');
    }

    public function setPchain(string $pchain): static
    {
        return $this->set('pchain', $pchain);
    }

    public function getPchain(): ?string
    {
        return $this->get('pchain');
    }

    public function setSchain(SupplyChain $schain): static
    {
        return $this->set('schain', $schain);
    }

    public function getSchain(): ?SupplyChain
    {
        return $this->get('schain');
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
