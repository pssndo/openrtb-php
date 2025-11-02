<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Content as CommonContent;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=34
 */
class Content extends CommonContent
{
    /**
     * @return array<string, class-string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonContent::getBaseSchema(), static::getBaseSchema());
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
