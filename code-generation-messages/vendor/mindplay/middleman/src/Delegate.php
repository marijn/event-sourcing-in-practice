<?php

namespace mindplay\middleman;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * PSR-15 delegate wrapper for internal callbacks generated by {@see Dispatcher} during dispatch.
 *
 * @internal
 */
class Delegate implements RequestHandlerInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback function (RequestInterface $request) : ResponseInterface
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func($this->callback, $request);
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * This method duplicates `next()` to provide backwards compatibility with non-PSR 15 middleware.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return call_user_func($this->callback, $request);
    }
}
