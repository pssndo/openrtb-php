<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class App implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|class-string|array<string>|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'bundle' => 'string',
            'domain' => 'string',
            'storeurl' => 'string',
            'publisher' => Publisher::class,
            'content' => Content::class,
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
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
