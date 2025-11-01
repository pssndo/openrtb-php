<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Context implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'site' => Site::class,
        'app' => App::class,
        'device' => Device::class,
        'user' => User::class,
        'regs' => Regs::class,
        'restrictions' => Restrictions::class,
        'dooh' => Dooh::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setSite(Site $site): self
    {
        return $this->set('site', $site);
    }

    public function getSite(): ?Site
    {
        return $this->get('site');
    }

    public function setApp(App $app): self
    {
        return $this->set('app', $app);
    }

    public function getApp(): ?App
    {
        return $this->get('app');
    }

    public function setDevice(Device $device): self
    {
        return $this->set('device', $device);
    }

    public function getDevice(): ?Device
    {
        return $this->get('device');
    }

    public function setUser(User $user): self
    {
        return $this->set('user', $user);
    }

    public function getUser(): ?User
    {
        return $this->get('user');
    }

    public function setRegs(Regs $regs): self
    {
        return $this->set('regs', $regs);
    }

    public function getRegs(): ?Regs
    {
        return $this->get('regs');
    }

    public function setRestrictions(Restrictions $restrictions): self
    {
        return $this->set('restrictions', $restrictions);
    }

    public function getRestrictions(): ?Restrictions
    {
        return $this->get('restrictions');
    }

    public function setDooh(Dooh $dooh): self
    {
        return $this->set('dooh', $dooh);
    }

    public function getDooh(): ?Dooh
    {
        return $this->get('dooh');
    }
}
