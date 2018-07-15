<?php
namespace PropertyFinder\Travel;

use PHPUnit\Framework\TestCase;
use PropertyFinder\Travel\Route\RoutePresenter;

class TravelServiceTest extends TestCase
{
    /** @var TravelService */
    private $instance;
    
    protected function setUp()
    {
        $this->instance = new TravelService(
            $this->createMock(RouteCalculator::class),
            $this->createMock(RoutePresenter::class)
        );
    }
    
    /** @test */
    public function getDirectionsShouldReturnEmptyStringWhenNoTicketsProvided()
    {
        $actual = $this->instance->getDirections([]);
        
        $this->assertEmpty("", $actual);
    }
}
