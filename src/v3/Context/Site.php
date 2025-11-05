<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Site as CommonSite;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;

class Site extends CommonSite
{
    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    /**
     * @return array<string, string|class-string|array<string>|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'cattax' => ContentTaxonomy::class,
            'cat' => ['string'],
            'sectioncat' => ['string'],
            'pagecat' => ['string'],
            'privacypolicy' => 'int',
            'keywords' => 'string',
            'kwarray' => ['string'],
            'search' => 'string',
            'mobile' => 'int',
            'amp' => 'int',
        ];
    }

    /** @param list<string>|Collection<string> $cat */
    public function setCat(array|Collection $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|Collection<string>|null */
    public function getCat(): array|Collection|null
    {
        return $this->get('cat');
    }

    /** @param list<string>|Collection<string> $sectioncat */
    public function setSectioncat(array|Collection $sectioncat): static
    {
        return $this->set('sectioncat', $sectioncat);
    }

    /** @return list<string>|Collection<string>|null */
    public function getSectioncat(): array|Collection|null
    {
        return $this->get('sectioncat');
    }

    /** @param list<string>|Collection<string> $pagecat */
    public function setPagecat(array|Collection $pagecat): static
    {
        return $this->set('pagecat', $pagecat);
    }

    /** @return list<string>|Collection<string>|null */
    public function getPagecat(): array|Collection|null
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

    public function setPrivacypolicy(int $privacypolicy): static
    {
        return $this->set('privacypolicy', $privacypolicy);
    }

    public function getPrivacypolicy(): ?int
    {
        return $this->get('privacypolicy');
    }

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        return $this->get('keywords');
    }

    /** @param list<string>|Collection<string> $kwarray */
    public function setKwarray(array|Collection $kwarray): static
    {
        return $this->set('kwarray', $kwarray);
    }

    /** @return list<string>|Collection<string>|null */
    public function getKwarray(): array|Collection|null
    {
        return $this->get('kwarray');
    }

    public function setSearch(string $search): static
    {
        return $this->set('search', $search);
    }

    public function getSearch(): ?string
    {
        return $this->get('search');
    }

    public function setMobile(int $mobile): static
    {
        return $this->set('mobile', $mobile);
    }

    public function getMobile(): ?int
    {
        return $this->get('mobile');
    }

    public function setAmp(int $amp): static
    {
        return $this->set('amp', $amp);
    }

    public function getAmp(): ?int
    {
        return $this->get('amp');
    }
}
