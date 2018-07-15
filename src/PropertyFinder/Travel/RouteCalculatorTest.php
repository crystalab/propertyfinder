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
    
    /** @test */
    public function calculateRouteShouldReturnUnbrokenRoute()
    {
        $input = [
            new BoardingPass\Train("Barcelona", "Gerona Airport"),
            new BoardingPass\Train("Gerona Airport", "Stockholm"),
            new BoardingPass\Train("Madrid", "Barcelona"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        /** @var Route\RouteLeg $prevLeg */
        $prevLeg = null;
        foreach ($actual->getRouteLegs() as $currentLeg) {
            if ($prevLeg === null) {
                $prevLeg = $currentLeg;
                continue;
            }
            
            $this->assertSame($prevLeg->getDestination(), $currentLeg->getSource());
            $prevLeg = $currentLeg;
        }
    }
}
