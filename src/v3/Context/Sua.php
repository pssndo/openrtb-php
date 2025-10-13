<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\v3\BaseObject;

class Sua extends BaseObject
{
    /** @param list<array<string, string>> $browsers */
    public function setBrowsers(array $browsers): static
    {
        return $this->set('browsers', $browsers);
    }

    /** @return list<array<string, string>>|null */
    public function getBrowsers(): ?array
    {
        return $this->get('browsers');
    }

    /** @param list<array<string, string>> $platform */
    public function setPlatform(array $platform): static
    {
        return $this->set('platform', $platform);
    }

    /** @return list<array<string, string>>|null */
    public function getPlatform(): ?array
    {
        return $this->get('platform');
    }

    public function setSource(int $source): static
    {
        return $this->set('source', $source);
    }

    public function getSource(): ?int
    {
        return $this->get('source');
    }

    public function setModel(string $model): static
    {
        return $this->set('model', $model);
    }

    public function getModel(): ?string
    {
        return $this->get('model');
    }

    public function setMobile(int $mobile): static
    {
        return $this->set('mobile', $mobile);
    }

    public function getMobile(): ?int
    {
        return $this->get('mobile');
    }
}
