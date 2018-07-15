<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\Bus;
use PropertyFinder\Travel\BoardingPass\BoardingPass;

class BusMessage implements Message
{
    public function formatMessage(BoardingPass $boardingPass): string
    {
        assert(self::supports($boardingPass));
    
        $pieces = [];
        
        $pieces[] = $boardingPass->hasRouteNo()
            ? sprintf("Take bus %s", $boardingPass->getRouteNo())
            : "Take bus";

        $pieces[] = sprintf("from %s to %s.", $boardingPass->getSource(), $boardingPass->getDestination());

        $pieces[] = $boardingPass->hasSeatAssignment()
            ? sprintf("Sit in seat %s.", $boardingPass->getSeat())
            : "No seat assignment.";
        
        return implode(" ", $pieces);
    }
    
    public static function supports(BoardingPass $boardingPass): bool
    {
        return $boardingPass instanceof Bus;
    }
}
