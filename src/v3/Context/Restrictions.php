<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;

class Restrictions extends BaseObject
{
    protected static array $schema = [
        'cattax' => ContentTaxonomy::class,
        'battr' => [CreativeAttribute::class],
    ];

    /** @param list<string> $bcat */
    public function setBcat(array $bcat): static
    {
        return $this->set('bcat', $bcat);
    }

    /** @return list<string>|null */
    public function getBcat(): ?array
    {
        return $this->get('bcat');
    }

    public function setCattax(ContentTaxonomy $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?ContentTaxonomy
    {
        return $this->get('cattax');
    }

    /** @param list<string> $badv */
    public function setBadv(array $badv): static
    {
        return $this->set('badv', $badv);
    }

    /** @return list<string>|null */
    public function getBadv(): ?array
    {
        return $this->get('badv');
    }

    /** @param list<string> $bapp */
    public function setBapp(array $bapp): static
    {
        return $this->set('bapp', $bapp);
    }

    /** @return list<string>|null */
    public function getBapp(): ?array
    {
        return $this->get('bapp');
    }

    /** @param list<CreativeAttribute> $battr */
    public function setBattr(array $battr): static
    {
        return $this->set('battr', $battr);
    }

    /** @return list<CreativeAttribute>|null */
    public function getBattr(): ?array
    {
        return $this->get('battr');
    }
}
