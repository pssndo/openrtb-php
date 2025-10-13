<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Data extends BaseObject
{
    public function setValue(string $value): self
    {
        return $this->set('value', $value);
    }

    public function getValue(): ?string
    {
        return $this->get('value');
    }
}
