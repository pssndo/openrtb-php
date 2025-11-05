<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Content;
use OpenRTB\Common\Resources\Publisher;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;

class Dooh implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|array<string>|class-string>
     */
    protected static array $schema = [
        'id' => 'string',
        'name' => 'string',
        'venuetype' => ['string'],
        'domain' => 'string',
        'cat' => ['string'],
        'cattax' => ContentTaxonomy::class,
        'publisher' => Publisher::class,
        'content' => Content::class,
        'keywords' => 'string',
        'kwarray' => ['string'],
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

    public function setName(string $name): static
    {
        return $this->set('name', $name);
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }

    /** @param Collection<string>|array<string> $venuetype */
    public function setVenuetype(Collection|array $venuetype): static
    {
        return $this->set('venuetype', $venuetype);
    }

    /** @return list<string>|null */
    public function getVenuetype(): ?array
    {
        return $this->get('venuetype');
    }

    public function setDomain(string $domain): static
    {
        return $this->set('domain', $domain);
    }

    public function getDomain(): ?string
    {
        return $this->get('domain');
    }

    /** @param Collection<string>|array<string> $cat */
    public function setCat(Collection|array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    public function setCattax(ContentTaxonomy $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?ContentTaxonomy
    {
        return $this->get('cattax');
    }

    public function setPublisher(Publisher $publisher): static
    {
        return $this->set('publisher', $publisher);
    }

    public function getPublisher(): ?Publisher
    {
        return $this->get('publisher');
    }

    public function setContent(Content $content): static
    {
        return $this->set('content', $content);
    }

    public function getContent(): ?Content
    {
        return $this->get('content');
    }

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        return $this->get('keywords');
    }

    /** @param array<string> $kwarray */
    public function setKwarray(array $kwarray): static
    {
        return $this->set('kwarray', $kwarray);
    }

    /** @return list<string>|null */
    public function getKwarray(): ?array
    {
        return $this->get('kwarray');
    }
}
