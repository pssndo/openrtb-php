<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Title extends BaseObject
{
    public function setText(string $text): self
    {
        return $this->set('text', $text);
    }

    public function getText(): ?string
    {
        return $this->get('text');
    }
}
