<?php
namespace PropertyFinder\Travel\BoardingPass;

abstract class BoardingPass
{
    private $source;
    private $destination;
    private $routeNo;
    private $seat;
    
    public function __construct(
        string $source,
        string $destination,
        string $routeNo = null,
        string $seat = null
    ) {
        $this->source = $source;
        $this->destination = $destination;
        $this->routeNo = $routeNo;
        $this->seat = $seat;
    }
    
    public function getSource(): string
    {
        return $this->source;
    }
    
    public function getDestination(): string
    {
        return $this->destination;
    }
    
    public function getRouteNo()
    {
        return $this->routeNo;
    }
    
    public function hasRouteNo(): bool
    {
        return $this->routeNo !== null;
    }
    
    public function getSeat()
    {
        return $this->seat;
    }
    
    public function hasSeatAssignment(): bool
    {
        return $this->seat !== null;
    }
}
