<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Placement\Placement;

class Spec implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|string>
     */
    protected static array $schema = [
        'placement' => Placement::class,
        'secure' => 'int',
        'admx' => 'int',
        'curlx' => 'int',
        'qty' => 'int',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setPlacement(Placement $placement): static
    {
        return $this->set('placement', $placement);
    }

    public function getPlacement(): ?Placement
    {
        return $this->get('placement');
    }

    public function setSecure(int $secure): static
    {
        return $this->set('secure', $secure);
    }

    public function getSecure(): ?int
    {
        return $this->get('secure');
    }

    public function setAdmx(int $admx): static
    {
        return $this->set('admx', $admx);
    }

    public function getAdmx(): ?int
    {
        return $this->get('admx');
    }

    public function setCurlx(int $curlx): static
    {
        return $this->set('curlx', $curlx);
    }

    public function getCurlx(): ?int
    {
        return $this->get('curlx');
    }

    public function setQty(int $qty): static
    {
        return $this->set('qty', $qty);
    }

    public function getQty(): ?int
    {
        return $this->get('qty');
    }
}
