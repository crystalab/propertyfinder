<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;

abstract class Message
{
    abstract public function formatMessage(BoardingPass $boardingPass): string;
    
    abstract static public function supports(BoardingPass $boardingPass): bool;
}
