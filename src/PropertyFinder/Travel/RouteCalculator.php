<?php
namespace PropertyFinder\Travel;

use PropertyFinder\Travel\BoardingPass\BoardingPass;

class RouteCalculator
{
    /**
     * @param BoardingPass[] $boardingPasses
     *
     * @return Route\Route
     */
    public function calculateRoute(array $boardingPasses): Route\Route
    {
        return new Route\Route(
            array_map(function (BoardingPass $boardingPass) {
                return new Route\RouteLeg(
                    $boardingPass->getSource(),
                    $boardingPass->getDestination()
                );
            }, $boardingPasses)
        );
    }
}
