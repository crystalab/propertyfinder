<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;
use PropertyFinder\Travel\BoardingPass\Flight;

class FlightMessage extends Message
{
    /** @param Flight $boardingPass */
    public function formatMessage(BoardingPass $boardingPass): string
    {
        assert(self::supports($boardingPass));

        $pieces = [];
        
        $pieces[] = sprintf(
            "From %s, take flight %s to %s",
            $boardingPass->getSource(),
            $boardingPass->getRouteNo(),
            $boardingPass->getDestination()
        );

        $pieces[] = $boardingPass->hasGate()
            ? sprintf("Gate %s,", $boardingPass->getSeat())
            : "No gate information,";

        $pieces[] = $boardingPass->hasSeatAssignment()
            ? sprintf("sit in seat %s.", $boardingPass->getSeat())
            : "no seat assignment.";
        
        if ($boardingPass->hasLuggageInfo()) {
            $pieces[] = $boardingPass->getLuggageInfo();
        }
        
        return implode(" ", $pieces);
    }
    
    public static function supports(BoardingPass $boardingPass): bool
    {
        return $boardingPass instanceof Flight;
    }
}
