<?php

namespace Maxmind\Bundle\GeoipBundle\Tests\GeoipManager;

use Maxmind\Bundle\GeoipBundle\Service\GeoipManager;

class GeoipManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $ip;
    protected $otherIp;
    protected $geoipManager;

    /**
     * Initialize the ip variables and loads the data.
     */
    public function setUp()
    {
        $this->ip = '88.160.233.80';
        $this->otherIp = '72.229.28.185';
        $this->geoipManager = new GeoipManager(__DIR__.'/../data/GeoLiteCity.dat');
    }

    public function testLookup()
    {
        $manager = $this->geoipManager;
        $this->assertFalse($manager->lookup('dummy'));
        $this->assertEquals(GeoipManager::class, get_class($manager->lookup($this->ip)));
        $this->assertEquals(GeoipManager::class, get_class($manager->lookup($this->otherIp)));
    }

    public function testGetCountryCode()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getCountryCode());
        $this->assertNull($manager->getCountryCode('dummy'));

        $this->assertEquals('FR', $manager->getCountryCode($this->ip));
        $this->assertEquals('FR', $manager->getCountryCode());

        $this->assertEquals('US', $manager->getCountryCode($this->otherIp));
        $this->assertEquals('US', $manager->getCountryCode());
    }

    public function testGetCountryCode3()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getCountryCode3());
        $this->assertNull($manager->getCountryCode3('dummy'));

        $this->assertEquals('FRA', $manager->getCountryCode3($this->ip));
        $this->assertEquals('FRA', $manager->getCountryCode3());

        $this->assertEquals('USA', $manager->getCountryCode3($this->otherIp));
        $this->assertEquals('USA', $manager->getCountryCode3());
    }

    public function testGetCountryName()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getCountryName());
        $this->assertNull($manager->getCountryName('dummy'));

        $this->assertEquals('France', $manager->getCountryName($this->ip));
        $this->assertEquals('France', $manager->getCountryName());

        $this->assertEquals('United States', $manager->getCountryName($this->otherIp));
        $this->assertEquals('United States', $manager->getCountryName());
    }

    public function testGetRegionCode()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getRegionCode());
        $this->assertNull($manager->getRegionCode('dummy'));

        $this->assertEquals('B9', $manager->getRegionCode($this->ip));
        $this->assertEquals('B9', $manager->getRegionCode());

        $this->assertEquals('NY', $manager->getRegionCode($this->otherIp));
        $this->assertEquals('NY', $manager->getRegionCode());
    }

    public function testGetRegion()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getRegion());
        $this->assertNull($manager->getRegion('dummy'));

        $this->assertEquals('Rhone-Alpes', $manager->getRegion($this->ip));
        $this->assertEquals('Rhone-Alpes', $manager->getRegion());

        $this->assertEquals('New York', $manager->getRegion($this->otherIp));
        $this->assertEquals('New York', $manager->getRegion());
    }

    public function testGetCity()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getCity());
        $this->assertNull($manager->getCity('dummy'));

        $this->assertEquals('Villeurbanne', $manager->getCity($this->ip));
        $this->assertEquals('Villeurbanne', $manager->getCity());

        $this->assertEquals('New York', $manager->getCity($this->otherIp));
        $this->assertEquals('New York', $manager->getCity());
    }

    public function testGetPostalCode()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getPostalCode());
        $this->assertNull($manager->getPostalCode('dummy'));

        $this->assertEquals('69100', $manager->getPostalCode($this->ip));
        $this->assertEquals('69100', $manager->getPostalCode());

        $this->assertEquals('10036', $manager->getPostalCode($this->otherIp));
        $this->assertEquals('10036', $manager->getPostalCode());
    }

    public function testGetLatitude()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getLatitude());
        $this->assertNull($manager->getLatitude('dummy'));

        $this->assertTrue($this->compareFloat(45.7655, $manager->getLatitude($this->ip)));
        $this->assertTrue($this->compareFloat(45.7655, $manager->getLatitude()));

        $this->assertTrue($this->compareFloat(40.7605, $manager->getLatitude($this->otherIp)));
        $this->assertTrue($this->compareFloat(40.7605, $manager->getLatitude()));
    }

    public function testGetAreaCode()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getAreaCode());
        $this->assertNull($manager->getAreaCode('dummy'));

        $this->assertNull($manager->getAreaCode($this->ip));
        $this->assertNull($manager->getAreaCode());

        $this->assertSame(212, $manager->getAreaCode($this->otherIp));
        $this->assertSame(212, $manager->getAreaCode());
    }

    public function testGetMetroCode()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getMetroCode());
        $this->assertNull($manager->getMetroCode('dummy'));

        $this->assertNull($manager->getMetroCode($this->ip));
        $this->assertNull($manager->getMetroCode());

        $this->assertSame(501.0, $manager->getMetroCode($this->otherIp));
        $this->assertSame(501.0, $manager->getMetroCode());
    }

    public function testGetContinentCode()
    {
        $manager = $this->geoipManager;

        $this->assertNull($manager->getContinentCode());
        $this->assertNull($manager->getContinentCode('dummy'));

        $this->assertEquals('EU', $manager->getContinentCode($this->ip));
        $this->assertEquals('EU', $manager->getContinentCode());

        $this->assertEquals('NA', $manager->getContinentCode($this->otherIp));
        $this->assertEquals('NA', $manager->getContinentCode());
    }

    /**
     * Explanation for this function :
     * http://www.php.net/manual/en/language.types.float.php#language.types.float.comparison
     * TLDR : float type has precision issues.
     *
     * @param float $a : 1st number to compare
     * @param float $b : 2nd number to compare
     *
     * @return true if the numbers are equal at 0.00001 precision
     */
    private function compareFloat($a, $b)
    {
        if (abs($a - $b) < 0.00001) {
            return true;
        }

        return false;
    }
}
