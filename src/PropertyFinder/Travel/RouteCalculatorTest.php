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
            new BoardingPass\Bus("Madrid", "Barcelona"),
            new BoardingPass\Bus("Barcelona", "Gerona Airport"),
            new BoardingPass\Bus("Gerona Airport", "Stockholm"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertCount(count($input), $actual->getRouteLegs());
    }
    
    /** @test */
    public function calculateRouteShouldReturnUnbrokenRoute()
    {
        $input = [
            new BoardingPass\Bus("Barcelona", "Gerona Airport"),
            new BoardingPass\Bus("Gerona Airport", "Stockholm"),
            new BoardingPass\Bus("Madrid", "Barcelona"),
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
            new BoardingPass\Bus("Madrid", "Barcelona"),
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
            new BoardingPass\Bus("Madrid", "Barcelona"),
            new BoardingPass\Bus("Moscow", "New York"),
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
            new BoardingPass\Bus("Madrid", "Barcelona"),
            new BoardingPass\Bus("Barcelona", "Madrid"),
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
            new BoardingPass\Bus("Madrid", "Barcelona"),
            new BoardingPass\Bus("Barcelona", "Moscow"),
            new BoardingPass\Bus("Barcelona", "New York"),
        ];
        
        $actual = $this->instance->calculateRoute($input);
        
        $this->assertNotEmpty($actual->getRouteLegs());
    }
}
