<?php
namespace PropertyFinder\Travel;

class RoutePresenter
{
    const MESSAGE_YOU_HAVE_ARRIVED = "You have arrived at your final destination.";

    private $messageFactory;
    
    public function __construct(Message\CachingFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }
    
    public function routeToText(Route\Route $route): string
    {
        if ($route->isEmpty()) {
            return "";
        }
        
        $blocks = [];
        foreach ($route->getRouteLegs() as $routeLeg) {
            $message = $this->messageFactory->getInstanceFor($routeLeg->getBoardingPass());
            $blocks[] = $message->formatMessage($routeLeg->getBoardingPass());
        }
        
        $blocks[] = self::MESSAGE_YOU_HAVE_ARRIVED;
        return implode(PHP_EOL, $blocks);
    }
}
