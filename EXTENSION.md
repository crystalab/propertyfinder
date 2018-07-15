# Extension
 
## Adding new type of boarding type

1. Under `PropertyFinder\Travel\BoardingPass` namespace create new class for required boarding pass type;
2. Extend it from `BoardingPass` class that located in the same namespace;
3. Override constructor and add additional information if needed;
4. Under `PropertyFinder\Travel\Message` namespace create new message class;
5. Implement `Message` interface that located in the same namespace;
6. The `supports` method should return true if message class supports messaging for the given boarding pass. 
  Usually checking instance of boarding pass is enough, but you could also check any other things, 
  like values of optional fields; 
7. The `formatMessage` method should return string that represented boarding pass information in form of direction.
8. Include new message class name in `CachingFactory` class to `$messageClasses` private variable.

## Example

Let's go through extending process. 
Suppose we need to add boarding pass for Spaceship. Additionally to common information,
it also may contain information about on-board dress-code.  

### Create new boarding type class

First, we need to create class that will describe Spaceship boarding pass.
```php
<?php
namespace PropertyFinder\Travel\BoardingPass;

class Spaceship extends BoardingPass
{
    // Field to save dresscode information
    private $dresscode;
    
    public function __construct(string $source, string $destination, string $routeNo, string $dresscode = null)
    {
        parent::__construct($source, $destination, $routeNo);
        $this->dresscode = $dresscode;
    }

    // The dresscode is optional, so we need to be able to check if it specified
    public function hasDresscode(): bool
    {
        return $this->dresscode !== null;
    }

    public function getDresscode(): string
    {
        return $this->dresscode;
    }
}
```

### Create new message classes

Second, we need to create message class for representing boarding pass information. 
Suppose we want two different messages:

One for boarding passes with dresscode:
```php
<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;
use PropertyFinder\Travel\BoardingPass\Spaceship;

class SpaceshipDresscodeMessage implements Message
{
    /**
     * @param Spaceship $boardingPass
     *
     * @return string
     */
    function formatMessage(BoardingPass $boardingPass): string
    {
        assert(self::supports($boardingPass));
    
        $pieces = [];
    
        $pieces[] = sprintf("Take spaceship %s", $boardingPass->getRouteNo());
        $pieces[] = sprintf("from %s to %s.", $boardingPass->getSource(), $boardingPass->getDestination());
        $pieces[] = $boardingPass->getDresscode();
        
        return implode(" ", $pieces);
    }
    
    static function supports(BoardingPass $boardingPass): bool
    {
        return ($boardingPass instanceof Spaceship) && $boardingPass->hasDresscode();
    }
}
```

Another one for boarding passes without dresscode:
```php
<?php
namespace PropertyFinder\Travel\Message;

use PropertyFinder\Travel\BoardingPass\BoardingPass;
use PropertyFinder\Travel\BoardingPass\Spaceship;

class SpaceshipUndresscodedMessage implements Message
{
    /**
     * @param Spaceship $boardingPass
     *
     * @return string
     */
    function formatMessage(BoardingPass $boardingPass): string
    {
        assert(self::supports($boardingPass));
    
        $pieces = [];
    
        $pieces[] = sprintf("Take spaceship %s", $boardingPass->getRouteNo());
        $pieces[] = sprintf("from %s to %s.", $boardingPass->getSource(), $boardingPass->getDestination());
        $pieces[] = "There is no dresscode on the board";
        
        return implode(" ", $pieces);
    }
    
    static function supports(BoardingPass $boardingPass): bool
    {
        return ($boardingPass instanceof Spaceship) && !$boardingPass->hasDresscode();
    }
}
```

### Register created message classes

Finally, we need to append `$messageClasses` variable of `CachingFactory` class with names of created messages

```php
...
class CachingFactory
{
    private $messageClasses = [
        AirportBusMessage::class,
        BusMessage::class,
        FlightMessage::class,
        TrainMessage::class,
        SpaceshipDresscodeMessage::class,
        SpaceshipUndresscodedMessage::class,
    ];
...
```

