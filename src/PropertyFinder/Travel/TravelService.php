<?php
namespace PropertyFinder\Travel;

class TravelService
{
    private $routeCalculator;
    
    public function __construct(RouteCalculator $routeCalculator)
    {
        $this->routeCalculator = $routeCalculator;
    }
    
    /**
     * @param \PropertyFinder\Travel\BoardingPass\BoardingPass[] $boardingPasses
     *
     * @return string Directions
     */
    public function getDirections(array $boardingPasses): string
    {
        return "";
    }
}
