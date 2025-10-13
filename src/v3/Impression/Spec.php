<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Placement\Placement;

class Spec extends BaseObject
{
    protected static array $schema = [
        'placement' => Placement::class,
    ];

    public function setPlacement(Placement $placement): self
    {
        return $this->set('placement', $placement);
    }

    public function getPlacement(): ?Placement
    {
        return $this->get('placement');
    }
}
