<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Source implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|int|class-string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'tid' => 'string',
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
    }

    public function setTid(string $tid): static
    {
        return $this->set('tid', $tid);
    }

    public function getTid(): ?string
    {
        return $this->get('tid');
    }
}
