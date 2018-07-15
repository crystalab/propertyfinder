<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;
use PropertyFinder\Travel\BoardingPass\Train;

class TrainMessage implements Message
{
    public function formatMessage(BoardingPass $boardingPass): string
    {
        assert(self::supports($boardingPass));

        $pieces = [];
        
        $pieces[] = sprintf(
            "Take train %s from %s to %s.",
            $boardingPass->getRouteNo(),
            $boardingPass->getSource(),
            $boardingPass->getDestination()
        );

        $pieces[] = $boardingPass->hasSeatAssignment()
            ? sprintf("Sit in seat %s.", $boardingPass->getSeat())
            : "No seat assignment.";
        
        return implode(" ", $pieces);
    }
    
    static public function supports(BoardingPass $boardingPass): bool
    {
        return $boardingPass instanceof Train;
    }
}
