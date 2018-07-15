<?php
namespace PropertyFinder\Travel\BoardingPass;

class AirportBus extends BoardingPass
{
    public function __construct(string $source, string $destination)
    {
        parent::__construct($source, $destination);
    }
}
