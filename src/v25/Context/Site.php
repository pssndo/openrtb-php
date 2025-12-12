<?php

declare(strict_types=1);

namespace OpenRTB\v25\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Site as CommonSite;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=31
 */
class Site extends CommonSite
{
    /**
     * @return array<string, string|class-string|array<string>|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'cat' => ['string'],
            'sectioncat' => ['string'],
            'pagecat' => ['string'],
            'privacypolicy' => 'int',
            'keywords' => 'string',
            'search' => 'string',
            'mobile' => 'int',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonSite::getBaseSchema(), static::getBaseSchema());
    }

    /** @param array<string> $cat */
    public function setCat(array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    /** @param array<string> $sectioncat */
    public function setSectioncat(array $sectioncat): static
    {
        return $this->set('sectioncat', $sectioncat);
    }

    /** @return list<string>|null */
    public function getSectioncat(): ?array
    {
        return $this->get('sectioncat');
    }

    /** @param array<string> $pagecat */
    public function setPagecat(array $pagecat): static
    {
        return $this->set('pagecat', $pagecat);
    }

    /** @return list<string>|null */
    public function getPagecat(): ?array
    {
        return $this->get('pagecat');
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

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
