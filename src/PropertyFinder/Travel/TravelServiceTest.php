<?php
namespace PropertyFinder\Travel;

use PHPUnit\Framework\TestCase;

class TravelServiceTest extends TestCase
{
    /** @var TravelService */
    private $instance;
    
    protected function setUp()
    {
        $this->instance = new TravelService();
    }
    
    /** @test */
    public function getDirectionsShouldReturnEmptyStringWhenNoTicketsProvided()
    {
        $actual = $this->instance->getDirections([]);
        
        $this->assertEmpty("", $actual);
    }
}
