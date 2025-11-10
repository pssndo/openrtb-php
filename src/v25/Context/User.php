<?php

declare(strict_types=1);

namespace OpenRTB\v25\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\User as CommonUser;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=39
 */
class User extends CommonUser
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
        return array_merge(CommonUser::getBaseSchema(), static::getBaseSchema());
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
