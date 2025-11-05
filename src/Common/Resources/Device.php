<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Device implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|class-string>
     */
    protected static array $schema = [
        'ua' => 'string',
        'geo' => Geo::class,
        'ip' => 'string',
        'make' => 'string',
        'model' => 'string',
        'os' => 'string',
        'osv' => 'string',
        'hwv' => 'string',
        'w' => 'int',
        'h' => 'int',
        'js' => 'int',
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
}
