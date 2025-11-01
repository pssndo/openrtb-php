<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Impression\Item;

class Request implements ObjectInterface
{
    use HasData;

    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'at' => AuctionType::class,
        'source' => Context\Source::class,
        'context' => Context\Context::class,
        'item' => [Impression\Item::class],
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

    public function setTest(int $test): static
    {
        return $this->set('test', $test);
    }

    public function getTest(): ?int
    {
        return $this->get('test');
    }

    public function setTmax(int $tmax): static
    {
        return $this->set('tmax', $tmax);
    }

    public function getTmax(): ?int
    {
        return $this->get('tmax');
    }

    public function setAt(AuctionType $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?AuctionType
    {
        return $this->get('at');
    }

    /** @param list<string> $cur */
    public function setCur(array $cur): static
    {
        return $this->set('cur', $cur);
    }

    /** @return list<string>|null */
    public function getCur(): ?array
    {
        return $this->get('cur');
    }

    /** @param list<string> $seat */
    public function setSeat(array $seat): static
    {
        return $this->set('seat', $seat);
    }

    /** @return list<string>|null */
    public function getSeat(): ?array
    {
        return $this->get('seat');
    }

    public function setWseat(int $wseat): static
    {
        return $this->set('wseat', $wseat);
    }

    public function getWseat(): ?int
    {
        return $this->get('wseat');
    }

    public function setCdata(string $cdata): static
    {
        return $this->set('cdata', $cdata);
    }

    public function getCdata(): ?string
    {
        return $this->get('cdata');
    }

    public function setSource(Context\Source $source): static
    {
        return $this->set('source', $source);
    }

    public function getSource(): ?Context\Source
    {
        return $this->get('source');
    }

    public function setContext(Context\Context $context): static
    {
        return $this->set('context', $context);
    }

    public function getContext(): ?Context\Context
    {
        return $this->get('context');
    }

    public function addItem(Item $item): static
    {
        $items = $this->get('item') ?? [];
        $items[] = $item;
        return $this->set('item', $items);
    }

    /** @return list<Impression\Item>|null */
    public function getItem(): ?array
    {
        return $this->get('item');
    }
}
