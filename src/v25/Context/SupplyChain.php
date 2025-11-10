<?php

declare(strict_types=1);

namespace OpenRTB\v25\Context;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v25\Context\SupplyChain\Node as SupplyChainNode;

class SupplyChain implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|class-string|array<class-string>>
     */
    protected static array $schema = [
        'complete' => 'int',
        'ver' => 'string',
        'nodes' => [SupplyChainNode::class],
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setComplete(int $complete): static
    {
        return $this->set('complete', $complete);
    }

    public function getComplete(): ?int
    {
        return $this->get('complete');
    }

    public function setVer(string $ver): static
    {
        return $this->set('ver', $ver);
    }

    public function getVer(): ?string
    {
        return $this->get('ver');
    }

    /** @param Collection<SupplyChainNode>|array<SupplyChainNode> $nodes */
    public function setNodes(Collection|array $nodes): static
    {
        return $this->set('nodes', $nodes);
    }

    /** @return list<SupplyChainNode>|null */
    public function getNodes(): ?array
    {
        return $this->get('nodes');
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
