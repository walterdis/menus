<?php

namespace Lavary\Menus\Tests;

use Lavary\Menus\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Menu builder instance
     *
     * @var \Lavary\Menus\Manager
     */
    protected $manager;

    protected function setUp()
    {
        $configuration = $this->getMockBuilder('\Lavary\Menus\Configuration\Configuration', ['get'])->getMock();
        $matcher       = $this->getMockBuilder('\Lavary\Menus\UriMatcher\Matcher')->getMock();

        $configuration->expects($this->any())
                      ->method('get')
                      ->will($this->returnValue('bar'));

        $this->manager = new Manager($configuration, $matcher);
    }

    protected function tearDown()
    {
    }

    public function testConfig()
    {
        $this->assertEquals('bar', $this->manager->config('foo'));
    }

    public function testGetLastGroupPrefix()
    {
        $this->manager->updateGroupStack(['prefix' => 'foo/test']);
        $this->manager->updateGroupStack(['prefix' => 'bar']);

        $this->assertEquals('foo/test/bar', $this->manager->getLastGroupPrefix());
    }

    public function testPrefix()
    {
        $this->manager->updateGroupStack(['prefix' => 'foo/bar']);
        
        $this->assertEquals('foo/bar/page/url', $this->manager->prefix('page/url'));
    }

    public function testExtractAttributes()
    {
        $this->manager->updateGroupStack(['url' => 'dummyUrl', 'prefix' => 'foo/bar', 'data-role' => 'test', 'class' => 'test-class']);
        $this->manager->updateGroupStack(['prefix' => 'test']);
        $attributes = $this->manager->extractAttributes(['class' => 'another-test-class']);
        
        $this->assertEquals('another-test-class test-class', $attributes['class']);
        $this->assertArrayNotHasKey('urs', $attributes);
    }

    public function testGroup()
    {
        $item = $this->getMockBuilder('\Lavary\Menus\Item')
                     ->disableOriginalConstructor()
                     ->getMock();

        $this->manager->group(['prefix' => 'foo/bar',    'class' => 'test-class', 'data-role' => 'item'], function () use ($item) {
             $this->manager->group(['prefix' => 'test/prefix', 'class' => 'another-test-class'], function () {
                $this->assertEquals('foo/bar/test/prefix', $this->manager->getLastGroupPrefix());
             }, $item);
                $this->assertEquals('foo/bar', $this->manager->getLastGroupPrefix());
        }, $item);
    }
}
