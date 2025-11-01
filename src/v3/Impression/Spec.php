<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Placement\Placement;

class Spec implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'placement' => Placement::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setPlacement(Placement $placement): self
    {
        return $this->set('placement', $placement);
    }

    public function getPlacement(): ?Placement
    {
        return $this->get('placement');
    }
}
