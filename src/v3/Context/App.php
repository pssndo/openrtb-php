<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Resources\App as CommonApp;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;
use OpenRTB\Common\Collection;

class App extends CommonApp
{
    /** @var array<string, class-string|string|array<string>> */
    protected static array $schema = [
        'storeid' => 'string',
        'cat' => 'array<string>',
        'sectioncat' => 'array<string>',
        'pagecat' => 'array<string>',
        'cattax' => ContentTaxonomy::class,
        'ver' => 'string',
        'privacypolicy' => 'int',
        'paid' => 'int',
        'keywords' => 'string',
        'kwarray' => 'array<string>',
    ];

    /**
     * @return array<string, class-string|string|array<string>>
     */
    protected static function getBaseSchema(): array
    {
        return self::$schema;
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), self::getBaseSchema());
    }

    public function setStoreid(string $storeid): static
    {
        return $this->set('storeid', $storeid);
    }

    public function getStoreid(): ?string
    {
        return $this->get('storeid');
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

    /** @param Collection<string>|array<string> $sectioncat */
    public function setSectioncat(Collection|array $sectioncat): static
    {
        return $this->set('sectioncat', $sectioncat);
    }

    /** @return list<string>|null */
    public function getSectioncat(): ?array
    {
        return $this->get('sectioncat');
    }

    /** @param Collection<string>|array<string> $pagecat */
    public function setPagecat(Collection|array $pagecat): static
    {
        return $this->set('pagecat', $pagecat);
    }

    /** @return list<string>|null */
    public function getPagecat(): ?array
    {
        return $this->get('pagecat');
    }

    public function setCattax(ContentTaxonomy $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?ContentTaxonomy
    {
        return $this->get('cattax');
    }

    public function setVer(string $ver): static
    {
        return $this->set('ver', $ver);
    }

    public function getVer(): ?string
    {
        return $this->get('ver');
    }

    public function setPrivacypolicy(int $privacypolicy): static
    {
        return $this->set('privacypolicy', $privacypolicy);
    }

    public function getPrivacypolicy(): ?int
    {
        return $this->get('privacypolicy');
    }

    public function setPaid(int $paid): static
    {
        return $this->set('paid', $paid);
    }

    public function getPaid(): ?int
    {
        return $this->get('paid');
    }

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        return $this->get('keywords');
    }

    /** @param Collection<string>|array<string> $kwarray */
    public function setKwarray(Collection|array $kwarray): static
    {
        return $this->set('kwarray', $kwarray);
    }

    /** @return list<string>|null */
    public function getKwarray(): ?array
    {
        return $this->get('kwarray');
    }
}
