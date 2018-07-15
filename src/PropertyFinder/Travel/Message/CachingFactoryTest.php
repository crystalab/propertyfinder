<?php
namespace PropertyFinder\Travel\Message;

use PHPUnit\Framework\TestCase;
use PropertyFinder\Travel\BoardingPass\BoardingPass;
use PropertyFinder\Travel\BoardingPass\Train;

class CachingFactoryTest extends TestCase
{
    /** @var CachingFactory */
    private $instance;
    
    protected function setUp()
    {
        $this->instance = new CachingFactory();
    }
    
    /** @test @expectedException PropertyFinder\Travel\Message\Exception\MessageNotFoundException */
    public function getInstanceShouldThrowExceptionWhenUnsupportedBoardingPassProvided()
    {
        $this->instance->getInstanceFor(
            $this->getMockForAbstractClass(BoardingPass::class, ["Madrid", "Barcelona"])
        );
    }
    
    /** @test */
    public function getInstanceShouldReturnAppropriateMessageForBoardingPass()
    {
        $boardingPass = new Train("Madrid", "Barcelona", "A2");
        
        $actual = $this->instance->getInstanceFor($boardingPass);
        
        $this->assertTrue($actual::supports($boardingPass));
    }
    
    /** @test */
    public function getInstanceShouldCacheCreatedInstances()
    {
        $boardingPass = new Train("Madrid", "Barcelona", "A2");
        
        $actual1 = $this->instance->getInstanceFor($boardingPass);
        $actual2 = $this->instance->getInstanceFor($boardingPass);
        
        $this->assertSame($actual1, $actual2);
    }
}
