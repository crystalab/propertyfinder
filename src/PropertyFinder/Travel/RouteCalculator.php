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
        if (empty($boardingPasses)) {
            return new Route\Route([]);
        }
        
        $sortedPasses = $this->sortBoardingPasses($boardingPasses);
        
        return new Route\Route(
            array_map(function (BoardingPass $boardingPass) {
                return new Route\RouteLeg($boardingPass);
            }, $sortedPasses)
        );
    }
    
    /**
     * @param BoardingPass[] $boardingPasses
     *
     * @return BoardingPass[]
     */
    private function sortBoardingPasses(array $boardingPasses): array
    {
        /** @var BoardingPass[] $sourceMap */
        $sourceMap = [];
        /** @var BoardingPass[] $destinationMap */
        $destinationMap = [];
        
        // 1) Put all source and destinations into hash map
        foreach ($boardingPasses as $boardingPass) {
            $source = $boardingPass->getSource();
            $destination = $boardingPass->getDestination();

            if (isset($sourceMap[$source]) || isset($destinationMap[$destination])) {
                throw new Exception\CrossedRouteException();
            }
            
            $sourceMap[$source] = $boardingPass;
            $destinationMap[$destination] = $boardingPass;
        }

        // 2) Search for beginning of our route, it will be location without destination to it
        $firstPass = null;
        foreach ($boardingPasses as $boardingPass) {
            if (!isset($destinationMap[$boardingPass->getSource()])) {
                $firstPass = $boardingPass;
            }
        }
        
        if ($firstPass === null) {
            throw new Exception\ChainedRouteException();
        }
        
        // 3) Traverse through boarding passes from the beginning
        $sortedPasses = [$firstPass];
        $currentPass = $firstPass;
        while (isset($sourceMap[$currentPass->getDestination()])) {
            $currentPass = $sourceMap[$currentPass->getDestination()];
            $sortedPasses[] = $currentPass;
        }
        
        if (count($sortedPasses) !== count($boardingPasses)) {
            throw new Exception\RouteNotFoundException();
        }
        
        return $sortedPasses;
    }
}
