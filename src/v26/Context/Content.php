<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=34
 */
class Content implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'producer' => Producer::class,
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setEpisode(int $episode): static
    {
        return $this->set('episode', $episode);
    }

    public function getEpisode(): ?int
    {
        return $this->get('episode');
    }

    public function setTitle(string $title): static
    {
        return $this->set('title', $title);
    }

    public function getTitle(): ?string
    {
        return $this->get('title');
    }

    public function setSeries(string $series): static
    {
        return $this->set('series', $series);
    }

    public function getSeries(): ?string
    {
        return $this->get('series');
    }

    public function setSeason(string $season): static
    {
        return $this->set('season', $season);
    }

    public function getSeason(): ?string
    {
        return $this->get('season');
    }

    public function setProducer(Producer $producer): static
    {
        return $this->set('producer', $producer);
    }

    public function getProducer(): ?Producer
    {
        return $this->get('producer');
    }

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }

    public function getUrl(): ?string
    {
        return $this->get('url');
    }

    public function setContentrating(string $contentrating): static
    {
        return $this->set('contentrating', $contentrating);
    }

    public function getContentrating(): ?string
    {
        return $this->get('contentrating');
    }

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        return $this->get('keywords');
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
