<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Banner extends BaseObject
{
    public function setImg(string $img): static
    {
        return $this->set('img', $img);
    }

    public function getImg(): ?string
    {
        return $this->get('img');
    }

    /** @param list<Link> $link */
    public function setLink(array $link): static
    {
        return $this->set('link', $link);
    }

    /** @return list<Link>|null */
    public function getLink(): ?array
    {
        return $this->get('link');
    }
}
