<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Context\ConnectionType;
use OpenRTB\v3\Enums\Context\DeviceType;

class Device implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'type' => DeviceType::class,
        'conntype' => ConnectionType::class,
        'geo' => Geo::class,
        'sua' => Sua::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(DeviceType $type): self
    {
        return $this->set('type', $type);
    }

    public function getType(): ?DeviceType
    {
        return $this->get('type');
    }

    public function setUa(string $ua): self
    {
        return $this->set('ua', $ua);
    }

    public function getUa(): ?string
    {
        return $this->get('ua');
    }

    public function setIfa(string $ifa): self
    {
        return $this->set('ifa', $ifa);
    }

    public function getIfa(): ?string
    {
        return $this->get('ifa');
    }

    public function setDnt(int $dnt): self
    {
        return $this->set('dnt', $dnt);
    }

    public function getDnt(): ?int
    {
        return $this->get('dnt');
    }

    public function setLmt(int $lmt): self
    {
        return $this->set('lmt', $lmt);
    }

    public function getLmt(): ?int
    {
        return $this->get('lmt');
    }

    public function setMake(string $make): self
    {
        return $this->set('make', $make);
    }

    public function getMake(): ?string
    {
        return $this->get('make');
    }

    public function setModel(string $model): self
    {
        return $this->set('model', $model);
    }

    public function getModel(): ?string
    {
        return $this->get('model');
    }

    public function setOs(string $os): self
    {
        return $this->set('os', $os);
    }

    public function getOs(): ?string
    {
        return $this->get('os');
    }

    public function setOsv(string $osv): self
    {
        return $this->set('osv', $osv);
    }

    public function getOsv(): ?string
    {
        return $this->get('osv');
    }

    public function setHwv(string $hwv): self
    {
        return $this->set('hwv', $hwv);
    }

    public function getHwv(): ?string
    {
        return $this->get('hwv');
    }

    public function setH(int $h): self
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setW(int $w): self
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setPpi(int $ppi): self
    {
        return $this->set('ppi', $ppi);
    }

    public function getPpi(): ?int
    {
        return $this->get('ppi');
    }

    public function setPxratio(float $pxratio): self
    {
        return $this->set('pxratio', $pxratio);
    }

    public function getPxratio(): ?float
    {
        return $this->get('pxratio');
    }

    public function setJs(int $js): self
    {
        return $this->set('js', $js);
    }

    public function getJs(): ?int
    {
        return $this->get('js');
    }

    public function setGeofetch(int $geofetch): self
    {
        return $this->set('geofetch', $geofetch);
    }

    public function getGeofetch(): ?int
    {
        return $this->get('geofetch');
    }

    public function setLang(string $lang): self
    {
        return $this->set('lang', $lang);
    }

    public function getLang(): ?string
    {
        return $this->get('lang');
    }

    public function setIp(string $ip): self
    {
        return $this->set('ip', $ip);
    }

    public function getIp(): ?string
    {
        return $this->get('ip');
    }

    public function setIpv6(string $ipv6): self
    {
        return $this->set('ipv6', $ipv6);
    }

    public function getIpv6(): ?string
    {
        return $this->get('ipv6');
    }

    public function setXff(string $xff): self
    {
        return $this->set('xff', $xff);
    }

    public function getXff(): ?string
    {
        return $this->get('xff');
    }

    public function setConntype(ConnectionType $conntype): self
    {
        return $this->set('conntype', $conntype);
    }

    public function getConntype(): ?ConnectionType
    {
        return $this->get('conntype');
    }

    public function setMccmnc(string $mccmnc): self
    {
        return $this->set('mccmnc', $mccmnc);
    }

    public function getMccmnc(): ?string
    {
        return $this->get('mccmnc');
    }

    public function setGeo(Geo $geo): self
    {
        return $this->set('geo', $geo);
    }

    public function getGeo(): ?Geo
    {
        return $this->get('geo');
    }

    public function setSua(Sua $sua): self
    {
        return $this->set('sua', $sua);
    }

    public function getSua(): ?Sua
    {
        return $this->get('sua');
    }
}
