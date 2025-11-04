<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;

class Restrictions implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<class-string>|array<string>>
     */
    protected static array $schema = [
        'cattax' => ContentTaxonomy::class,
        'battr' => [CreativeAttribute::class],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param Collection<string>|array<string> $bcat */
    public function setBcat(Collection|array $bcat): static
    {
        return $this->set('bcat', is_array($bcat) ? $bcat : $bcat->toArray());
    }

    /** @return Collection<string>|null */
    public function getBcat(): ?Collection
    {
        return new Collection($this->get('bcat') ?? [], 'string');
    }

    public function setCattax(ContentTaxonomy $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?ContentTaxonomy
    {
        return $this->get('cattax');
    }

    /** @param Collection<string>|array<string> $badv */
    public function setBadv(Collection|array $badv): static
    {
        return $this->set('badv', is_array($badv) ? $badv : $badv->toArray());
    }

    /** @return Collection<string>|null */
    public function getBadv(): ?Collection
    {
        return new Collection($this->get('badv') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $bapp */
    public function setBapp(Collection|array $bapp): static
    {
        return $this->set('bapp', is_array($bapp) ? $bapp : $bapp->toArray());
    }

    /** @return Collection<string>|null */
    public function getBapp(): ?Collection
    {
        return new Collection($this->get('bapp') ?? [], 'string');
    }

    /** @param Collection<CreativeAttribute>|array<CreativeAttribute> $battr */
    public function setBattr(Collection|array $battr): static
    {
        return $this->set('battr', is_array($battr) ? $battr : $battr->toArray());
    }

    /** @return Collection<CreativeAttribute>|null */
    public function getBattr(): ?Collection
    {
        return new Collection($this->get('battr') ?? [], CreativeAttribute::class);
    }
}
