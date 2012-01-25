<?php

namespace Trsteel\CkeditorBundle\Tests\Form;

use Symfony\Tests\Component\Form\Extension\Core\Type\TypeTestCase;
use Trsteel\CkeditorBundle\Form\CkeditorType;

require_once __DIR__.'/../../../../../app/AppKernel.php';

class CkeditorTypeTest extends TypeTestCase
{

    protected static $kernel;
    protected static $container;
    
    public static function setUpBeforeClass()
    {
        self::$kernel = new \AppKernel('dev', true);
        self::$kernel->boot();

        self::$container = self::$kernel->getContainer();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->factory->addType(new CkeditorType($this->get('service_container')));
    }
    
    public function testAdd()
    {
        
//        echo '<pre>';print_r($this->get('service_container'));die();
        
        $result = 42;
        // assert that our calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}
