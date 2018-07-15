<?php
namespace PropertyFinder\Travel;

use PHPUnit\Framework\TestCase;

class RoutePresenterTest extends TestCase
{
    /** @var RoutePresenter */
    private $instance;
    
    protected function setUp()
    {
        $this->instance = new RoutePresenter();
    }
    
    /** @test */
    public function routeToTextShouldReturnEmptyStringWhenEmptyRouteProvided()
    {
        $actual = $this->instance->routeToText([]);
        
        $this->assertEmpty($actual);
    }
}
