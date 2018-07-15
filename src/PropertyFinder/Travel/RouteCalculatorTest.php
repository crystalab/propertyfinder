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
    
    /** @test */
    public function calculateRouteShouldWorksWithOnlyOneBoardingPass()
    {
        $input = [
            new BoardingPass\Train("Madrid", "Barcelona"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertNotEmpty($actual->getRouteLegs());
    }
    
    /**
     * @test @expectedException PropertyFinder\Travel\Exception\RouteNotFoundException
     */
    public function calculateRouteShouldThrowExceptionWhenBrokenRouteProvided()
    {
        $input = [
            new BoardingPass\Train("Madrid", "Barcelona"),
            new BoardingPass\Train("Moscow", "New York"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertNotEmpty($actual->getRouteLegs());
    }
    
    /**
     * @test @expectedException PropertyFinder\Travel\Exception\ChainedRouteException
     */
    public function calculateRouteShouldThrowExceptionWhenChainedRouteProvided()
    {
        $input = [
            new BoardingPass\Train("Madrid", "Barcelona"),
            new BoardingPass\Train("Barcelona", "Madrid"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertNotEmpty($actual->getRouteLegs());
    }
    
    /**
     * @test @expectedException PropertyFinder\Travel\Exception\CrossedRouteException
     */
    public function calculateRouteShouldThrowExceptionWhenMultipleBoardingPassWithSameSourceOrDestinationProvided()
    {
        $input = [
            new BoardingPass\Train("Madrid", "Barcelona"),
            new BoardingPass\Train("Barcelona", "Moscow"),
            new BoardingPass\Train("Barcelona", "New York"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertNotEmpty($actual->getRouteLegs());
    }
}
