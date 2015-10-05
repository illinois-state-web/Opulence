<?php
/**
 * Copyright (C) 2015 David Young
 *
 * Defines the request bootstrapper
 */
namespace Opulence\Framework\Bootstrappers\HTTP\Requests;

use Opulence\Applications\Bootstrappers\Bootstrapper;
use Opulence\HTTP\Requests\Request as HTTPRequest;
use Opulence\IoC\IContainer;

class RequestBootstrapper extends Bootstrapper
{
    /**
     * @inheritdoc
     */
    public function registerBindings(IContainer $container)
    {
        $container->bind(HTTPRequest::class, HTTPRequest::createFromGlobals());
    }
}