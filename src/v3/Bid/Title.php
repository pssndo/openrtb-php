<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Title implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string>
     */
    protected static array $schema = [
        'text' => 'string',
    ];

    /**
     * @return array<string, string>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setText(string $text): static
    {
        return $this->set('text', $text);
    }

    public function getText(): ?string
    {
        return $this->get('text');
    }
}
