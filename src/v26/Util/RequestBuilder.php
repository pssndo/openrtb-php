<?php

declare(strict_types=1);

namespace OpenRTB\v26\Util;

use OpenRTB\Common\AbstractRequestBuilder;
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Ext;
use OpenRTB\v26\Context\Source;

class RequestBuilder extends AbstractRequestBuilder
{
    public function __construct()
    {
        $this->request = new BidRequest();
        $this->request->setId(uniqid('req_', true));
    }

    public function addImp(Imp $imp): self
    {
        $imps = $this->request->getImp() ?? [];
        $imps[] = $imp;
        $this->request->setImp($imps);
        return $this;
    }

    public function setSite(Site $site): self
    {
        $this->request->setSite($site);
        $this->request->setApp(null);
        return $this;
    }

    public function setApp(App $app): self
    {
        $this->request->setApp($app);
        $this->request->setSite(null);
        return $this;
    }

    public function setDevice(Device $device): self
    {
        $this->request->setDevice($device);
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->request->setUser($user);
        return $this;
    }

    public function setAt(AuctionType $at): self
    {
        $this->request->setAt($at);
        return $this;
    }

    public function setTmax(int $tmax): self
    {
        $this->request->setTmax($tmax);
        return $this;
    }

    /** @param list<string> $cur */
    public function setCur(array $cur): self
    {
        $this->request->setCur($cur);
        return $this;
    }

    /** @param list<string> $wseat */
    public function setWseat(array $wseat): self
    {
        $this->request->setWseat($wseat);
        return $this;
    }

    /** @param list<string> $bseat */
    public function setBseat(array $bseat): self
    {
        $this->request->setBseat($bseat);
        return $this;
    }

    public function setAllimps(int $allimps): self
    {
        $this->request->setAllimps($allimps);
        return $this;
    }

    /** @param list<string> $wlang */
    public function setWlang(array $wlang): self
    {
        $this->request->setWlang($wlang);
        return $this;
    }

    /** @param list<string> $wlangb */
    public function setWlangb(array $wlangb): self
    {
        $this->request->setWlangb($wlangb);
        return $this;
    }

    /** @param list<string> $bcat */
    public function setBcat(array $bcat): self
    {
        $this->request->setBcat($bcat);
        return $this;
    }

    /** @param list<string> $badv */
    public function setBadv(array $badv): self
    {
        $this->request->setBadv($badv);
        return $this;
    }

    /** @param list<string> $bapp */
    public function setBapp(array $bapp): self
    {
        $this->request->setBapp($bapp);
        return $this;
    }

    public function setExt(Ext $ext): self
    {
        $this->request->setExt($ext);
        return $this;
    }

    public function setRegs(Regs $regs): self
    {
        $this->request->setRegs($regs);
        return $this;
    }

    public function setSource(Source $source): self
    {
        $this->request->setSource($source);
        return $this;
    }
}
