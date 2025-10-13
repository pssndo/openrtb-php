<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;

class DataFormat extends BaseObject
{
    public function setType(int $type): self
    {
        return $this->set('type', $type);
    }

    public function getType(): ?int
    {
        return $this->get('type');
    }

    public function setLen(int $len): self
    {
        return $this->set('len', $len);
    }

    public function getLen(): ?int
    {
        return $this->get('len');
    }
}
