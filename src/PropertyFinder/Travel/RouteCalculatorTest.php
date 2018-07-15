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
    public function calculateRouteShouldReturnEmptyRouteWhenNoTicketsProvided()
    {
        $actual = $this->instance->calculateRoute([]);
        
        $this->assertInstanceOf(Route\Route::class, $actual);
        $this->assertTrue($actual->isEmpty());
    }
    
    /** @test */
    public function calculateRouteShouldReturnLegForEachBoardingPass()
    {
        $input = [
            new BoardingPass\Train("Madrid", "Barcelona"),
            new BoardingPass\Train("Barcelona", "Gerona Airport"),
            new BoardingPass\Train("Gerona Airport", "Stockholm"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertCount(count($input), $actual->getRouteLegs());
    }
}
