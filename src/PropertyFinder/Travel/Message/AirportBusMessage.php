<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\AirportBus;
use PropertyFinder\Travel\BoardingPass\BoardingPass;

class AirportBusMessage implements Message
{
    public function formatMessage(BoardingPass $boardingPass): string
    {
        assert(self::supports($boardingPass));
        
        return sprintf(
            "Take the airport bus from %s to %s. No seat assignment",
            $boardingPass->getSource(),
            $boardingPass->getDestination()
        );
    }
    
    public static function supports(BoardingPass $boardingPass): bool
    {
        return $boardingPass instanceof AirportBus;
    }
}
