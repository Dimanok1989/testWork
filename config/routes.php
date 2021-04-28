<?php

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try
{

    $routes = new RouteCollection();
    $routes->add('add_record', new Route('/addRecord', [
        '_controller' => \Kolgaev\Controllers\Records::class,
        '_method' => 'addRecord',
    ]));

    $routes->add('drop_record', new Route('/dropRecord', [
        '_controller' => \Kolgaev\Controllers\Records::class,
        '_method' => 'dropRecord',
    ]));

    $context = new RequestContext();

    $request = Request::createFromGlobals();
    $context->fromRequest($request);

    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo());

    $controller = new $parameters['_controller']();
    $response = $controller->{$parameters['_method']}($request);

}
catch (ResourceNotFoundException $e)
{
    http_response_code(404);
    echo $e->getMessage();
}
