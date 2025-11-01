<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Context;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Context\Geo;

/**
 * @covers \OpenRTB\v3\Context\User
 */
final class UserTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = User::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('buyeruid', $schema);
        $this->assertEquals('string', $schema['buyeruid']);
        $this->assertArrayHasKey('yob', $schema);
        $this->assertEquals('int', $schema['yob']);
        $this->assertArrayHasKey('gender', $schema);
        $this->assertEquals('string', $schema['gender']);
        $this->assertArrayHasKey('keywords', $schema);
        $this->assertEquals('string', $schema['keywords']);
        $this->assertArrayHasKey('kwarray', $schema);
        $this->assertEquals('array', $schema['kwarray']);
        $this->assertArrayHasKey('consent', $schema);
        $this->assertEquals('string', $schema['consent']);
        $this->assertArrayHasKey('geo', $schema);
        $this->assertEquals(Geo::class, $schema['geo']);
        $this->assertArrayHasKey('data', $schema);
        $this->assertEquals('array', $schema['data']);
        $this->assertArrayHasKey('eids', $schema);
        $this->assertEquals('array', $schema['eids']);
    }

    public function testSetId(): void
    {
        $user = new User();
        $id = 'user123';
        $user->setId($id);
        $this->assertEquals($id, $user->getId());
    }

    public function testSetBuyeruid(): void
    {
        $user = new User();
        $buyeruid = 'buyer456';
        $user->setBuyeruid($buyeruid);
        $this->assertEquals($buyeruid, $user->getBuyeruid());
    }

    public function testSetYob(): void
    {
        $user = new User();
        $yob = 1990;
        $user->setYob($yob);
        $this->assertEquals($yob, $user->getYob());
    }

    public function testSetGender(): void
    {
        $user = new User();
        $gender = 'M';
        $user->setGender($gender);
        $this->assertEquals($gender, $user->getGender());
    }

    public function testSetKeywords(): void
    {
        $user = new User();
        $keywords = 'sports,music';
        $user->setKeywords($keywords);
        $this->assertEquals($keywords, $user->getKeywords());
    }

    public function testSetKwarray(): void
    {
        $user = new User();
        $kwarray = ['sports', 'music'];
        $user->setKwarray($kwarray);
        $this->assertEquals($kwarray, $user->getKwarray());
    }

    public function testSetConsent(): void
    {
        $user = new User();
        $consent = '1';
        $user->setConsent($consent);
        $this->assertEquals($consent, $user->getConsent());
    }

    public function testSetGeo(): void
    {
        $user = new User();
        $geo = new Geo();
        $user->setGeo($geo);
        $this->assertSame($geo, $user->getGeo());
    }

    public function testSetData(): void
    {
        $user = new User();
        $data = [['id' => 'data1']];
        $user->setData($data);
        $this->assertEquals($data, $user->getData());
    }

    public function testSetEids(): void
    {
        $user = new User();
        $eids = [['source' => 'example.com']];
        $user->setEids($eids);
        $this->assertEquals($eids, $user->getEids());
    }
}
