<?php
namespace PropertyFinder\Travel\Route;

use PropertyFinder\Travel\BoardingPass\BoardingPass;

class RouteLeg
{
    private $boardingPass;
    
    public function __construct(BoardingPass $boardingPass)
    {
        $this->boardingPass = $boardingPass;
    }
    
    public function getSource(): string
    {
        return $this->boardingPass->getSource();
    }
    
    public function getDestination(): string
    {
        return $this->boardingPass->getDestination();
    }
    
    public function getBoardingPass(): BoardingPass
    {
        return $this->boardingPass;
    }
}
