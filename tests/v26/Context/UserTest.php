<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use PHPUnit\Framework\TestCase;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Context\Geo;
use OpenRTB\v26\Ext;

/**
 * @covers \OpenRTB\v26\Context\User
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
        $this->assertArrayHasKey('geo', $schema);
        $this->assertEquals(Geo::class, $schema['geo']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetId(): void
    {
        $user = new User();
        $id = 'user123';
        $user->setId($id);
        $this->assertEquals($id, $user->getId());
    }

    public function testGetId(): void
    {
        $user = new User();
        $user->setId('test_id');
        $this->assertEquals('test_id', $user->getId());
    }

    public function testSetBuyeruid(): void
    {
        $user = new User();
        $buyeruid = 'buyer456';
        $user->setBuyeruid($buyeruid);
        $this->assertEquals($buyeruid, $user->getBuyeruid());
    }

    public function testGetBuyeruid(): void
    {
        $user = new User();
        $user->setBuyeruid('test_buyeruid');
        $this->assertEquals('test_buyeruid', $user->getBuyeruid());
    }

    public function testSetYob(): void
    {
        $user = new User();
        $yob = 1990;
        $user->setYob($yob);
        $this->assertEquals($yob, $user->getYob());
    }

    public function testGetYob(): void
    {
        $user = new User();
        $user->setYob(1985);
        $this->assertEquals(1985, $user->getYob());
    }

    public function testSetGender(): void
    {
        $user = new User();
        $gender = 'M';
        $user->setGender($gender);
        $this->assertEquals($gender, $user->getGender());
    }

    public function testGetGender(): void
    {
        $user = new User();
        $user->setGender('F');
        $this->assertEquals('F', $user->getGender());
    }

    public function testSetKeywords(): void
    {
        $user = new User();
        $keywords = 'sports,music';
        $user->setKeywords($keywords);
        $this->assertEquals($keywords, $user->getKeywords());
    }

    public function testGetKeywords(): void
    {
        $user = new User();
        $user->setKeywords('tech,gaming');
        $this->assertEquals('tech,gaming', $user->getKeywords());
    }

    public function testSetGeo(): void
    {
        $user = new User();
        $geo = new Geo();
        $user->setGeo($geo);
        $this->assertSame($geo, $user->getGeo());
    }

    public function testGetGeo(): void
    {
        $user = new User();
        $geo = new Geo();
        $user->setGeo($geo);
        $this->assertSame($geo, $user->getGeo());
    }

    public function testSetExt(): void
    {
        $user = new User();
        $ext = new Ext();
        $user->setExt($ext);
        $this->assertSame($ext, $user->getExt());
    }

    public function testGetExt(): void
    {
        $user = new User();
        $ext = new Ext();
        $user->setExt($ext);
        $this->assertSame($ext, $user->getExt());
    }
}
