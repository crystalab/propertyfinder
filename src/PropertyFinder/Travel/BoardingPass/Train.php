<?php
namespace PropertyFinder\Travel\BoardingPass;

class Train extends BoardingPass
{
    public function __construct($source, $destination)
    {
        parent::__construct($source, $destination);
    }
}
