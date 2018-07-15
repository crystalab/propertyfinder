<?php
namespace PropertyFinder\Travel;

class RoutePresenter
{
    const MESSAGE_YOU_HAVE_ARRIVED = "You have arrived at your final destination.";
    
    public function routeToText(Route\Route $route): string
    {
        if ($route->isEmpty()) {
            return "";
        }
        
        $blocks = [];
        
        $blocks[] = self::MESSAGE_YOU_HAVE_ARRIVED;
        return implode(PHP_EOL, $blocks);
    }
}
