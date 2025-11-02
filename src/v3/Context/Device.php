<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Resources\Device as CommonDevice;
use OpenRTB\v3\Enums\Context\ConnectionType;
use OpenRTB\v3\Enums\Context\DeviceType;

class Device extends CommonDevice
{
    /**
     * @return array<string, class-string|string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'type' => DeviceType::class,
            'conntype' => ConnectionType::class,
            'ifa' => 'string',
            'dnt' => 'int',
            'lmt' => 'int',
            'ppi' => 'int',
            'pxratio' => 'float',
            'geofetch' => 'int',
            'lang' => 'string',
            'ipv6' => 'string',
            'xff' => 'string',
            'mccmnc' => 'string',
            'sua' => Sua::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    public function setType(DeviceType $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?DeviceType
    {
        return $this->get('type');
    }

    public function setIfa(string $ifa): static
    {
        return $this->set('ifa', $ifa);
    }

    public function getIfa(): ?string
    {
        return $this->get('ifa');
    }

    public function setDnt(int $dnt): static
    {
        return $this->set('dnt', $dnt);
    }

    public function getDnt(): ?int
    {
        return $this->get('dnt');
    }

    public function setLmt(int $lmt): static
    {
        return $this->set('lmt', $lmt);
    }

    public function getLmt(): ?int
    {
        return $this->get('lmt');
    }

    public function setPpi(int $ppi): static
    {
        return $this->set('ppi', $ppi);
    }

    public function getPpi(): ?int
    {
        return $this->get('ppi');
    }

    public function setPxratio(float $pxratio): static
    {
        return $this->set('pxratio', $pxratio);
    }

    public function getPxratio(): ?float
    {
        return $this->get('pxratio');
    }

    public function setGeofetch(int $geofetch): static
    {
        return $this->set('geofetch', $geofetch);
    }

    public function getGeofetch(): ?int
    {
        return $this->get('geofetch');
    }

    public function setLang(string $lang): static
    {
        return $this->set('lang', $lang);
    }

    public function getLang(): ?string
    {
        return $this->get('lang');
    }

    public function setIpv6(string $ipv6): static
    {
        return $this->set('ipv6', $ipv6);
    }

    public function getIpv6(): ?string
    {
        return $this->get('ipv6');
    }

    public function setXff(string $xff): static
    {
        return $this->set('xff', $xff);
    }

    public function getXff(): ?string
    {
        return $this->get('xff');
    }

    public function setConntype(ConnectionType $conntype): static
    {
        return $this->set('conntype', $conntype);
    }

    public function getConntype(): ?ConnectionType
    {
        return $this->get('conntype');
    }

    public function setMccmnc(string $mccmnc): static
    {
        return $this->set('mccmnc', $mccmnc);
    }

    public function getMccmnc(): ?string
    {
        return $this->get('mccmnc');
    }

    public function setSua(Sua $sua): static
    {
        return $this->set('sua', $sua);
    }

    public function getSua(): ?Sua
    {
        return $this->get('sua');
    }
}
