<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=25
 */
class Video implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|string|array<string>>
     */
    protected static array $schema = [
        'mimes' => ['string'],
        'minduration' => 'int',
        'maxduration' => 'int',
        'protocols' => ['int'],
        'w' => 'int',
        'h' => 'int',
        'linearity' => 'int',
        'placement' => 'int',
        'api' => ['int'],
        'startdelay' => 'int',
        'skip' => 'int',
        'skipmin' => 'int',
        'skipafter' => 'int',
        'pos' => 'int',
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param Collection<string>|array<string> $mimes */
    public function setMimes(Collection|array $mimes): static
    {
        return $this->set('mimes', $mimes);
    }

    /** @return list<string>|null */
    public function getMimes(): ?array
    {
        return $this->get('mimes');
    }

    public function setMinduration(int $minduration): static
    {
        return $this->set('minduration', $minduration);
    }

    public function getMinduration(): ?int
    {
        return $this->get('minduration');
    }

    public function setMaxduration(int $maxduration): static
    {
        return $this->set('maxduration', $maxduration);
    }

    public function getMaxduration(): ?int
    {
        return $this->get('maxduration');
    }

    /** @param Collection<int>|array<int> $protocols */
    public function setProtocols(Collection|array $protocols): static
    {
        return $this->set('protocols', $protocols);
    }

    /** @return list<int>|null */
    public function getProtocols(): ?array
    {
        return $this->get('protocols');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setLinearity(int $linearity): static
    {
        return $this->set('linearity', $linearity);
    }

    public function getLinearity(): ?int
    {
        return $this->get('linearity');
    }

    public function setPlacement(int $placement): static
    {
        return $this->set('placement', $placement);
    }

    public function getPlacement(): ?int
    {
        return $this->get('placement');
    }

    /** @param Collection<int>|array<int> $api */
    public function setApi(Collection|array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<int>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    public function setStartdelay(int $startdelay): static
    {
        return $this->set('startdelay', $startdelay);
    }

    public function getStartdelay(): ?int
    {
        return $this->get('startdelay');
    }

    public function setSkip(int $skip): static
    {
        return $this->set('skip', $skip);
    }

    public function getSkip(): ?int
    {
        return $this->get('skip');
    }

    public function setSkipmin(int $skipmin): static
    {
        return $this->set('skipmin', $skipmin);
    }

    public function getSkipmin(): ?int
    {
        return $this->get('skipmin');
    }

    public function setSkipafter(int $skipafter): static
    {
        return $this->set('skipafter', $skipafter);
    }

    public function getSkipafter(): ?int
    {
        return $this->get('skipafter');
    }

    public function setPos(int $pos): static
    {
        return $this->set('pos', $pos);
    }

    public function getPos(): ?int
    {
        return $this->get('pos');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
