<?php
namespace PropertyFinder\Travel;

use PHPUnit\Framework\TestCase;

class RouteCalculatorTest extends TestCase
{
    /** @var RouteCalculator */
    private $instance;
    
    protected function setUp()
    {
        $this->instance = new RouteCalculator();
    }
    
    /** @test */
    public function calculateRouteShouldReturnEmptyArrayWhenNoTicketsProvided()
    {
        $actual = $this->instance->calculateRoute([]);
        
        $this->assertInternalType("array", $actual);
        $this->assertEmpty($actual);
    }
}
