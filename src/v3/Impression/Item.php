<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Impression\DeliveryMethod;

class Item extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'dlvy' => DeliveryMethod::class,
        'metric' => [Metric::class],
        'deal' => [Deal::class],
        'spec' => Spec::class,
    ];

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setQty(int $qty): static
    {
        return $this->set('qty', $qty);
    }

    public function getQty(): ?int
    {
        return $this->get('qty');
    }

    public function setSeq(int $seq): static
    {
        return $this->set('seq', $seq);
    }

    public function getSeq(): ?int
    {
        return $this->get('seq');
    }

    public function setFlr(float $flr): static
    {
        return $this->set('flr', $flr);
    }

    public function getFlr(): ?float
    {
        return $this->get('flr');
    }

    public function setFlrcur(string $flrcur): static
    {
        return $this->set('flrcur', $flrcur);
    }

    public function getFlrcur(): ?string
    {
        return $this->get('flrcur');
    }

    public function setExp(int $exp): static
    {
        return $this->set('exp', $exp);
    }

    public function getExp(): ?int
    {
        return $this->get('exp');
    }

    public function setDt(int $dt): static
    {
        return $this->set('dt', $dt);
    }

    public function getDt(): ?int
    {
        return $this->get('dt');
    }

    public function setDlvy(DeliveryMethod $dlvy): static
    {
        return $this->set('dlvy', $dlvy);
    }

    public function getDlvy(): ?DeliveryMethod
    {
        return $this->get('dlvy');
    }

    /** @param list<Metric> $metric */
    public function setMetric(array $metric): static
    {
        return $this->set('metric', $metric);
    }

    /** @return list<Metric>|null */
    public function getMetric(): ?array
    {
        return $this->get('metric');
    }

    /** @param list<Deal> $deal */
    public function setDeal(array $deal): static
    {
        return $this->set('deal', $deal);
    }

    /** @return list<Deal>|null */
    public function getDeal(): ?array
    {
        return $this->get('deal');
    }

    public function setPrivate(int $private): static
    {
        return $this->set('private', $private);
    }

    public function getPrivate(): ?int
    {
        return $this->get('private');
    }

    public function setSpec(Spec $spec): static
    {
        return $this->set('spec', $spec);
    }

    public function getSpec(): ?Spec
    {
        return $this->get('spec');
    }
}
