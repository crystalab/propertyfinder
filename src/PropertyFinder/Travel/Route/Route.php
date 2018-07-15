<?php
namespace PropertyFinder\Travel\Route;

class Route
{
    /** @var RouteLeg[] */
    private $routeLegs;
    
    public function __construct(array $routeLegs)
    {
        $this->routeLegs = $routeLegs;
    }
    
    /** @return RouteLeg[] */
    public function getRouteLegs(): array
    {
        return $this->routeLegs;
    }
    
    public function isEmpty(): bool
    {
        return empty($this->routeLegs);
    }
}
