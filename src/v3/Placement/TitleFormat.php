<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;

class TitleFormat extends BaseObject
{
    public function setLen(int $len): self
    {
        return $this->set('len', $len);
    }

    public function getLen(): ?int
    {
        return $this->get('len');
    }
}
