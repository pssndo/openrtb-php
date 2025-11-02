<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Resources\User as CommonUser;

class User extends CommonUser
{
    /**
     * @return array<string, string|array<string>|array<array<string, mixed>>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'kwarray' => 'array',
            'consent' => 'string',
            'data' => 'array',
            'eids' => 'array',
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonUser::getBaseSchema(), static::getBaseSchema());
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

    public function setConsent(string $consent): static
    {
        return $this->set('consent', $consent);
    }

    public function getConsent(): ?string
    {
        return $this->get('consent');
    }

    /** @param list<array<string, mixed>> $data */
    public function setData(array $data): static
    {
        return $this->set('data', $data);
    }

    /** @return list<array<string, mixed>>|null */
    public function getData(): ?array
    {
        return $this->get('data');
    }

    /** @param list<array<string, mixed>> $eids */
    public function setEids(array $eids): static
    {
        return $this->set('eids', $eids);
    }

    /** @return list<array<string, mixed>>|null */
    public function getEids(): ?array
    {
        return $this->get('eids');
    }
}
