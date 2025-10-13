<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;

class App extends BaseObject
{
    /** @var array<string, class-string> */
    protected static array $schema = [
        'cattax' => ContentTaxonomy::class,
        'publisher' => Publisher::class,
        'content' => Content::class,
    ];

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

    public function setBundle(string $bundle): static
    {
        return $this->set('bundle', $bundle);
    }

    public function getBundle(): ?string
    {
        return $this->get('bundle');
    }

    public function setDomain(string $domain): static
    {
        return $this->set('domain', $domain);
    }

    public function getDomain(): ?string
    {
        return $this->get('domain');
    }

    public function setStoreurl(string $storeurl): static
    {
        return $this->set('storeurl', $storeurl);
    }

    public function getStoreurl(): ?string
    {
        return $this->get('storeurl');
    }

    public function setStoreid(string $storeid): static
    {
        return $this->set('storeid', $storeid);
    }

    public function getStoreid(): ?string
    {
        return $this->get('storeid');
    }

    /** @param list<string> $cat */
    public function setCat(array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    /** @param list<string> $sectioncat */
    public function setSectioncat(array $sectioncat): static
    {
        return $this->set('sectioncat', $sectioncat);
    }

    /** @return list<string>|null */
    public function getSectioncat(): ?array
    {
        return $this->get('sectioncat');
    }

    /** @param list<string> $pagecat */
    public function setPagecat(array $pagecat): static
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

    /** @param list<string> $kwarray */
    public function setKwarray(array $kwarray): static
    {
        return $this->set('kwarray', $kwarray);
    }

    /** @return list<string>|null */
    public function getKwarray(): ?array
    {
        return $this->get('kwarray');
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
}
