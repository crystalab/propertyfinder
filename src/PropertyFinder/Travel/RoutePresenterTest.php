<?php
namespace PropertyFinder\Travel;

use PHPUnit\Framework\TestCase;
use PropertyFinder\Travel\BoardingPass\AirportBus;
use PropertyFinder\Travel\BoardingPass\Train;

class RoutePresenterTest extends TestCase
{
    /** @var RoutePresenter */
    private $instance;
    
    protected function setUp()
    {
        $this->instance = new RoutePresenter(
            new Message\CachingFactory()
        );
    }
    
    /** @test */
    public function routeToTextShouldReturnMessageWhenEmptyRouteProvided()
    {
        $actual = $this->instance->routeToText(new Route\Route([]));
        
        $this->assertContains("", $actual);
    }

    /** @test */
    public function routeToTextShouldAppendTextWithArrivedMessage()
    {
        $actual = $this->instance->routeToText(
            new Route\Route([
                new Route\RouteLeg(new Train("Madrid", "Barcelona", "78A", "45B")),
            ])
        );
        
        $this->assertStringEndsWith(RoutePresenter::MESSAGE_YOU_HAVE_ARRIVED, $actual);
    }

    /** @test */
    public function routeToTextShouldReturnTextThatContainsSourceAndDestination()
    {
        $actual = $this->instance->routeToText(
            new Route\Route(
                [
                    new Route\RouteLeg(new Train("Madrid", "Barcelona", "78A", "45B")),
                    new Route\RouteLeg(new AirportBus("Barcelona", "Gerona Airport")),
                ]
            )
        );
    
        $this->assertRegExp("/.*Madrid.*Barcelona.*Barcelona.*Gerona Airport.*/s", $actual);
    }
}
