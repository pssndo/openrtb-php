<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Context\App;
use OpenRTB\v3\Context\Content;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Dooh;
use OpenRTB\v3\Context\Geo;
use OpenRTB\v3\Context\Producer;
use OpenRTB\v3\Context\Publisher;
use OpenRTB\v3\Context\Regs;
use OpenRTB\v3\Context\Restrictions;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Context\Sua;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Enums\Context\ConnectionType;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;
use OpenRTB\v3\Enums\Context\DeviceType;
use OpenRTB\v3\Enums\Context\IpLocationService;
use OpenRTB\v3\Enums\Context\LocationType;
use OpenRTB\v3\Request;
use OpenRTB\v3\Util\Parser;

/**
 * @covers \OpenRTB\v3\Context\App
 * @covers \OpenRTB\v3\Context\Context
 * @covers \OpenRTB\v3\Context\Device
 * @covers \OpenRTB\v3\Context\Dooh
 * @covers \OpenRTB\v3\Context\Geo
 * @covers \OpenRTB\v3\Context\Publisher
 * @covers \OpenRTB\v3\Context\Regs
 * @covers \OpenRTB\v3\Context\Restrictions
 * @covers \OpenRTB\v3\Context\Site
 * @covers \OpenRTB\v3\Context\Source
 * @covers \OpenRTB\v3\Context\User
 * @covers \OpenRTB\v3\Context\Content
 * @covers \OpenRTB\v3\Context\Producer
 * @covers \OpenRTB\v3\Context\Sua
 */
class ContextObjectsTest extends TestCase
{
    public function testGeoObject(): void
    {
        $geo = (new Geo())
            ->setType(LocationType::IP_LOOKUP)->setCountry('USA')->setCity('New York')
            ->setLat(40.7128)->setLon(-74.0060)->setAccuracy(1)->setLastfix(123)
            ->setIpservice(IpLocationService::IP2LOCATION)->setRegion('NY')->setRegionfips104('US36')
            ->setMetro('501')->setZip('10001')->setUtcoffset(300);

        $this->assertEquals(LocationType::IP_LOOKUP, $geo->getType());
        $this->assertEquals('USA', $geo->getCountry());
        $this->assertEquals('New York', $geo->getCity());
        $this->assertEquals(40.7128, $geo->getLat());
        $this->assertEquals(-74.0060, $geo->getLon());
        $this->assertEquals(1, $geo->getAccuracy());
        $this->assertEquals(123, $geo->getLastfix());
        $this->assertEquals(IpLocationService::IP2LOCATION, $geo->getIpservice());
        $this->assertEquals('NY', $geo->getRegion());
        $this->assertEquals('US36', $geo->getRegionfips104());
        $this->assertEquals('501', $geo->getMetro());
        $this->assertEquals('10001', $geo->getZip());
        $this->assertEquals(300, $geo->getUtcoffset());
    }

    public function testSuaObject(): void
    {
        $sua = (new Sua())->setSource(1)->setModel('Pixel 6')->setBrowsers([['brand' => 'Chrome', 'version' => '108']])->setPlatform([['brand' => 'Android', 'version' => '13']])->setMobile(1);
        $this->assertEquals(1, $sua->getSource());
        $this->assertEquals('Pixel 6', $sua->getModel());
        $this->assertEquals([['brand' => 'Chrome', 'version' => '108']], $sua->getBrowsers());
        $this->assertEquals([['brand' => 'Android', 'version' => '13']], $sua->getPlatform());
        $this->assertEquals(1, $sua->getMobile());
    }

    public function testDeviceObject(): void
    {
        $geo = new Geo();
        $sua = new Sua();
        $device = (new Device())
            ->setType(DeviceType::PHONE)->setIp('1.2.3.4')->setLang('en')->setUa('ua-string')
            ->setIfa('ifa-string')->setDnt(1)->setLmt(1)->setMake('Apple')->setModel('iPhone')
            ->setOs('iOS')->setOsv('16.0')->setHwv('14,2')->setH(2532)->setW(1170)->setPpi(460)
            ->setPxratio(3.0)->setJs(1)->setGeofetch(1)->setIpv6('::1')->setXff('2.3.4.5')
            ->setConntype(ConnectionType::WIFI)->setMccmnc('310-410')->setGeo($geo)->setSua($sua);

        $this->assertEquals(DeviceType::PHONE, $device->getType());
        $this->assertEquals('1.2.3.4', $device->getIp());
        $this->assertEquals('en', $device->getLang());
        $this->assertEquals('ua-string', $device->getUa());
        $this->assertEquals('ifa-string', $device->getIfa());
        $this->assertEquals(1, $device->getDnt());
        $this->assertEquals(1, $device->getLmt());
        $this->assertEquals('Apple', $device->getMake());
        $this->assertEquals('iPhone', $device->getModel());
        $this->assertEquals('iOS', $device->getOs());
        $this->assertEquals('16.0', $device->getOsv());
        $this->assertEquals('14,2', $device->getHwv());
        $this->assertEquals(2532, $device->getH());
        $this->assertEquals(1170, $device->getW());
        $this->assertEquals(460, $device->getPpi());
        $this->assertEquals(3.0, $device->getPxratio());
        $this->assertEquals(1, $device->getJs());
        $this->assertEquals(1, $device->getGeofetch());
        $this->assertEquals('::1', $device->getIpv6());
        $this->assertEquals('2.3.4.5', $device->getXff());
        $this->assertEquals(ConnectionType::WIFI, $device->getConntype());
        $this->assertEquals('310-410', $device->getMccmnc());
        $this->assertSame($geo, $device->getGeo());
        $this->assertSame($sua, $device->getSua());
    }

    public function testUserObject(): void
    {
        $geo = new Geo();
        $user = (new User())
            ->setId('user-1')
            ->setYob(1990)
            ->setGender('M')
            ->setGeo($geo)
            ->setBuyeruid('buyer-1')
            ->setKeywords('keywords')
            ->setKwarray(['kw1'])
            ->setConsent('consent')
            ->setData([['id' => '1', 'name' => 'dataname']])->setEids([['source' => 'adserver.org', 'uids' => [['id' => 'some-id']]]]);

        $this->assertEquals('user-1', $user->getId());
        $this->assertEquals(1990, $user->getYob());
        $this->assertEquals('M', $user->getGender());
        $this->assertSame($geo, $user->getGeo());
        $this->assertEquals('buyer-1', $user->getBuyeruid());
        $this->assertEquals('keywords', $user->getKeywords());
        $this->assertEquals(['kw1'], $user->getKwarray());
        $this->assertEquals('consent', $user->getConsent());
        $this->assertEquals([['id' => '1', 'name' => 'dataname']], $user->getData());
        $this->assertEquals([['source' => 'adserver.org', 'uids' => [['id' => 'some-id']]]], $user->getEids());
    }

    public function testProducerObject(): void
    {
        $producer = (new Producer())->setId('prod-1')->setName('Producer A')->setDomain('producer.com')->setCat(['cat']);
        $this->assertEquals('prod-1', $producer->getId());
        $this->assertEquals('Producer A', $producer->getName());
        $this->assertEquals('producer.com', $producer->getDomain());
        $this->assertEquals(['cat'], $producer->getCat());
    }

    public function testContentObject(): void
    {
        $producer = new Producer();
        $content = (new Content())
            ->setId('content-1')->setTitle('Content Title')->setProducer($producer)->setEpisode(1)->setSeries('series')
            ->setSeason('season')->setArtist('artist')->setGenre('genre')->setAlbum('album')->setIsrc('isrc')
            ->setUrl('url')->setCat(['cat'])->setCattax(1)->setProdq(1)->setContext(1)->setContentrating('cr')
            ->setUserrating('ur')->setQagmediarating(1)->setKeywords('keywords')->setLivestream(1)
            ->setSourcerelationship(1)->setLen(1)->setLanguage('en')->setEmbeddable(1)->setData([['name' => 'data']]);
        $this->assertEquals('content-1', $content->getId());
        $this->assertEquals(1, $content->getEpisode());
        $this->assertEquals('Content Title', $content->getTitle());
        $this->assertEquals('series', $content->getSeries());
        $this->assertEquals('season', $content->getSeason());
        $this->assertEquals('artist', $content->getArtist());
        $this->assertEquals('genre', $content->getGenre());
        $this->assertEquals('album', $content->getAlbum());
        $this->assertEquals('isrc', $content->getIsrc());
        $this->assertEquals('url', $content->getUrl());
        $this->assertEquals(['cat'], $content->getCat());
        $this->assertEquals(1, $content->getCattax());
        $this->assertEquals(1, $content->getProdq());
        $this->assertEquals(1, $content->getContext());
        $this->assertEquals('cr', $content->getContentrating());
        $this->assertEquals('ur', $content->getUserrating());
        $this->assertEquals(1, $content->getQagmediarating());
        $this->assertEquals('keywords', $content->getKeywords());
        $this->assertEquals(1, $content->getLivestream());
        $this->assertEquals(1, $content->getSourcerelationship());
        $this->assertEquals(1, $content->getLen());
        $this->assertEquals('en', $content->getLanguage());
        $this->assertEquals(1, $content->getEmbeddable());
        $this->assertEquals([['name' => 'data']], $content->getData());
        $this->assertSame($producer, $content->getProducer());
    }

    public function testPublisherObject(): void
    {
        $publisher = (new Publisher())->setId('pub-1')->setName('Publisher A')->setDomain('publisher.com')->setCat(['cat']);
        $this->assertEquals('pub-1', $publisher->getId());
        $this->assertEquals('Publisher A', $publisher->getName());
        $this->assertEquals('publisher.com', $publisher->getDomain());
        $this->assertEquals(['cat'], $publisher->getCat());
    }

    public function testSiteObject(): void
    {
        $publisher = new Publisher();
        $content = new Content();
        $site = (new Site())
            ->setId('site-1')->setDomain('example.com')->setCattax(ContentTaxonomy::IAB_CONTENT_TAXONOMY_2_2)
            ->setPublisher($publisher)->setContent($content)->setPage('page.html')->setRef('ref.com')
            ->setSearch('search')->setMobile(1)->setAmp(1)->setKeywords('keywords')->setKwarray(['kw1'])
            ->setCat(['cat'])->setSectioncat(['cat'])->setPagecat(['cat'])->setPrivacypolicy(1)->setName('Site Name');
        $this->assertEquals('site-1', $site->getId());
        $this->assertEquals('Site Name', $site->getName());
        $this->assertEquals('example.com', $site->getDomain());
        $this->assertEquals(['cat'], $site->getCat());
        $this->assertEquals(['cat'], $site->getSectioncat());
        $this->assertEquals(['cat'], $site->getPagecat());
        $this->assertEquals(ContentTaxonomy::IAB_CONTENT_TAXONOMY_2_2, $site->getCattax());
        $this->assertEquals(1, $site->getPrivacypolicy());
        $this->assertEquals('keywords', $site->getKeywords());
        $this->assertEquals(['kw1'], $site->getKwarray());
        $this->assertEquals('page.html', $site->getPage());
        $this->assertEquals('ref.com', $site->getRef());
        $this->assertEquals('search', $site->getSearch());
        $this->assertEquals(1, $site->getMobile());
        $this->assertEquals(1, $site->getAmp());
        $this->assertSame($publisher, $site->getPublisher());
        $this->assertSame($content, $site->getContent());
    }

    public function testAppObject(): void
    {
        $content = new Content();
        $publisher = new Publisher();
        $app = (new App())
            ->setId('app-1')->setBundle('com.example.app')->setContent($content)->setName('name')->setDomain('domain')
            ->setStoreurl('url')->setStoreid('id')->setCat(['cat'])->setSectioncat(['cat'])->setPagecat(['cat'])
            ->setCattax(ContentTaxonomy::IAB_CONTENT_TAXONOMY_3_0)->setVer('1.0')->setPrivacypolicy(1)->setPaid(1)
            ->setKeywords('keywords')->setKwarray(['kw1'])->setPublisher($publisher);
        $this->assertEquals('app-1', $app->getId());
        $this->assertEquals('name', $app->getName());
        $this->assertEquals('com.example.app', $app->getBundle());
        $this->assertEquals('domain', $app->getDomain());
        $this->assertEquals('url', $app->getStoreurl());
        $this->assertEquals('id', $app->getStoreid());
        $this->assertEquals(['cat'], $app->getCat());
        $this->assertEquals(['cat'], $app->getSectioncat());
        $this->assertEquals(['cat'], $app->getPagecat());
        $this->assertEquals(ContentTaxonomy::IAB_CONTENT_TAXONOMY_3_0, $app->getCattax());
        $this->assertEquals('1.0', $app->getVer());
        $this->assertEquals(1, $app->getPrivacypolicy());
        $this->assertEquals(1, $app->getPaid());
        $this->assertEquals('keywords', $app->getKeywords());
        $this->assertEquals(['kw1'], $app->getKwarray());
        $this->assertSame($publisher, $app->getPublisher());
        $this->assertSame($content, $app->getContent());
    }

    public function testRegsObject(): void
    {
        $regs = (new Regs())->setGdpr(1)->setGpp('gpp-string')->setCoppa(1)->setGppSid([1,2]);
        $this->assertEquals(1, $regs->getGdpr());
        $this->assertEquals('gpp-string', $regs->getGpp());
        $this->assertEquals(1, $regs->getCoppa());
        $this->assertEquals([1,2], $regs->getGppSid());
    }

    public function testRestrictionsObject(): void
    {
        $restrictions = (new Restrictions())
            ->setBcat(['IAB25'])
            ->setCattax(ContentTaxonomy::IAB_CONTENT_CATEGORY_1_0)
            ->setBadv(['adv.com'])
            ->setBapp(['com.app.banned'])
            ->setBattr([CreativeAttribute::ONE_POOR]);
        $this->assertEquals(['IAB25'], $restrictions->getBcat());
        $this->assertEquals(ContentTaxonomy::IAB_CONTENT_CATEGORY_1_0, $restrictions->getCattax());
        $this->assertEquals(['adv.com'], $restrictions->getBadv());
        $this->assertEquals(['com.app.banned'], $restrictions->getBapp());
        $this->assertEquals([CreativeAttribute::ONE_POOR], $restrictions->getBattr());
    }

    public function testDoohObject(): void
    {
        $dooh = (new Dooh())->setId('dooh-1')->setName('Times Square')->setVenuetype(['venue'])->setDomain('domain')->setCat(['cat'])->setCattax(1);
        $this->assertEquals('dooh-1', $dooh->getId());
        $this->assertEquals('Times Square', $dooh->getName());
        $this->assertEquals(['venue'], $dooh->getVenuetype());
        $this->assertEquals('domain', $dooh->getDomain());
        $this->assertEquals(['cat'], $dooh->getCat());
        $this->assertEquals(1, $dooh->getCattax());
    }

    public function testSourceObject(): void
    {
        $source = (new Source())->setTid('tid-1')->setTs(12345)->setDs('ds')->setDsmap('dsmap');
        $this->assertEquals('tid-1', $source->getTid());
        $this->assertEquals(12345, $source->getTs());
        $this->assertEquals('ds', $source->getDs());
        $this->assertEquals('dsmap', $source->getDsmap());
    }

    public function testContextObject(): void
    {
        $site = new Site();
        $app = new App();
        $device = new Device();
        $user = new User();
        $regs = new Regs();
        $restrictions = new Restrictions();
        $dooh = new Dooh();

        $context = (new Context())
            ->setSite($site)
            ->setApp($app)
            ->setDevice($device)
            ->setUser($user)
            ->setRegs($regs)
            ->setRestrictions($restrictions)
            ->setDooh($dooh);

        $this->assertSame($site, $context->getSite());
        $this->assertSame($app, $context->getApp());
        $this->assertSame($device, $context->getDevice());
        $this->assertSame($user, $context->getUser());
        $this->assertSame($regs, $context->getRegs());
        $this->assertSame($restrictions, $context->getRestrictions());
        $this->assertSame($dooh, $context->getDooh());
    }

    public function testFullSerializationCycle(): void
    {
        $context = new Context();
        $context->setSite(new Site());
        $request = new Request();
        $request->setContext($context);

        $json = $request->toJson();
        $this->assertIsString($json);
        $parsedRequest = Parser::parseRequest($json);

        $this->assertInstanceOf(Request::class, $parsedRequest);
        $this->assertEquals($request->toArray(), $parsedRequest->toArray());
    }
}
