<?php
namespace PropertyFinder\Travel;

use PropertyFinder\Travel\BoardingPass\BoardingPass;

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
     * Generate directions for a route described with a list of boarding passes.
     *
     * @param BoardingPass[] $boardingPasses                                     Unsorted list of boarding passes,
     *                                                                           each element of a list should be
     *                                                                           an instance derived from `BoardingPass`
     *                                                                           see `BoardingPass` namespace
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
