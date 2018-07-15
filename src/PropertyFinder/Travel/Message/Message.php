<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;

interface Message
{
    function formatMessage(BoardingPass $boardingPass): string;
    
    static function supports(BoardingPass $boardingPass): bool;
}
