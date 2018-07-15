<?php
namespace PropertyFinder\Travel\BoardingPass;

class Flight extends BoardingPass
{
    private $gate;
    private $luggageInfo;
    
    public function __construct(
        string $source,
        string $destination,
        string $routeNo,
        string $seat = null,
        string $gate = null,
        string $luggageInfo = null
    ) {
        parent::__construct($source, $destination, $routeNo, $seat);
        $this->gate = $gate;
        $this->luggageInfo = $luggageInfo;
    }
    
    public function hasGate(): bool
    {
        return $this->gate !== null;
    }
    
    public function getGate(): string
    {
        return $this->gate;
    }
    
    public function hasLuggageInfo(): bool
    {
        return $this->luggageInfo !== null;
    }
    
    public function getLuggageInfo(): string
    {
        return $this->luggageInfo;
    }
}
