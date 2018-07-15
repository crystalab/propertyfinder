<?php
namespace PropertyFinder\Travel\BoardingPass;

class Train extends BoardingPass
{
    public function __construct(string $source, string $destination, string $routeNo, string $seat = null)
    {
        parent::__construct($source, $destination, $routeNo, $seat);
    }
}
