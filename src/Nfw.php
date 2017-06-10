<?php
namespace raczsimon\nfw;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

class Nfw
{
    private $routes;
    
    public function setRoutes($routes = [])
    {
        $this->routes = $routes;
    }
    
    private function addRoutes()
    {
        $routes = new RouteCollection();
        var_dump($this->routes);
        
        foreach ($this->routes as $key => $route) {
            $routes->add($key, $route);
        }
        
        return $routes;
    }
    
    private function createInstance()
    {
        $routes = $this->addRoutes();
        
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());
        
        // Match
        $matcher = new UrlMatcher($routes, $context);
        $parameters = $matcher->match($this->getCurrentURI());
        
        return $parameters;
    }
    
    public function startSession()
    {
        $instance = $this->createInstance();
        
        $controller = str_replace(':', '\\', $instance['_controller']);
        $controller = new $controller;
        $controller->setReflect((object) $instance); 
        $controller->init();
    }
    
    public function getCurrentURI()
    {
        return '/' . str_replace(
            str_replace(basename($_SERVER["SCRIPT_FILENAME"]), '', $_SERVER['PHP_SELF']),
            '',
            $_SERVER['REQUEST_URI']);
    }
}