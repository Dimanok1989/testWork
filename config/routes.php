<?php

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Kolgaev\MyExceptions;

try {

    $routes = new RouteCollection();

    $routes->add('main_page', new Route('/', [
        '_controller' => \Kolgaev\Controllers\Pages::class,
        '_method' => 'main',
    ]));

    $routes->add('records_page', new Route('/records', [
        '_controller' => \Kolgaev\Controllers\Pages::class,
        '_method' => 'records',
    ]));

    $routes->add('add_record', new Route('/addRecord', [
        '_controller' => \Kolgaev\Controllers\Records::class,
        '_method' => 'addRecord',
    ]));

    $routes->add('drop_record', new Route('/dropRecord', [
        '_controller' => \Kolgaev\Controllers\Records::class,
        '_method' => 'dropRecord',
    ]));

    $routes->add('show_record', new Route('/showRecords', [
        '_controller' => \Kolgaev\Controllers\Records::class,
        '_method' => 'showRecords',
    ]));

    $context = new RequestContext();

    $request = Request::createFromGlobals();
    $context->fromRequest($request);

    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo());

    if (!class_exists($parameters['_controller']))
        throw new MyExceptions("Контроллер <b>{$parameters['_controller']}</b> не найден", __FILE__, __LINE__);

    $controller = new $parameters['_controller']();

    if (!method_exists($controller, $parameters['_method']))
        throw new MyExceptions("Метод <b>{$parameters['_method']}</b> отсутствует в контроллере <b>{$parameters['_controller']}</b>", __FILE__, __LINE__);

    $params[] = $request;

    $controller->{$parameters['_method']}(...$params);

}
catch (ResourceNotFoundException $e) {
    http_response_code(404);
    die($e->getMessage());
} 
catch (MyExceptions $e) {
    die($e->getMessageError());
}
