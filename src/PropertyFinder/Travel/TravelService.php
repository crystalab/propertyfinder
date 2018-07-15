<?php
namespace PropertyFinder\Travel;

class TravelService
{
    private $routeCalculator;
    private $routePresenter;
    
    public function __construct(RouteCalculator $routeCalculator, RoutePresenter $routePresenter)
    {
        $this->routeCalculator = $routeCalculator;
        $this->routePresenter = $routePresenter;
    }
    
    /**
     * @param \PropertyFinder\Travel\BoardingPass\BoardingPass[] $boardingPasses
     *
     * @return string Directions
     */
    public function getDirections(array $boardingPasses): string
    {
        return $this->routePresenter->routeToText(
            $this->routeCalculator->calculateRoute($boardingPasses)
        );
    }
}
