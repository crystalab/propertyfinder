<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;

class CachingFactory
{
    private $messageClasses = [
        AirportBusMessage::class,
        BusMessage::class,
        FlightMessage::class,
        TrainMessage::class,
    ];
    
    private $cache = [];
    
    public function getInstanceFor(BoardingPass $boardingPass): Message
    {
        foreach ($this->messageClasses as $messageClass) {
            if ($messageClass::supports($boardingPass)) {
                if (!isset($this->cache[$messageClass])) {
                    $this->cache[$messageClass] = new $messageClass;
                }
                
                return $this->cache[$messageClass];
            }
        }
        
        throw new Exception\MessageNotFoundException();
    }
}
