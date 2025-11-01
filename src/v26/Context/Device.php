<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=36
 */
class Device implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'geo' => Geo::class,
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setUa(string $ua): static
    {
        return $this->set('ua', $ua);
    }

    public function getUa(): ?string
    {
        return $this->get('ua');
    }

    public function setGeo(Geo $geo): static
    {
        return $this->set('geo', $geo);
    }

    public function getGeo(): ?Geo
    {
        return $this->get('geo');
    }

    public function setIp(string $ip): static
    {
        return $this->set('ip', $ip);
    }

    public function getIp(): ?string
    {
        return $this->get('ip');
    }

    public function setDeviceType(int $devicetype): static
    {
        return $this->set('devicetype', $devicetype);
    }

    public function getDeviceType(): ?int
    {
        return $this->get('devicetype');
    }

    public function setMake(string $make): static
    {
        return $this->set('make', $make);
    }

    public function getMake(): ?string
    {
        return $this->get('make');
    }

    public function setModel(string $model): static
    {
        return $this->set('model', $model);
    }

    public function getModel(): ?string
    {
        return $this->get('model');
    }

    public function setOs(string $os): static
    {
        return $this->set('os', $os);
    }

    public function getOs(): ?string
    {
        return $this->get('os');
    }

    public function setOsv(string $osv): static
    {
        return $this->set('osv', $osv);
    }

    public function getOsv(): ?string
    {
        return $this->get('osv');
    }

    public function setHwv(string $hwv): static
    {
        return $this->set('hwv', $hwv);
    }

    public function getHwv(): ?string
    {
        return $this->get('hwv');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setJs(int $js): static
    {
        return $this->set('js', $js);
    }

    public function getJs(): ?int
    {
        return $this->get('js');
    }

    public function setLanguage(string $language): static
    {
        return $this->set('language', $language);
    }

    public function getLanguage(): ?string
    {
        return $this->get('language');
    }

    public function setConnectionType(int $connectiontype): static
    {
        return $this->set('connectiontype', $connectiontype);
    }

    public function getConnectionType(): ?int
    {
        return $this->get('connectiontype');
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
